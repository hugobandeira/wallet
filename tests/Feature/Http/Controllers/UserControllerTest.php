<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;


use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

/**
 * Class UserControllerTest
 *
 * @package Tests\Feature\Http\Controllers
 */
class UserControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testAllUsers(): void
    {
        $user = User::factory()->create();
        $response = $this->json('GET', '/api/users');

        $response->assertStatus(200)->json(['id' => $user->id]);
    }
}