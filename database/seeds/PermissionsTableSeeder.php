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

        Permission::create(['name'=>'Criar']);
        Permission::create(['name'=>'Editar']);
        Permission::create(['name'=>'Apagar']);
        Permission::create(['name'=>'Ver']);

    }
}
