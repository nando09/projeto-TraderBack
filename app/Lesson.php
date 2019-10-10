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
        'name', 'video', 'descricao', 'content', 'status'
    ];

    public function module(){
        return $this->belongsTo('App\Module');
    }
}
