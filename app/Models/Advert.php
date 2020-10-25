<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

/**
 * Class Advert
 *
 * @package App\Models
 */
class Advert extends Model
{
    use HasFactory;

    protected $table = 'adverts';

    protected $fillable = [
        'id',
        'name',
        'advert_id',
        'user_id',
        'advCode',
        'status',
        'url',
        'price',
        'update_at',
        'updated_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'advCode',
        'status',
        'url',
        'price',
        'update_at',
        'updated_at',
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'advert_user', 'user_id', 'advert_id');
    }

    /**
     * @param $code
     * @return Advert
     */
    public function getByCodeOrCreateNew($code)
    {
        return (self::where('advCode', '=', $code)->count() == 0) ? $this->addAdv($code) : self::where(
            'advCode',
            '=',
            $code
        )->first();
    }

    /**
     * @param $code
     * @return Advert
     */
    private function addAdv($code)
    {
        $advert = new self();
        $advert->advCode = $code;
        return $advert;
    }
}
