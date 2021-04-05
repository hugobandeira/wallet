<?php

declare(strict_types=1);

namespace App\Models\Traits;

use Ramsey\Uuid\Uuid as UuidAlias;

/**
 * Trait Uuid
 *
 * @package App\Models\Traits
 */
trait Uuid
{
    /**
     * @return void
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(
            static function ($obj) {
                $obj->id = UuidAlias::uuid4();
            }
        );
    }
}
