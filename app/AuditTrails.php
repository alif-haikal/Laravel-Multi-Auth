<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class AuditTrails extends Model
{
    use Notifiable;
    
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'remote_uri',
        'remote_ip',
        'log',
    ];
}
