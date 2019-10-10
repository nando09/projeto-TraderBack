<?php

use Illuminate\Database\Seeder;
use App\Course;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::truncate();

        Course::create([
           'name' => 'Curso 1',
           'subtitle' => 'subtitulo curso 1',
           'AccessLevel' => 'client',
           'DataInicio' => date('2019-10-05'),
            'DataFim' => date('2019-11-30'),
            'status' => 'Publicado',
            'descricao' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed quis mauris sed velit aliquet malesuada. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Ut metus mauris, cursus ut arcu in, elementum cursus arcu. Vestibulum venenatis sapien eu sagittis fermentum. Curabitur quam mi, suscipit id suscipit nec, ultrices nec metus. Nulla sed erat eget erat faucibus vestibulum id ac purus. Cras rhoncus accumsan turpis, nec iaculis nisi laoreet nec. Fusce efficitur accumsan lacus quis vestibulum. Sed sit amet lacus accumsan, tempor turpis eget, malesuada nisi. Cras rhoncus nunc eu lacus vulputate finibus. Nullam placerat malesuada odio et tempor.
            Fusce rhoncus ipsum sapien, a consequat nibh rutrum ac. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce nisi velit, porttitor eget bibendum vitae, scelerisque a odio. Aliquam mollis turpis porta, feugiat lectus in, imperdiet tortor. Quisque feugiat, arcu a rutrum commodo, metus arcu ultrices magna, eu aliquam lorem velit eu nulla. Nulla pretium porta malesuada. Quisque lectus tellus, imperdiet commodo efficitur eu, tincidunt eu dolor. '
        ]);
    }
}
