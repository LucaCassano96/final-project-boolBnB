<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartments', function (Blueprint $table) {

            $table->id();

            $table -> string("title");
            $table -> text("description") -> nullable();
            $table -> integer("rooms");
            $table -> integer("beds");
            $table -> integer("bathrooms");
            $table -> integer("square_meters");
            $table -> text("picture") -> nullable();
            $table -> integer("price");
            $table -> text("address");
            $table -> double("latitude", 8,6) -> nullable();
            $table -> double("longitude", 9,6) -> nullable();

            $table -> boolean("visible") -> default(true);

            $table->boolean('activeSponsor')->default(0);

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
        Schema::dropIfExists('apartments');
    }
};
