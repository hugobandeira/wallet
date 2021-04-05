<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Transactions;
use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Class TransactionsFactory
 *
 * @package Database\Factories
 */
class TransactionsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transactions::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        $users = User::pluck('id')->toArray();
        return [
            'payer_id' => $this->faker->randomElement($users),
            'payee_id' => $this->faker->randomElement($users),
            'value' => $this->faker->randomFloat(),
        ];
    }
}
