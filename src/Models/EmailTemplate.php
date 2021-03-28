<?php

namespace Theanh\EmailTemplate\Models;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $table = 'email_templates';
    protected $fillable = [
        'code',
        'subject',
        'body',
        'params'
    ];
    
    protected $casts = [
        'params' => 'array'
    ];
}
