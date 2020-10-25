<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Advert;

/**
 * Class User
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'id',
        'email',
        'user_id',
        'advertIds',
        'advert_id',
    ];
    protected $visible = [
        'id',
        'email',
        'advertIds',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function adverts()
    {
        return $this->belongsToMany(\App\Models\Advert::class);
    }

    /**
     * @param $email
     * @return User
     */
    public function getByEmailOrCreateNew($email)
    {
        return (self::where('email', '=', $email)->count() == 0) ? $this->addUser($email) : self::where(
            'email',
            '=',
            $email
        )->first();
    }

    /**
     * @param $email
     * @return User
     */
    private function addUser($email)
    {
        $user = new self();
        $user->email = $email;
        $user->save();
        return $user;
    }
}
