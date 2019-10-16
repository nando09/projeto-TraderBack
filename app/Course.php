<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'subtitle', 'AccessLevel', 'DataInicio', 'DataFim', 'status', 'descricao'
    ];

    public function modules(){
        return $this->hasMany('App\Module');
    }
}
