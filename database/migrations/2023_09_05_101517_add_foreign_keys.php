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
        /* Apartment--view */
        Schema::table('views', function (Blueprint $table) {
            $table -> foreignId("apartment_id") -> constrained();
        });


        /* Apartment--location */
         Schema::table('locations', function (Blueprint $table) {
            $table -> foreignId("apartment_id") -> constrained();
        });

        /* User--Apartment */

        Schema::table('apartments', function (Blueprint $table) {
            $table -> foreignId("user_id") -> constrained();
        });

        /* Apartment--Message */

        Schema::table('messages', function (Blueprint $table) {
            $table -> foreignId("apartment_id") -> constrained();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
        {

            /* Apartment--view */
            Schema::table('views', function (Blueprint $table) {

                $table -> dropForeign ('views_apartment_id_foreign');
                $table -> dropColumn("apartment_id");

            });

            /* Apartment--location */
             Schema::table('locations', function (Blueprint $table) {

                $table -> dropForeign ('locations_apartment_id_foreign');
                $table -> dropColumn("apartment_id");

            });

            /* User--Apartment */

            Schema::table('apartments', function (Blueprint $table) {

                $table -> dropForeign ('apartments_user_id_foreign');
                $table -> dropColumn("user_id");

            });

            /* Apartment--Message */

            Schema::table('messages', function (Blueprint $table) {

                $table -> dropForeign ('messages_apartment_id_foreign');
                $table -> dropColumn("apartment_id");

            });
    }

};
