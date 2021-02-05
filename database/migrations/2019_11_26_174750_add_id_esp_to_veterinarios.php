<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdEspToVeterinarios extends Migration
{
    
    public function up()
    {
        Schema::table('veterinarios', function (Blueprint $table) {
            $table->unsignedBigInteger('especialidade_id');
            $table->foreign('especialidade_id')->references('id')->on('especialidades');
        });
    }

   
    public function down()
    {
        Schema::table('veterinarios', function (Blueprint $table) {
           
            $table->dropForeign(['especialidade_id']);
            $table->dropColumn(['especialidade_id']);
        });
    }
}
