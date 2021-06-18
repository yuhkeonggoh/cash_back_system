<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCashBacksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cash_backs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('channel');
            $table->decimal('min_spend', 9, 2);
            $table->decimal('max_spend', 9, 2)->nullable();
            $table->decimal('cash_back_percentage', 9, 2);
            $table->decimal('cap_cash_back', 9, 2)->nullable();
            $table->unsignedInteger('coin');
            $table->unsignedTinyInteger('priority');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cash_backs');
    }
}
