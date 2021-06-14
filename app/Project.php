<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    protected $table = 'projects';
    protected $fillable = ['user_id, name, description'];
    use SoftDeletes;


    public function interviews()
    {
        return $this->hasMany('App\Interview');
    }

    public function categories()
    {
        return $this->hasMany('App\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }


}
