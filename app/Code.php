<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Code extends Model
{
    use SoftDeletes;
    protected $table = 'codes';
    protected $fillable = ['description, memo, color, user_id, quote_id'];


    public function agreements()
    {
        return $this->hasMany('App\Agreement');
    }

    public function code_categories()
    {
        return $this->hasMany('App\CodeCategory');
    }

    public function quote()
    {
        return $this->belongsTo('App\Quote');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
