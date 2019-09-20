<?php

namespace App\Models ;


use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'settings'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
         * Get the images.
         */
     public function images()
        {
            return $this->hasMany (Image::class);
        }



       public function getAdminAttribute()
        {
        return $this->role === 'admin';
        }


    public function getAdultAttribute()
     {
      return $this->settings->adult;
     }

     public function getSettingsAttribute($value)
        {
            return json_decode ($value);
        }
    public function getPaginationAttribute()
    {
        return $this->settings->pagination;
    }
    }
