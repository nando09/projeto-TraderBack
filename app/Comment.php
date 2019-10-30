<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'user_name', 'lesson_id', 'content', 'status'
    ];

    public function user(){
        return $this->belongsTo('App\User');
    }

    public function lesson(){
        return $this->belongsTo('App\Lesson');
    }
}
