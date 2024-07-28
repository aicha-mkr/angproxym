<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecapitulatifsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recapitulatifs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->decimal('ventes_realisees', 8, 2);
            $table->integer('clients_visites');
            $table->integer('articles_vendus');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
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
        Schema::dropIfExists('recapitulatifs');
    }
}
