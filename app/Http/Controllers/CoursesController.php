<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Course;
use App\Module;
use App\Lesson;
use App\Attachments;

class CoursesController extends Controller
{

//    CREATE FUNCTIONS

    public function clientCourse(){
        $course = Course::where('ativo', 1)->first();

        $modules = $course->modules;
        foreach($modules as $module){
            $module->lessons;
        }
        return $course;
    }

    public function activateCourse(Request $request){
        $data = $request->all();
        Course::where('ativo', 1)->update(['ativo' => false]);
        Course::findOrFail($data['course'])->update(['ativo' => true]);
        $course = Course::findOrFail($data['course']);
        return $course;
    }

    public function createCourse(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
        ],[
            'name.required' => 'O nome é obrigatório',
        ]);

        if($validator->fails()){
            return $validator->errors();
        }
        if($data['status'] == true){
        Course::where('ativo', 1)->update(['ativo' => false]);
        }
        $course = Course::create([
            'name' => $data['name'],
            'subtitle' => $data['subtitle'],
            'AccessLevel' => $data['AccessLevel'],
            'DataInicio' => $data['DataInicio'],
            'DataFim' => $data['DataFim'],
            'descricao' => $data['descricao'],
            'ativo' => $data['status']
        ]);

        return $course;
    }

    public function createModule(Request $request)
    {

        $data = $request->all();

        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255']
        ],[
            'name.required' => 'O nome é obrigatório',
        ]);

        if($validator->fails()){
            return $validator->errors();
        }

        $course = Course::where('id', $data['course_id'])->first();

        $module = Module::create([
            'name' => $data['name'],
            'course_id' => $data['course_id'],
            'descricao' => $data['descricao'],
            'status' => $data['status'],
        ]);
        $module->course()->associate($course);

        return $module;
    }

    public function createLesson(Request $request)
    {

        $data = $request->all();
//        return $request->all()['files'];
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255']
        ],[
            'name.required' => 'O nome é obrigatório',
        ]);

        if($validator->fails()){
            return $validator->errors();
        }

        $module = Module::where('id', $data['module_id'])->first();

        $lesson = Lesson::create([
            'name' => $data['name'],
            'module_id' => $data['module_id'],
            'video' => $data['video'],
            'description' => $data['descricao'],
            'content' => $data['content'],
            'status' => $data['status'],
        ]);
        $lesson->module()->associate($module);

        if($files = $data['files']){
            foreach($files as $file){
                 $attachment = Attachments::create([
                    'lesson_id' => $lesson->id,
                    'filename' => $file->getClientOriginalName()
                ]);
                 $attachment->lesson()->associate($lesson);
                $file->storeAs($lesson->id, $file->getClientOriginalName(), 'public');
            }
        }
        return $lesson;
    }

//    UPDATE FUNCTIONS

    public function updateCourse(Request $request, $id)
    {
         $data = $request->all();
         $validator = Validator::make($data, [
             'name' => ['required', 'string', 'max:255'],
         ],[
             'name.required' => 'O nome é obrigatório',
         ]);

         if($validator->fails()){
             return $validator->errors();
         }

         $course = Course::find($id);

         $course->update([
             'name' => $data['name'],
             'subtitle' => $data['subtitle'],
             'AccessLevel' => $data['AccessLevel'],
             'DataInicio' => $data['DataInicio'],
             'DataFim' => $data['DataFim'],
             'status' => $data['status'],
             'descricao' => $data['descricao'],
         ]);

         return 'Curso Atualizado';
    }

    public function updateModule(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
        ],[
            'name.required' => 'O nome é obrigatório',
        ]);

        if($validator->fails()){
            return $validator->errors();
        }

        $module = Module::find($id);

        $module->update([
            'name' => $data['name'],
            'status' => $data['status'],
            'descricao' => $data['descricao'],
        ]);

        return 'Modulo Atualizado';
    }

    public function updateLesson(Request $request, $id)
    {
        $data = $request->all();
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
        ],[
            'name.required' => 'O nome é obrigatório',
        ]);

        if($validator->fails()){
            return $validator->errors();
        }

        $lesson = Lesson::find($id);

        $lesson->update([
            'name' => $data['name'],
            'status' => $data['status'],
            'content' => $data['content'],
            'video' => $data['video'],
            'description' => $data['descricao'],
        ]);

        return 'Aula Atualizada';
    }

//    DESTROY FUNCTIONS

    public function destroyCourse(Request $request)
    {
        $course = Course::find($request['id']);
        $course->delete();
        if (Course::find($request['id'])){
            $status = 'Error!';
        } else {
            $status = 'Done!';
        }
        return $status;
    }

    public function destroyModule(Request $request)
    {
        $module = Module::find($request['id']);
        $module->delete();
        if (Module::find($request['id'])){
            $status = 'Error!';
        } else {
            $status = 'Done!';
        }
        return $status;
    }

    public function destroyLesson(Request $request)
    {
        $lesson = Lesson::find($request['id']);
        $lesson->delete();
        if (Lesson::find($request['id'])){
            $status = 'Error!';
        } else {
            $status = 'Done!';
        }
        return $status;
    }

//    GET ALL FUNCTIONS

    public function getAllCourses(){
        $all_courses = Course::all();
        foreach($all_courses as $key => $course){
            $all_courses[$key]->modules = $course->modules;
        }
        return $all_courses;
    }

    public function getCourseModules($course_id){
        $modules = Course::find($course_id)->modules;
        foreach($modules as $key => $module){
            $modules[$key]->lessons = $module->lessons;
        }
        return $modules;
    }

    public function getModuleLessons($course_id, $module_id){
//        return '$module_id';
        $lessons = Module::find($module_id)->lessons;

        foreach($lessons as $key => $lesson){
            $lessons[$key]->attachments = $lesson->attachments;
        }
        return $lessons;
    }

    public function getModule($module){
        $module = Module::findOrFail($module);
        $module->lessons;
        return $module;
    }

    public function getLesson($lesson_id){
        $lesson =  Lesson::findOrFail($lesson_id);
        $lesson->comments;
        return $lesson;
    }
}
