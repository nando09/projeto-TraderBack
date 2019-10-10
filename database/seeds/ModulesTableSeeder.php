<?php

use Illuminate\Database\Seeder;
use App\Module;
use App\Course;

class ModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Module::truncate();

        $curso = Course::where('id', '1')->first();
        $modulo1 = Module::create([
            'name'=> 'modulo 1',
            'course_id' => '1',
            'descricao' => 'lorem ipsum modulo',
            'status' => 'Publicado',
        ]);

         $modulo2 = Module::create([
            'name'=> 'modulo 2',
             'course_id' => '1',
             'descricao' => 'lorem ipsum modulo',
            'status' => 'Publicado',
        ]);

         $modulo1->course()->associate($curso);
         $modulo2->course()->associate($curso);
    }
}
