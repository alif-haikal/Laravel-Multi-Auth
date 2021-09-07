<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    public $table = 'users';

	public $fillable = [
		'name',
		'email',
		'status',
	];

	public $casts = [
		'created_at' => 'datetime',
		'email' => 'string',
		'id' => 'integer',
		'name' => 'string',
		'remember_token' => 'string',
		'status' => 'integer',
		'updated_at' => 'datetime',
	];

	protected $hidden = [
		'password', 'remember_token'
	];

	public static $rules = [
		//
	];
}
