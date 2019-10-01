<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        Role::create(['name' => 'Dev']);
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Fin']);
        Role::create(['name' => 'Client']);
    }
}
