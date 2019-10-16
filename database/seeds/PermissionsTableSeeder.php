<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Permission::truncate();

        Permission::create(['name'=>'Cursos']);
        Permission::create(['name'=>'Banca']);
        Permission::create(['name'=>'Permissoes']);
        Permission::create(['name'=>'Cadastros']);
        Permission::create(['name'=>'Relatorios']);
        Permission::create(['name'=>'ClientePago']);
        Permission::create(['name'=>'ClienteGratis']);

    }
}
