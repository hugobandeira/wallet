<?php

declare(strict_types=1);


namespace Tests\Unit\Models;


use App\Models\Traits\Uuid;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Tests\TestCase;

/**
 * Class UserTest
 *
 * @package Tests\Unit\Models
 */
class UserTest extends TestCase
{
    /**
     * @var User
     */
    private $userModel;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userModel = new User();
    }

    public function testFillable(): void
    {
        $fillable = [
            'name',
            'email',
            'cpf/cnpj',
            'password',
            'type_person',
        ];

        self::assertEquals($fillable, $this->userModel->getFillable());
    }

    public function testIncrementing(): void
    {
        self::assertFalse($this->userModel->getIncrementing());
    }

    public function testCats(): void
    {
        $cats = [
            'email_verified_at' => 'datetime',
            'id' => 'string'
        ];

        self::assertEquals($cats, $this->userModel->getCasts());
    }

    public function testHidden(): void
    {
        $cats = [
            'password',
            'remember_token',
        ];

        self::assertEquals($cats, $this->userModel->getHidden());
    }

    public function testShouldBeReceiveTraits(): void
    {
        $traits = [
            HasFactory::class,
            Notifiable::class,
            Uuid::class,
        ];

        self::assertEquals($traits, array_keys(class_uses($this->userModel)));
    }
}
