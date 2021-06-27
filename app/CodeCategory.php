<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodeCategory extends Model
{
    protected $table = 'code_categories';
    protected $fillable = ['code_id, category_id'];

}
