<?php


namespace Tests\Unit\Models;


use App\Models\User;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testFillable(): void
    {
        $fillable = [
            'name',
            'email',
            'cpf/cnpj',
            'password',
        ];

        $user = new User();

        $this->assertEquals($fillable, $user->getFillable());
    }
}
