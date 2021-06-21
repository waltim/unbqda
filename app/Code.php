<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Code extends Model
{
    use SoftDeletes;
    protected $table = 'codes';
    protected $fillable = ['description, memo, color, user_id'];


    public function agreements()
    {
        return $this->hasMany('App\Agreement');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'code_categories', 'code_id', 'category_id');
    }

    public function quotes()
    {
        return $this->belongsToMany('App\Quote');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
