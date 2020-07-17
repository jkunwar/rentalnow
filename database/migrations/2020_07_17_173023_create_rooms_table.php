<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('address_id')->nullable();
            $table->foreign('address_id')->references('id')->on('addresses');

            $table->enum('currency', ['AUD','USD']);
            $table->integer('rent');
            $table->date('move_date')->nullable();
            $table->boolean('long_term')->nullable();
            $table->date('leave_date')->nullable();
            $table->text('description')->nullable();

            //residence
            $table->string('building_type')->nullable();
            $table->integer('move_in_fee')->nullable();
            $table->integer('utilities_cost')->nullable();
            $table->integer('parking_rent')->nullable();
            $table->boolean('furnished')->nullable();
            $table->boolean('pets_allowed')->default(false);
            $table->boolean('is_available')->default(true);

            $table->softDeletes();
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
        Schema::dropIfExists('rooms');
    }
}
