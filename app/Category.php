<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $table = 'categories';
    protected $primaryKey = "id";
    protected $fillable = ['description, memo, color, user_id, project_id, category_id'];


    public function sub_categories()
    {
        return $this->hasMany(Category::class, 'category_id', 'id');
    }

    public function codes()
    {
        return $this->belongsToMany('App\Code', 'code_categories', 'category_id', 'code_id');
    }

    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function category()
    {
        return $this->belongsTo('App\Category');
    }
}
