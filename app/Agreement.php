<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Agreement extends Model
{
    use SoftDeletes;
    protected $table = 'agreements';
    protected $fillable = ['scale, code_id, user_id'];

    public function code()
    {
        return $this->belongsTo('App\Code');
    }

    public function observations()
    {
        return $this->hasMany('App\Observation');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
