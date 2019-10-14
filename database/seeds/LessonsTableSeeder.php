<?php

use Illuminate\Database\Seeder;
use App\Lesson;
use App\Module;

class LessonsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Lesson::create([
           'name' => 'aula1',
            'video' => 'https://www.youtube-nocookie.com/embed/G9w9_G3Ow-Y',
            'module_id' => '1',
            'description' => 'teste aula 1',
            'content' => 'lorem ipsum conteudo da aula',
            'status' => 'Publicado',
        ])->module()->associate(Module::where('id', '1')->first());
    }
}
