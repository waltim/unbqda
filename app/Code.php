<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Code extends Model
{
    use SoftDeletes;
    protected $table = 'codes';
    protected $fillable = ['description, memo, color, user_id, quote_id'];
}
