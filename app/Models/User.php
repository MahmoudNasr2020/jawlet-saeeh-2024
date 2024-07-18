<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject; // this sould be imported


class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'password',
        'verify',
        'otp',
        'password_otp',
        'image'
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];



    /*public function getNameAttribute($value)
    {
        if ($value !== null) {
            return ucfirst($value->first_name) . ' ' . ucfirst($value->last_name);
        }
        return 'Name Not Available'; // يمكنك تعديل هذه الرسالة حسب م
    }*/


    //put these methods at the bottom of your class body

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'email'=>$this->email,
            'first_name'=>$this->first_name,
            'last_name'=>$this->last_name
        ];
    }

    public function getImageAttribute($value)
    {
        return asset('images/' . $value);
    }

}
