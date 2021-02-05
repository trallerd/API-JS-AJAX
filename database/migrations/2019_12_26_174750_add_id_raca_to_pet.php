<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdRacaToPet extends Migration
{
    
    public function up()
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->unsignedBigInteger('raca_id');
            $table->foreign('raca_id')->references('id')->on('racas');
        });
    }

   
    public function down()
    {
        Schema::table('pets', function (Blueprint $table) {
           
            $table->dropForeign(['raca_id']);
            $table->dropColumn(['raca_id']);
        });
    }
}
