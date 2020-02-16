<?php

namespace App\Models;

use App\Notifications\AdminResetPassword;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Morilog\Jalali\Jalalian;

class Admin extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    protected $guard_name = 'admin';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'family', 'email', 'password', 'phone', 'avatar_image', 'username', 'disable'
    ];

    const SEARCHABLE = [
        'name', 'family', 'email', 'username', 'phone'
    ];

    const RELATIONS_FOR_CHECK = [
        // EXAMPLE
        //'blogs' => ["relation_name"=>'blogs', "permission_name"=>'blog', "fa_name"=>'مقالات', 'foreign_key'=>'admin_id']
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getCreatedAtAttribute($value){
        return Jalalian::forge($value)->format('%Y/%m/%d H:i');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPassword($token));
    }
}
