<?php

namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

use Zizaco\Entrust\Traits\EntrustUserTrait;

/*class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract*/
                                    

class User extends Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Notifiable;
    //use EntrustUserTrait; // add this trait to your user model


    use Authenticatable, Authorizable, CanResetPassword,  EntrustUserTrait {
        EntrustUserTrait::can as may;
        EntrustUserTrait::can insteadof Authorizable;
    }
    //use Authenticatable, Authorizable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public function employee()
    {
        return $this->hasOne('App\Modules\Employee\Http\Employee');
    }
    public function raise()
    {
        return $this->hasMany('App\Modules\Employee\Http\Raise');
    }
    
    public function leave()
    {
        return $this->hasMany('App\Modules\Employee\Http\Leave', 'posted_for');
    }



    public function created_tickets()
    {
        return $this->hasMany('App\Modules\Crm\Http\Ticket', 'created_by');
    }

    public function assigned_tickets()
    {
        return $this->belongsToMany('App\Modules\Crm\Http\Ticket')->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany('App\Model\Role');
    }

    public function device_extentions()
    {
        return $this->hasMany('App\Modules\UserDevicesExtention');
    }
}
