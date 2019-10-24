<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'module_id', 'video', 'description', 'content', 'status'
    ];

    public function module(){
        return $this->belongsTo('App\Module');
    }

    public function attachments(){
        return $this->hasMany('App\Attachments');
    }
}
