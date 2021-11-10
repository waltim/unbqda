<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CodingLevel extends Model
{
    use SoftDeletes;
    protected $table = "coding_levels";
    protected $fillable = ['interview_id, level'];

    public function interview()
    {
        return $this->belongsTo('App\Interview');
    }

}
