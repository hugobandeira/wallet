<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Wallet
 *
 * @package App\Models
 */
class Wallet extends Model
{
    use HasFactory;
    use  Uuid;

    /**
     * @var string[]
     */
    protected $fillable = [
        'amount',
        'user_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'id' => 'string',
    ];

    /**
     * @var bool
     */
    public $incrementing = false;
}
