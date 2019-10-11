<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'course_id', 'descricao', 'status'
    ];

    public function course(){
        return $this->belongsTo('App\Course');
    }

    public function lessons(){
        return $this->hasMany('App\Lesson');
    }

    public function modulesByCourse($course){
        return $this->course()->whereIn('id', $course->id);
    }
}
