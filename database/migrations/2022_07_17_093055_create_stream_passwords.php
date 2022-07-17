<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStreamPasswords extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stream_passwords', function (Blueprint $table) {
            $table->id();

            $table->foreignId('stream_id');
            $table->foreign('stream_id')->references('id')->on('streams')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->foreignId('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->cascadeOnUpdate()->cascadeOnDelete();

            $table->string('password');
            $table->boolean('status')->default(false);

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
        Schema::table('stream_passwords', function (Blueprint $table) {
            $table->dropForeign(['stream_id']);
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('stream_passwords');
    }
}
