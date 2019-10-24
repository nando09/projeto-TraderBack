<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachments extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'filename', 'lesson_id'
    ];

    public function lesson(){
        return $this->belongsTo('App\Lesson');
    }
}
