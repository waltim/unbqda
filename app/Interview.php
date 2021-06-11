<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Interview extends Model
{
    use SoftDeletes;
    protected $table = 'interviews';
    protected $fillable = ['name, description, project_id'];
}
