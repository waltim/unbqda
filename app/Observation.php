<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Observation extends Model
{
    use SoftDeletes;
    protected $table = "observations";
    protected $fillable = ['agreement_id, description, user_id'];

    public function agreement()
    {
        return $this->belongsTo('App\Agreement');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
