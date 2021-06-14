<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interview extends Model
{
    use SoftDeletes;
    protected $table = 'interviews';
    protected $fillable = ['name, description, project_id'];


    public function quotes()
    {
        return $this->hasMany('App\Quote');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }
}
