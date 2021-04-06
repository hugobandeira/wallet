<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Class User
 *
 * @package App\Models
 */
class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;
    use Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'cpf/cnpj',
        'password',
        'type_person',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'id' => 'string'
    ];

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @return HasMany
     */
    public function sendTransactions(): HasMany
    {
        return $this->hasMany(Transactions::class, 'payer_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function receiveTransactions(): HasMany
    {
        return $this->hasMany(Transactions::class, 'payee_id', 'id');
    }

    /**
     * @return HasMany
     */
    public function wallet(): HasMany
    {
        return $this->hasMany(Wallet::class, 'user_id', 'id');
    }
}
