<?php

declare(strict_types=1);

namespace Tests\Feature\Repositories;

use Tests\TestCase;
use App\Models\User;
use App\Repositories\UserRepositoryInterface;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Class UserRepositoryTest
 *
 * @package Tests\Feature\Repositories
 */
class UserRepositoryTest extends TestCase
{

    use DatabaseMigrations;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = $this->app->get(UserRepositoryInterface::class);
    }

    /**
     * @dataProvider dataProviderUser
     */
    public function testShouldBeGetUser($typePerson): void
    {
        $user = User::factory()->count(1)->create(
            [
                'type_person' => $typePerson
            ]
        );

        $result = $this->userRepository->get($user->first()->id);

        self::assertEquals($typePerson, $result['type_person']);
        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas(
            'users',
            [
                'name' => $user->first()->name,
                'type_person' => $typePerson,
                'cpf/cnpj' => $user->first()->{'cpf/cnpj'},
            ]
        );
    }


    public function testShouldBeAllUsers(): void
    {
        User::factory()->create();
        $result = $this->userRepository->all();
        self::assertCount(1, $result);
    }

    /**
     * @return array[]
     */
    public function dataProviderUser(): array
    {
        return [
            'Type person F' => [
                'type_person' => 'F',
            ],
            'Type Person J' => [
                'type_person' => 'J',
            ],
        ];
    }
}