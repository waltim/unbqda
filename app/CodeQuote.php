<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CodeQuote extends Model
{
    protected $table = 'code_quote';
    protected $fillable = ['code_id', 'quote_id'];
}
