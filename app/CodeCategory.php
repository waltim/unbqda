<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CodeCategory extends Model
{
    use SoftDeletes;
    protected $table = 'code_categories';
    protected $fillable = ['code_id, category_id'];
}
