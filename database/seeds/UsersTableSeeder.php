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
            'email' => 'dev@dev.com',
            'password' => bcrypt('eita1234')
        ]);
        $admin = User::create([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('eita1234')
        ]);
        $fin = User::create([
            'name' => 'fin',
            'email' => 'fin@fin.com',
            'password' => bcrypt('eita1234')
        ]);
        $client = User::create([
            'name' => 'client',
            'email' => 'client@client.com',
            'password' => bcrypt('eita1234')
        ]);

        $dev->roles()->attach($devRole);
        $admin->roles()->attach($adminRole);
        $fin->roles()->attach($finRole);
        $client->roles()->attach($clientRole);
    }
}
