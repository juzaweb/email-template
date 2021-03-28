<?php

namespace Theanh\EmailTemplate\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $table = 'email_template';
    protected $fillable = [
        'subject',
        'content',
        'params'
    ];
    
    protected $casts = [
        'params' => 'array'
    ];
    
    
}
