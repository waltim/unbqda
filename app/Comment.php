<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    protected $table = "comments";
    protected $fillable = ['interview_id, description, user_id'];

    public function interview()
    {
        return $this->belongsTo('App\Interview');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
