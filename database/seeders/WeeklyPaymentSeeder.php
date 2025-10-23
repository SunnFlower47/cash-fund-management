<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\WeeklyPayment;
use Illuminate\Support\Facades\Hash;

class WeeklyPaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create anggota accounts
        $anggotaData = [
            [
                'name' => 'Ridwan',
                'email' => 'ridwan@sunnflower.site',
                'password' => 'password123'
            ],
            [
                'name' => 'Ilham',
                'email' => 'ilham@sunnflower.site',
                'password' => 'password123'
            ],
            [
                'name' => 'Ganda',
                'email' => 'ganda@sunnflower.site',
                'password' => 'password123'
            ],
            [
                'name' => 'Nabas',
                'email' => 'nabas@sunnflower.site',
                'password' => 'password123'
            ],
            [
                'name' => 'Karlos',
                'email' => 'karlos@sunnflower.site',
                'password' => 'password123'
            ]
        ];

        foreach ($anggotaData as $data) {
            $user = User::updateOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'email_verified_at' => now()
                ]
            );

            // Assign anggota role
            if (!$user->hasRole('anggota')) {
                $user->assignRole('anggota');
            }
        }
    }
}
