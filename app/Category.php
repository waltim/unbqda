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

    public function isFather()
    {
        return is_null($this->attributes['category_id']);
    }

    protected $appends = ['is_father'];
    public function getIsFatherAttribute()
    {
        return is_null($this->attributes['category_id']);
    }

    public function code_categories()
    {
        return $this->hasMany('App\CodeCategory');
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
