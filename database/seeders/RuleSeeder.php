<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rule;
use App\Models\RuleCondition;

class RuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Rule: Ganti Oli (Prioritas Tinggi)
        // JIKA kondisi_oli = 'bad' MAKA Ganti Oli
        $ruleOil = Rule::create([
            'code' => 'R01',
            'name' => 'Wajib Ganti Oli',
            'description' => 'Mendeteksi kondisi oli yang sudah buruk atau hitam pekat.',
            'recommendation' => "Segera lakukan penggantian oli mesin.\nKualitas oli yang buruk dapat merusak komponen mesin internal.",
            'action_list' => ['Ganti Oli Mesin', 'Cek Filter Oli'],
            'priority' => 10,
            'is_active' => true,
        ]);

        RuleCondition::create([
            'rule_id' => $ruleOil->id,
            'fact_variable' => 'oil_condition',
            'operator' => '==',
            'value' => 'bad',
            'value_type' => 'string',
        ]);

        // 2. Rule: Servis Rem (Prioritas Sangat Tinggi - Safety)
        // JIKA kondisi_rem = 'bad' MAKA Cek Rem
        $ruleBrake = Rule::create([
            'code' => 'R02',
            'name' => 'Perbaikan Sistem Rem',
            'description' => 'Mendeteksi masalah pada pengereman seperti blong atau bunyi.',
            'recommendation' => "BAHAYA! Segera periksakan sistem pengereman Anda.\nGanti kampas rem jika sudah tipis dan cek minyak rem.",
            'action_list' => ['Ganti Kampas Rem', 'Kuras Minyak Rem', 'Cek Piringan Cakram'],
            'priority' => 20, // Lebih prioritas dari oli
            'is_active' => true,
        ]);

        RuleCondition::create([
            'rule_id' => $ruleBrake->id,
            'fact_variable' => 'brake_condition',
            'operator' => '==',
            'value' => 'bad',
            'value_type' => 'string',
        ]);

        // 3. Rule: Servis Besar / Tune Up (Berdasarkan Kilometer)
        // JIKA km_terakhir > 10000 MAKA Servis Besar
        $ruleMajorService = Rule::create([
            'code' => 'R03',
            'name' => 'Servis Besar (Tune Up)',
            'description' => 'Rekomendasi servis besar berdasarkan interval kilometer yang panjang.',
            'recommendation' => "Kendaraan Anda sudah menempuh jarak jauh sejak servis terakhir.\nDisarankan melakukan Tune Up lengkap untuk mengembalikan performa.",
            'action_list' => ['Tune Up Mesin', 'Bersihkan Throttle Body', 'Cek Busi', 'Cek V-Belt/Rantai'],
            'priority' => 5,
            'is_active' => true,
        ]);

        RuleCondition::create([
            'rule_id' => $ruleMajorService->id,
            'fact_variable' => 'last_service_km',
            'operator' => '>',
            'value' => '10000',
            'value_type' => 'numeric',
        ]);

        // 4. Rule: Servis Ringan & Ganti Oli (Kombinasi)
        // JIKA km_terakhir > 3000 DAN kondisi_oli = 'good' (Masih oke tapi sudah waktunya cek)
        // Note: Ini contoh rule majemuk (2 kondisi)
        $ruleLightService = Rule::create([
            'code' => 'R04',
            'name' => 'Servis Berkala Ringan',
            'description' => 'Pemeriksaan rutin meskipun kondisi tampak baik.',
            'recommendation' => "Lakukan servis berkala ringan untuk menjaga performa.\nCek tekanan ban dan kelistrikan.",
            'action_list' => ['Servis Ringan', 'Cek Tekanan Ban', 'Lumasi Rantai/Gear'],
            'priority' => 3,
            'is_active' => true,
        ]);

        RuleCondition::create([
            'rule_id' => $ruleLightService->id,
            'fact_variable' => 'last_service_km',
            'operator' => '>',
            'value' => '3000',
            'value_type' => 'numeric',
        ]);
        
        RuleCondition::create([
            'rule_id' => $ruleLightService->id,
            'fact_variable' => 'last_service_km',
            'operator' => '<=',
            'value' => '10000', // Antara 3000 - 10000
            'value_type' => 'numeric',
        ]);
    }
}
