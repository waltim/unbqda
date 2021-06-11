<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Translate extends Model
{
    use SoftDeletes;
    protected $table = 'translates';
    protected $fillable = ['language, description, user_id, quote_id'];
}
