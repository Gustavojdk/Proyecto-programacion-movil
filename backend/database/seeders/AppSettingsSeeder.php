<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'reclamos_phone_1',   'value' => null, 'group' => 'reclamos'],
            ['key' => 'reclamos_phone_2',   'value' => null, 'group' => 'reclamos'],
            ['key' => 'reclamos_whatsapp',  'value' => null, 'group' => 'reclamos'],
        ];

        foreach ($settings as $setting) {
            DB::table('app_settings')->updateOrInsert(
                ['key' => $setting['key']],
                [
                    'value'      => $setting['value'],
                    'group'      => $setting['group'],
                    'activo'     => true,
                    'updated_by' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
