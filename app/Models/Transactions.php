<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class Transactions
 *
 * @package App\Models
 */
class Transactions extends Model
{
    use HasFactory;
    use Uuid;

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var string[]
     */
    protected $fillable = [
        'payer_id',
        'payee_id',
        'status',
        'value',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'id' => 'string',
    ];
}
