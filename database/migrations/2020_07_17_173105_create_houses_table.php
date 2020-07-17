<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHousesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('houses', function (Blueprint $table) {
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
            $table->enum('bedrooms', ['studio','1','2','3','4','5','6', '7','8','9','10']);
            $table->double('bathrooms');
            $table->double('measurement');
            $table->enum('m_unit', ['square meter', 'square feet']);
            $table->boolean('furnished')->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('pets_allowed')->default(false);

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
        Schema::dropIfExists('houses');
    }
}
