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

        $cursoPermission = Permission::where('name', 'Cursos')->first();
        $bancaPermission = Permission::where('name', 'Banca')->first();
        $cadastrosPermission = Permission::where('name', 'Cadastros')->first();
        $relatoriosPermission = Permission::where('name', 'Relatorios')->first();
        $Permission = Permission::where('name', 'Permissoes')->first();
        $clientePermission = Permission::where('name', 'ClientePago')->first();
//        $clienteGratisPermission = Permission::where('name', 'ClienteGratis')->first();

        $dev = Role::create(['name' => 'Dev']);
        $admin = Role::create(['name' => 'Admin']);
        $fin = Role::create(['name' => 'Fin']);
        $client = Role::create(['name' => 'Client']);

        $dev->permissions()->attach($cursoPermission);
        $dev->permissions()->attach($bancaPermission);
        $dev->permissions()->attach($cadastrosPermission);
        $dev->permissions()->attach($relatoriosPermission);
        $dev->permissions()->attach($Permission);
        $dev->permissions()->attach($clientePermission);

        $admin->permissions()->attach($cursoPermission);
        $admin->permissions()->attach($bancaPermission);
        $admin->permissions()->attach($cadastrosPermission);
        $admin->permissions()->attach($relatoriosPermission);
        $admin->permissions()->attach($Permission);
        $admin->permissions()->attach($clientePermission);

        $fin->permissions()->attach($relatoriosPermission);
        $fin->permissions()->attach($bancaPermission);

        $client->permissions()->attach($clientePermission);
    }
}
