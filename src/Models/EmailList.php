<?php

namespace Theanh\EmailTemplate\Models;

use Illuminate\Database\Eloquent\Model;

class EmailList extends Model
{
    protected $table = 'email_lists';
    protected $fillable = [
        'template_id',
        'email',
        'priority',
        'params'
    ];
    
    public function template()
    {
        return $this->belongsTo(EmailTemplate::class, 'template_id', 'id');
    }
}
