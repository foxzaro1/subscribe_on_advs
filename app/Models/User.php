<?php

namespace App\Models;

use App\Jobs\VerifySendingEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\Advert;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

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
        'verify_code',
        'advert_id',
        'active'
    ];
    protected $visible = [
        'id',
        'email',
        'verify_code',
        'active'
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
        )->first()->addVerifyCodeToOldUser();
    }

    /**
     * @param $email
     * @return User
     */
    private function addUser($email)
    {
        $user = new self();
        $user->email = $email;
        $user->verify_code = str_replace('/', "", Hash::make(Str::random(12) . "_" . Carbon::now()->timestamp));
        $user->save();
        $arr = [
            'code' => $user->verify_code,
            'email' => $user->email,
        ];
        dispatch((new VerifySendingEmail($arr))->onQueue('verify_email'));
        return $user;
    }

    /**
     * add verify code to old user and deactivate him until user confirms the email
     *
     * @return $this
     */
    private function addVerifyCodeToOldUser()
    {
        if ($this->verify_code === null) {
            $this->verify_code = str_replace('/', "", Hash::make(Str::random(12) . "_" . Carbon::now()->timestamp));
            $this->active = false;
            $this->save();
            $arr = [
                'code' => $this->verify_code,
                'email' => $this->email,
            ];
            dispatch((new VerifySendingEmail($arr))->onQueue('verify_email'));
        }
        return $this;
    }

    public function doVerificatonFromEmail($code)
    {
        $user = self::where('verify_code', '=', $code)->where('active', '=', false);
        if ($user->count() > 0) {
            $targetUser = $user->first();
            $targetUser->active = true;
            $targetUser->save();
            return true;
        } else {
            return false;
        }
    }
}
