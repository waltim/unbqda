<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Translate extends Model
{
    use SoftDeletes;
    protected $table = 'translates';
    protected $fillable = ['language, description, user_id, quote_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function quote()
    {
        return $this->belongsTo('App\Quote');
    }
}
