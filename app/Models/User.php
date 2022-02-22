<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // ********** Relationships *************************
    public function ideas()
    {
        return $this->hasMany(Idea::class);
    }

    public function votes()
    {
        return $this->belongsToMany(Idea::class, 'votes');
    }

    // get avatar url for user
    // https://www.gravatar.com/avatar/5822dd3b3828e76bcc476644590696d7?s=200&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-6.png
    public function getAvatar()
    {
        $firstCharacter = $this->email[0];
        $baseUrl = 'https://gravatar.com/avatar/';
        $awsUrl = 'd=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-';
        $hash = md5(strtolower(trim($this->email)));
        $size = 's=200';
        $extension = '.png';

        /*if (is_numeric($firstCharacter)) {
           $integerToUse =  ord(strtolower($firstCharacter)) - 21;
       }else {
           $integerToUse = ord(strtolower($firstCharacter)) - 96;
       }*/

        $integerToUse = is_numeric($firstCharacter)
            ? ord(strtolower($firstCharacter)) - 21
            : ord(strtolower($firstCharacter)) - 96;

        return 'https://www.gravatar.com/avatar/'
            .$hash
            .'?s=200'
            .'&d=https://s3.amazonaws.com/laracasts/images/forum/avatars/default-avatar-'
            .$integerToUse
            .$extension;

        //return $baseUrl . $hash . '?' . $size . '&' . $awsUrl . $integerToUse . $extension;
    }


}
