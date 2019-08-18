<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\Notifiable;
use App\Notifications\AdminResetPasswordNotification;

class Admin extends Model implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract
{

	// Always remember to put necessary traits inside class after defining them below namespace
    // These traits are used for admin login authentication
	use Authenticatable,
        Authorizable,
        CanResetPassword,
        Notifiable;

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
        'display_name',
        'is_online',
		'email',
        'password',
        'is_super',
        'last_access',
        'remember_token'
	];

	/**
     * Override the default function to send password reset notification
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new AdminResetPasswordNotification($token));
    }
}
