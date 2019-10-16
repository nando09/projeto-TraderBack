<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        $devRole = Role::where('name', 'Dev')->first();
        $adminRole = Role::where('name', 'Admin')->first();
        $finRole = Role::where('name', 'Fin')->first();
        $clientRole = Role::where('name', 'Client')->first();

        $dev = User::create([
            'name' => 'developer',
            'role_id' => 1,
            'email' => 'dev@dev.com',
            'password' => bcrypt('eita1234')
        ]);
        $admin = User::create([
            'name' => 'admin',
            'role_id' => 2,
            'email' => 'admin@admin.com',
            'password' => bcrypt('eita1234')
        ]);
        $fin = User::create([
            'name' => 'fin',
            'role_id' => 3,
            'email' => 'fin@fin.com',
            'password' => bcrypt('eita1234')
        ]);
        $client = User::create([
            'name' => 'client',
            'role_id' => 4,
            'email' => 'client@client.com',
            'password' => bcrypt('eita1234')
        ]);

        $dev->role()->associate($devRole);
        $admin->role()->associate($adminRole);
        $fin->role()->associate($finRole);
        $client->role()->associate($clientRole);
    }
}
