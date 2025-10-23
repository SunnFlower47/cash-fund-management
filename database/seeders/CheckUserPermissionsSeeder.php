<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class CheckUserPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get anggota role
        $anggotaRole = Role::where('name', 'anggota')->first();

        if ($anggotaRole) {
            $this->command->info('Anggota role found');

            // Check if view_transactions permission exists
            $viewTransactionsPermission = Permission::where('name', 'view_transactions')->first();
            if ($viewTransactionsPermission) {
                $this->command->info('view_transactions permission exists');

                // Check if anggota has this permission
                if ($anggotaRole->hasPermissionTo('view_transactions')) {
                    $this->command->info('Anggota role HAS view_transactions permission');
                } else {
                    $this->command->info('Anggota role DOES NOT HAVE view_transactions permission');
                    $anggotaRole->givePermissionTo('view_transactions');
                    $this->command->info('Added view_transactions permission to anggota role');
                }
            } else {
                $this->command->info('view_transactions permission does not exist');
                Permission::create(['name' => 'view_transactions']);
                $anggotaRole->givePermissionTo('view_transactions');
                $this->command->info('Created and assigned view_transactions permission to anggota role');
            }
        } else {
            $this->command->error('Anggota role not found');
        }

        // Check specific user permissions
        $anggotaUser = User::where('email', 'anggota@example.com')->first();
        if ($anggotaUser) {
            $this->command->info('Anggota user found: ' . $anggotaUser->name);
            $this->command->info('User roles: ' . $anggotaUser->roles->pluck('name')->join(', '));
            $this->command->info('User permissions: ' . $anggotaUser->getAllPermissions()->pluck('name')->join(', '));
        } else {
            $this->command->error('Anggota user not found');
        }
    }
}
