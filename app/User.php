<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Caffeinated\Shinobi\Concerns\HasRolesAndPermissions;

class User extends Authenticatable
{
    use Notifiable;
    use HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'fullname','last_name','email', 'password', 'rut', 'image', 'status', 'phone1', 'phone2','position','address','fecha_contrato','fecha_fin_contrato','image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token', 'password'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the profitCenter for the blog user.
     */
    public function estado()
    {
        return $this->belongsTo('App\UsersStatus', 'status','id');
    }

    public function grupo()
    {
        return $this->belongsTo('App\UsersGroups', 'id','id_user');
    }

    /**
     * Get the user that owns the operation.
     */
    public function operation()
    {
        return $this->hasMany('App\Operation');
    }

     public function edificio()
    {
        return $this->belongsTo('App\Building', 'id_edificio');
    }

    public function rol_user()
    {
        return $this->belongsTo('App\RolUser','id','user_id');
    }

    public function isAdmin() {
        return $this->is_admin == true;
      }

}
