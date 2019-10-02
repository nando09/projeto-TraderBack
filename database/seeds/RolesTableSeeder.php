<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\Permission;
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

        $createPermission = Permission::where('name', 'Criar')->first();
        $editPermission = Permission::where('name', 'Editar')->first();
        $deletePermission = Permission::where('name', 'Apagar')->first();
        $viewPermission = Permission::where('name', 'Ver')->first();

        $dev = Role::create(['name' => 'Dev']);
        $admin = Role::create(['name' => 'Admin']);
        $fin = Role::create(['name' => 'Fin']);
        $client = Role::create(['name' => 'Client']);

        $dev->permissions()->attach($createPermission);
        $dev->permissions()->attach($editPermission);
        $admin->permissions()->attach($editPermission);
        $fin->permissions()->attach($viewPermission);
        $client->permissions()->attach($viewPermission);
    }
}
