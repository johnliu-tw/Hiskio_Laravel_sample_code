<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogsError extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('logs_error', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->default(0);
            $table->text('exception')->nullable();
            $table->text('message')->nullable();
            $table->integer('line')->nullable();
            $table->json('trace')->nullable();

            $table->string('method', 16)->nullable();
            $table->json('params')->nullable();
            $table->text('uri')->nullable();
            $table->text('user_agent')->nullable();
            $table->json('header')->nullable();
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
        Schema::dropIfExists('logs_error');
    }
}
