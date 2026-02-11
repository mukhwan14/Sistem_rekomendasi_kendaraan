<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiagnosisQuestion;

class DiagnosisQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Income (Number)
        DiagnosisQuestion::firstOrCreate(
            ['code' => 'income'],
            [
                'question' => 'Estimasi Pendapatan Bulanan',
                'type' => 'number',
                'options' => null,
                'order' => 1,
                'is_active' => true,
            ]
        );

        // 2. Last Service KM (Number)
        DiagnosisQuestion::firstOrCreate(
            ['code' => 'last_service_km'],
            [
                'question' => 'Jarak Tempuh Terakhir Servis',
                'type' => 'number',
                'options' => null,
                'order' => 2,
                'is_active' => true,
            ]
        );

        // 3. Oil Condition (Select)
        DiagnosisQuestion::firstOrCreate(
            ['code' => 'oil_condition'],
            [
                'question' => 'Kondisi Oli Mesin',
                'type' => 'select',
                'options' => [
                    ['value' => 'good', 'label' => 'Baik (Bening / Baru Ganti)'],
                    ['value' => 'medium', 'label' => 'Sedang (Kecoklatan)'],
                    ['value' => 'bad', 'label' => 'Buruk (Hitam Pekat / Mengental)'],
                ],
                'order' => 3,
                'is_active' => true,
            ]
        );

        // 4. Brake Condition (Select)
        DiagnosisQuestion::firstOrCreate(
            ['code' => 'brake_condition'],
            [
                'question' => 'Kondisi Rem',
                'type' => 'select',
                'options' => [
                    ['value' => 'good', 'label' => 'Pakem & Normal'],
                    ['value' => 'noise', 'label' => 'Berbunyi Mencicit'],
                    ['value' => 'hard', 'label' => 'Keras saat diinjak'],
                    ['value' => 'bad', 'label' => 'Blong / Tidak Pakem'],
                ],
                'order' => 4,
                'is_active' => true,
            ]
        );

        // 5. Tire Condition (Select)
        DiagnosisQuestion::firstOrCreate(
            ['code' => 'tire_condition'],
            [
                'question' => 'Kondisi Ban',
                'type' => 'select',
                'options' => [
                    ['value' => 'good', 'label' => 'Alur Tebal & Normal'],
                    ['value' => 'worn', 'label' => 'Mulai Tipis'],
                    ['value' => 'bald', 'label' => 'Botak / Alur Habis'],
                    ['value' => 'cracked', 'label' => 'Retak-retak'],
                ],
                'order' => 5,
                'is_active' => true,
            ]
        );

        // 6. Lights Condition (Select)
        DiagnosisQuestion::firstOrCreate(
            ['code' => 'lights_condition'],
            [
                'question' => 'Kondisi Lampu & Kelistrikan',
                'type' => 'select',
                'options' => [
                    ['value' => 'good', 'label' => 'Semua Nyala Normal'],
                    ['value' => 'dim', 'label' => 'Redup'],
                    ['value' => 'dead', 'label' => 'Ada yang Mati'],
                ],
                'order' => 6,
                'is_active' => true,
            ]
        );
    }
}
