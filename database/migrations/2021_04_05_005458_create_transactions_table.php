<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Class CreateTransactionsTable
 */
class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(
            'transactions',
            function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->uuid('payer_id');
                $table->uuid('payee_id');
                $table->enum('status', ['DONE', 'IN_PROGRESS', 'PENDING', 'ERROR'])
                    ->default('PENDING');
                $table->double('value', 12, 2);
                $table->timestamps();

                $table->foreign('payer_id')->references('id')->on('users');
                $table->foreign('payee_id')->references('id')->on('users');

                $table->index(['payer_id', 'payee_id']);
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::table(
            'transactions',
            function (Blueprint $table) {
                $table->dropForeign(['payer_id']);
                $table->dropForeign(['payee_id']);
            }
        );
        Schema::dropIfExists('transactions');
    }
}
