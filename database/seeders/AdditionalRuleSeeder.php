<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rule;
use App\Models\RuleCondition;

class AdditionalRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 5. Rule: Ganti Ban (Safety)
        // JIKA kondisi_ban = 'bald' (botak) ATAU 'cracked' (retak)
        $ruleTire = Rule::firstOrCreate(
            ['code' => 'R05'],
            [
                'name' => 'Penggantian Ban',
                'description' => 'Mendeteksi kondisi ban yang sudah tidak layak pakai (botak/retak).',
                'recommendation' => "BAHAYA! Ban kendaraan Anda sudah gundul atau retak.\nSegera ganti ban untuk menghindari risiko kecelakaan terutama saat hujan.",
                'action_list' => ['Ganti Ban Depan/Belakang', 'Cek Spooring Balancing (Mobil)'],
                'priority' => 15,
                'is_active' => true,
            ]
        );

        // Condition 1: Ban Botak
        RuleCondition::firstOrCreate([
            'rule_id' => $ruleTire->id,
            'fact_variable' => 'tire_condition',
            'operator' => '==',
            'value' => 'bald',
            'value_type' => 'string',
        ]);

         // Condition 2: Ban Retak (Kita buat rule terpisah atau multiple value logic - untuk simple-nya buat rule baru atau asumsi user pilih salah satu)
         // Untuk simplicity di forward chain saat ini, kita buat rule R05B untuk Retak jika user input cracked
        $ruleTireCrack = Rule::firstOrCreate(
            ['code' => 'R05B'],
            [
                'name' => 'Ban Retak/Getas',
                'description' => 'Mendeteksi ban yang usia pakainya sudah tua.',
                'recommendation' => "Karet ban Anda sudah keras/retak. Grip sudah berkurang signifikan.\nDisarankan untuk mengganti ban.",
                'action_list' => ['Ganti Ban'],
                'priority' => 14,
                'is_active' => true,
            ]
        );
        
        RuleCondition::firstOrCreate([
            'rule_id' => $ruleTireCrack->id,
            'fact_variable' => 'tire_condition',
            'operator' => '==',
            'value' => 'cracked',
            'value_type' => 'string',
        ]);


        // 6. Rule: Kelistrikan / Lampu
        $ruleLights = Rule::firstOrCreate(
            ['code' => 'R06'],
            [
                'name' => 'Perbaikan Kelistrikan/Lampu',
                'description' => 'Mendeteksi masalah pada sistem penerangan.',
                'recommendation' => "Komponen penerangan/kelistrikan ada yang bermasalah.\nCek bohlam, sekring, atau aki kendaraan.",
                'action_list' => ['Ganti Bohlam Lampu', 'Cek Voltase Aki', 'Cek Kabel Body'],
                'priority' => 8,
                'is_active' => true,
            ]
        );

        RuleCondition::firstOrCreate([
            'rule_id' => $ruleLights->id,
            'fact_variable' => 'lights_condition',
            'operator' => '==',
            'value' => 'dead', // Mati
            'value_type' => 'string',
        ]);
        
        // Rule R06B untuk Dim (Redup)
        RuleCondition::firstOrCreate([
            'rule_id' => $ruleLights->id,
            'fact_variable' => 'lights_condition',
            'operator' => '==',
            'value' => 'dim', // Redup
            'value_type' => 'string',
        ]);
    }
}
