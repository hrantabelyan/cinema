<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminUser = [
            'uuid' => Str::uuid(),
            'name' => 'John Doe',
            'email' => 'admin@cinema.come',
            'email_verified_at' => now(),
            'password' => Hash::make('password')
        ];

        if (!User::where('email', '=', $adminUser['email'])->exists()) {
            User::create($adminUser);
        }

        if (app()->environment('local') && User::count() < 20) {
            User::factory()->count(20)->create();
        }
    }
}
