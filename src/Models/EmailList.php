<?php

namespace Tadcms\EmailTemplate\Models;

use Illuminate\Database\Eloquent\Model;

class EmailList extends Model
{
    protected $table = 'email_lists';
    protected $fillable = [
        'template_id',
        'email',
        'priority',
        'params',
        'status',
        'error',
        'data',
    ];
    
    protected $casts = [
        'params' => 'array',
        'data' => 'array',
        'error' => 'array',
    ];
    
    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id', 'id');
    }
}
