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
        Schema::table('projects', function (Blueprint $table) {
            //CREA LA COLONNA type_id DENTRO LA TABELLA projects
            $table->unsignedBigInteger('type_id')->nullable()->after('id');
            //CREA LA foreign_key
            $table->foreign('type_id')->references('id')->on('types')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            //CANCELLA LA FOREIGN_KEY
            $table->dropForeign('projects_type_id_foreign');
            //CANCELLA LA COLONNA type_id
            $table->dropColumn('type_id');
        });
    }
};
