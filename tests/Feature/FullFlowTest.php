<?php

use App\Models\User;
use App\Models\Rule;
use App\Models\RuleCondition;
use App\Models\DiagnosisQuestion;
use App\Models\Consultation;
use App\Services\ForwardChainingService;
use Spatie\Permission\Models\Role;

// ============================================================
//  HELPERS
// ============================================================

/**
 * Create and return an Admin user (creates admin role on-demand).
 */
function createAdmin(): User
{
    // Ensure role exists
    Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

    $admin = User::factory()->create();
    $admin->assignRole('admin');

    return $admin;
}

/**
 * Create and return a regular (driver) user.
 */
function createUser(): User
{
    Role::firstOrCreate(['name' => 'user', 'guard_name' => 'web']);

    $user = User::factory()->create();
    $user->assignRole('user');

    return $user;
}

// ============================================================
//  FLOW 1: DIAGNOSIS QUESTIONS (Admin CRUD)
// ============================================================

describe('Diagnosis Questions – Admin CRUD', function () {

    it('admin can view the diagnosis questions list page', function () {
        $admin = createAdmin();

        $response = $this->actingAs($admin)->get(route('admin.diagnosis_questions.index'));
        $response->assertStatus(200);
    });

    it('admin can create a new diagnosis question with select options', function () {
        $admin = createAdmin();

        $payload = [
            'code'      => 'test_kondisi_ban',
            'question'  => 'Bagaimana kondisi ban kendaraan Anda?',
            'type'      => 'select',
            'options'   => json_encode([
                ['label' => 'Bagus', 'value' => 'good'],
                ['label' => 'Botak/Aus', 'value' => 'worn'],
            ]),
            'order'     => 99,
            'is_active' => true,
        ];

        $response = $this->actingAs($admin)->post(route('admin.diagnosis_questions.store'), $payload);

        $response->assertRedirect();
        $this->assertDatabaseHas('diagnosis_questions', ['code' => 'test_kondisi_ban']);
    });

    it('admin can update a diagnosis question', function () {
        $admin    = createAdmin();
        $question = DiagnosisQuestion::create([
            'code'      => 'q_test_update',
            'question'  => 'Pertanyaan lama',
            'type'      => 'select',
            'options'   => [['label' => 'Ya', 'value' => 'yes']],
            'order'     => 1,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->put(
            route('admin.diagnosis_questions.update', $question->id),
            [
                'code'      => 'q_test_update',
                'question'  => 'Pertanyaan yang sudah diubah',
                'type'      => 'select',
                'options'   => json_encode([['label' => 'Ya', 'value' => 'yes']]),
                'order'     => 1,
                'is_active' => true,
            ]
        );

        $response->assertRedirect();
        $this->assertDatabaseHas('diagnosis_questions', ['question' => 'Pertanyaan yang sudah diubah']);
    });

    it('admin can delete a diagnosis question', function () {
        $admin    = createAdmin();
        $question = DiagnosisQuestion::create([
            'code'      => 'q_test_delete',
            'question'  => 'Pertanyaan sementara',
            'type'      => 'select',
            'options'   => [['label' => 'Yes', 'value' => 'yes']],
            'order'     => 50,
            'is_active' => true,
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.diagnosis_questions.destroy', $question->id));

        $response->assertRedirect();
        $this->assertDatabaseMissing('diagnosis_questions', ['id' => $question->id]);
    });
});

// ============================================================
//  FLOW 2: RULES (Admin CRUD + Action List Parsing)
// ============================================================

describe('Rules – Admin CRUD dan Action List', function () {

    it('admin can view rules list page', function () {
        $admin = createAdmin();

        $response = $this->actingAs($admin)->get(route('admin.rules.index'));
        $response->assertStatus(200);
    });

    it('admin can create a rule, and action_list is saved as an array (using newline)', function () {
        $admin = createAdmin();

        $response = $this->actingAs($admin)->post(route('admin.rules.store'), [
            'code'           => 'R-TEST01',
            'name'           => 'Rule Test Oli',
            'description'    => 'Deskripsi rule test',
            'recommendation' => 'Kendaraan Anda memerlukan pengecekan oli segera.',
            'action_list'    => "Ganti Oli Mesin\nCek Filter Oli\nKuras Radiator",
            'priority'       => 5,
        ]);

        $response->assertRedirect();

        $rule = Rule::where('code', 'R-TEST01')->first();

        expect($rule)->not->toBeNull();
        expect($rule->action_list)->toBeArray();
        expect($rule->action_list)->toHaveCount(3);
        expect($rule->action_list[0])->toBe('Ganti Oli Mesin');
        expect($rule->action_list[1])->toBe('Cek Filter Oli');
        expect($rule->action_list[2])->toBe('Kuras Radiator');
    });

    it('action_list also handles Windows-style line endings (CRLF)', function () {
        $admin = createAdmin();

        $this->actingAs($admin)->post(route('admin.rules.store'), [
            'code'           => 'R-TEST02',
            'name'           => 'Rule CRLF Test',
            'description'    => null,
            'recommendation' => 'Rekomendasi untuk CRLF.',
            'action_list'    => "Langkah Pertama\r\nLangkah Kedua\r\nLangkah Ketiga",
            'priority'       => 1,
        ]);

        $rule = Rule::where('code', 'R-TEST02')->first();

        expect($rule->action_list)->toBeArray();
        expect($rule->action_list)->toHaveCount(3);
        expect($rule->action_list[2])->toBe('Langkah Ketiga');
    });

    it('admin can update a rule and its action_list is updated correctly', function () {
        $admin = createAdmin();
        $rule  = Rule::create([
            'code'           => 'R-EDIT01',
            'name'           => 'Rule Before Edit',
            'recommendation' => 'Lama',
            'action_list'    => ['Tindakan Lama'],
            'priority'       => 1,
            'is_active'      => true,
        ]);

        $this->actingAs($admin)->put(route('admin.rules.update', $rule->id), [
            'code'           => 'R-EDIT01',
            'name'           => 'Rule After Edit',
            'description'    => null,
            'recommendation' => 'Baru',
            'action_list'    => "Tindakan Baru Satu\nTindakan Baru Dua",
            'priority'       => 1,
        ]);

        $rule->refresh();

        expect($rule->name)->toBe('Rule After Edit');
        expect($rule->action_list)->toHaveCount(2);
        expect($rule->action_list[0])->toBe('Tindakan Baru Satu');
    });

    it('admin can delete a rule', function () {
        $admin = createAdmin();
        $rule  = Rule::create([
            'code'           => 'R-DEL01',
            'name'           => 'Rule To Delete',
            'recommendation' => '-',
            'action_list'    => [],
            'priority'       => 1,
            'is_active'      => true,
        ]);

        $this->actingAs($admin)->delete(route('admin.rules.destroy', $rule->id));

        $this->assertDatabaseMissing('rules', ['id' => $rule->id]);
    });
});

// ============================================================
//  FLOW 3: RULE CONDITIONS
// ============================================================

describe('Rule Conditions – Admin CRUD', function () {

    it('admin can view create condition form for a rule', function () {
        $admin = createAdmin();
        $rule  = Rule::create([
            'code'           => 'R-COND01',
            'name'           => 'Rule Kondisi',
            'recommendation' => '-',
            'action_list'    => [],
            'priority'       => 1,
            'is_active'      => true,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.rule_conditions.create', ['rule_id' => $rule->id]));
        $response->assertStatus(200);
    });

    it('admin can add a condition to a rule', function () {
        $admin = createAdmin();
        $rule  = Rule::create([
            'code'           => 'R-COND02',
            'name'           => 'Rule Kondisi Tambah',
            'recommendation' => '-',
            'action_list'    => [],
            'priority'       => 1,
            'is_active'      => true,
        ]);

        $response = $this->actingAs($admin)->post(route('admin.rule_conditions.store'), [
            'rule_id'       => $rule->id,
            'fact_variable' => 'oil_condition',
            'operator'      => '==',
            'value'         => 'bad',
            'value_type'    => 'string',
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('rule_conditions', [
            'rule_id'       => $rule->id,
            'fact_variable' => 'oil_condition',
            'value'         => 'bad',
        ]);
    });

    it('admin can delete a condition from a rule', function () {
        $admin = createAdmin();
        $rule  = Rule::create([
            'code'           => 'R-COND03',
            'name'           => 'Rule Kondisi Hapus',
            'recommendation' => '-',
            'action_list'    => [],
            'priority'       => 1,
            'is_active'      => true,
        ]);

        $condition = RuleCondition::create([
            'rule_id'       => $rule->id,
            'fact_variable' => 'brake_condition',
            'operator'      => '==',
            'value'         => 'bad',
            'value_type'    => 'string',
        ]);

        $response = $this->actingAs($admin)->delete(route('admin.rule_conditions.destroy', $condition->id));
        $response->assertRedirect();

        $this->assertDatabaseMissing('rule_conditions', ['id' => $condition->id]);
    });
});

// ============================================================
//  FLOW 4: CONSULTATION (Forward Chaining End-to-End)
// ============================================================

describe('Consultation – Forward Chaining End-to-End', function () {

    it('service correctly matches a rule when all conditions are met', function () {
        // Setup: Create a rule with 2 conditions
        $rule = Rule::create([
            'code'           => 'R-FC01',
            'name'           => 'Ganti Oli & Cek Rem',
            'recommendation' => 'Segera lakukan ganti oli dan cek rem.',
            'action_list'    => ['Ganti Oli Mesin', 'Periksa Kampas Rem'],
            'priority'       => 10,
            'is_active'      => true,
        ]);

        RuleCondition::create(['rule_id' => $rule->id, 'fact_variable' => 'oil_condition',   'operator' => '==', 'value' => 'bad',  'value_type' => 'string']);
        RuleCondition::create(['rule_id' => $rule->id, 'fact_variable' => 'brake_condition', 'operator' => '==', 'value' => 'bad',  'value_type' => 'string']);

        $service = app(ForwardChainingService::class);

        // Test: all conditions match → rule should fire
        $result = $service->analyze([
            'oil_condition'   => 'bad',
            'brake_condition' => 'bad',
        ]);

        expect($result['matched_rules'])->toHaveCount(1);
        expect($result['matched_rules'][0]->code)->toBe('R-FC01');
    });

    it('service does NOT match a rule when one condition fails', function () {
        $rule = Rule::create([
            'code'           => 'R-FC02',
            'name'           => 'Rule Partial Fail',
            'recommendation' => '-',
            'action_list'    => ['Test tindakan'],
            'priority'       => 10,
            'is_active'      => true,
        ]);

        RuleCondition::create(['rule_id' => $rule->id, 'fact_variable' => 'oil_condition',   'operator' => '==', 'value' => 'bad',  'value_type' => 'string']);
        RuleCondition::create(['rule_id' => $rule->id, 'fact_variable' => 'brake_condition', 'operator' => '==', 'value' => 'bad',  'value_type' => 'string']);

        $service = app(ForwardChainingService::class);

        // oil is bad, but brake is GOOD → rule should NOT match
        $result = $service->analyze([
            'oil_condition'   => 'bad',
            'brake_condition' => 'good',
        ]);

        expect(collect($result['matched_rules'])->where('code', 'R-FC02'))->toBeEmpty();
    });

    it('user can submit a consultation and is redirected to results page', function () {
        $user = createUser();

        // Setup rule that will be triggered
        $rule = Rule::create([
            'code'           => 'R-FC03',
            'name'           => 'Test Konsultasi AC',
            'recommendation' => 'Cek AC kendaraan Anda.',
            'action_list'    => ['Cek Freon', 'Servis Kompresor'],
            'priority'       => 5,
            'is_active'      => true,
        ]);

        RuleCondition::create([
            'rule_id'       => $rule->id,
            'fact_variable' => 'angin_ac',
            'operator'      => '==',
            'value'         => 'panas',
            'value_type'    => 'string',
        ]);

        $response = $this->actingAs($user)->post(route('consultation.store'), [
            'vehicle_type'  => 'Mobil',
            'vehicle_brand' => 'Toyota Avanza',
            'vehicle_year'  => 2020,
            'facts'         => [
                'angin_ac' => 'panas',
            ],
        ]);

        $response->assertRedirect();

        // Assert a consultation was recorded in DB
        $this->assertDatabaseHas('consultations', [
            'user_id'      => $user->id,
            'vehicle_brand' => 'Toyota Avanza',
        ]);
    });

    it('consultation result page shows the matched rule recommendations', function () {
        $user = createUser();

        $rule = Rule::create([
            'code'           => 'R-FC04',
            'name'           => 'Test Konsultasi Rem',
            'recommendation' => 'Segera cek sistem rem.',
            'action_list'    => ['Ganti Kampas Rem', 'Kuras Minyak Rem'],
            'priority'       => 5,
            'is_active'      => true,
        ]);

        RuleCondition::create([
            'rule_id'       => $rule->id,
            'fact_variable' => 'brake_condition',
            'operator'      => '==',
            'value'         => 'bad',
            'value_type'    => 'string',
        ]);

        // Simulate consultation submission
        $this->actingAs($user)->post(route('consultation.store'), [
            'vehicle_type'  => 'Mobil',
            'vehicle_brand' => 'Honda Jazz',
            'vehicle_year'  => 2019,
            'facts'         => ['brake_condition' => 'bad'],
        ]);

        // Get the consultation record
        $consultation = Consultation::where('user_id', $user->id)->latest()->first();

        // View the show page
        $response = $this->actingAs($user)->get(route('consultation.show', $consultation->id));

        $response->assertStatus(200);
        $response->assertSee('Ganti Kampas Rem');
        $response->assertSee('Kuras Minyak Rem');
    });
});
