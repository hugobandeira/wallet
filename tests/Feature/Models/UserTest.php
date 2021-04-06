<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * Class UserTest
 *
 * @package Tests\Feature\Models
 */
class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testCreateUserAndList(): void
    {
        User::factory()->count(1)->create();

        $users = User::all();
        self::assertCount(1, $users);
        $list = array_keys($users->first()->getAttributes());
        self::assertEqualsCanonicalizing(
            [
                'id',
                'name',
                'email',
                'cpf/cnpj',
                'type_person',
                'email_verified_at',
                'password',
                'remember_token',
                'created_at',
                'updated_at'
            ],
            $list
        );
    }
}
