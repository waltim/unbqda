<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quote extends Model
{
    use SoftDeletes;
    protected $table = 'quotes';
    protected $fillable = ['description, interview_id'];


    public function codes()
    {
        return $this->belongsToMany('App\Code')
        ->withPivot('user_id');
    }

    public function translate()
    {
        return $this->hasMany('App\Translate');
    }

    public function interview()
    {
        return $this->belongsTo('App\Interview');
    }

}
