<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddViewSettingsPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add view_settings permission if it doesn't exist
        if (!Permission::where('name', 'view_settings')->exists()) {
            Permission::create(['name' => 'view_settings']);
        }

        // Add view_settings permission to anggota role
        $anggotaRole = Role::where('name', 'anggota')->first();
        if ($anggotaRole && !$anggotaRole->hasPermissionTo('view_settings')) {
            $anggotaRole->givePermissionTo('view_settings');
        }

        $this->command->info('view_settings permission added to anggota role!');
    }
}
