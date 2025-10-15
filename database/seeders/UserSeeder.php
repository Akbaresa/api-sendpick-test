<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('role_name', 'admin')->first();
        $dispatcherRole = Role::where('role_name', 'dispatcher')->first();
        $driverRole = Role::where('role_name', 'driver')->first();

        User::create([
            'name' => 'Admin SendPick',
            'email' => 'admin@sendpick.test',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id,
        ]);

        User::create([
            'name' => 'Dispatcher One',
            'email' => 'dispatcher@sendpick.test',
            'password' => Hash::make('password'),
            'role_id' => $dispatcherRole->id,
        ]);

        User::create([
            'name' => 'Driver One',
            'email' => 'driver@sendpick.test',
            'password' => Hash::make('password'),
            'role_id' => $driverRole->id,
        ]);
    }
}
