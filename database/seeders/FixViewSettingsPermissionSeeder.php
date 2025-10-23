<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class FixViewSettingsPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create view_settings permission if it doesn't exist
        if (!Permission::where('name', 'view_settings')->exists()) {
            Permission::create(['name' => 'view_settings']);
        }

        // Add view_settings permission to bendahara role
        $bendaharaRole = Role::where('name', 'bendahara')->first();
        if ($bendaharaRole && !$bendaharaRole->hasPermissionTo('view_settings')) {
            $bendaharaRole->givePermissionTo('view_settings');
        }

        $this->command->info('view_settings permission added to bendahara role!');
    }
}
