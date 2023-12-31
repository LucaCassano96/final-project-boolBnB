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

        /* amenity_apartment > tabella ponte*/

        Schema::table('amenity_apartment', function (Blueprint $table) {
            $table -> foreignId('amenity_id') -> constrained();
            $table -> foreignId('apartment_id') -> constrained();
        });

         /* User--Apartment */

         Schema::table('apartments', function (Blueprint $table) {
            $table -> foreignId("user_id") -> constrained();
        });

         /* Apartment--Message */

         Schema::table('messages', function (Blueprint $table) {
            $table -> foreignId("apartment_id") -> constrained();
        });

        /* Apartment--View */

        Schema::table('views', function (Blueprint $table) {
            $table -> foreignId("apartment_id") -> constrained();
        });

        /* Apartment--Sponsor */
        Schema::table('apartment_sponsor', function (Blueprint $table) {
            $table -> foreignId('apartment_id') -> constrained();
            $table -> foreignId('sponsor_id') -> constrained();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
        {


            /* amenity_apartment > tabella ponte*/

            Schema::table('amenity_apartment', function (Blueprint $table) {

                $table -> dropForeign('amenity_apartment_amenity_id_foreign');
                $table -> dropForeign('amenity_apartment_apartment_id_foreign');

                $table -> dropColumn('amenity_id');
                $table -> dropColumn('apartment_id');
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

            /* Apartment--View */

            Schema::table('views', function (Blueprint $table) {

                $table -> dropForeign ('views_apartment_id_foreign');
                $table -> dropColumn("apartment_id");

            });

            /* Apartment--Sponsor */

            Schema::table('apartment_sponsor', function (Blueprint $table) {

                $table -> dropForeign ('apartment_sponsor_apartment_id_foreign');
                $table -> dropForeign ('apartment_sponsor_sponsor_id_foreign');

                $table -> dropColumn("apartment_id");
                $table -> dropColumn("sponsor_id");

            });


        }

};
