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
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('tel');
            $table->integer('role');
            $table->timestamps();
        });

        Schema::create('demandes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('problems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tech_id');

            $table->string('autre')->nullable();
            $table->unsignedInteger('demande_id')->unique();
            $table->timestamps();

            $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('cascade');
        });
        Schema::create('interventions', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('categ');
            $table->unsignedBigInteger('problem_id');
            $table->timestamps();

            $table->foreign('problem_id')->references('id')->on('problems')->onDelete('cascade');
        });

        Schema::create('options', function (Blueprint $table) {
            $table->id();
            
            $table->string('type');
            $table->string('categ');

            $table->unsignedBigInteger('problem_id');
            $table->timestamps();

            $table->foreign('problem_id')->references('id')->on('problems')->onDelete('cascade');
        });

        Schema::create('diagnostics', function (Blueprint $table) {
            $table->id();
            $table->string('type');
            $table->string('categ');

            $table->unsignedBigInteger('problem_id');
            $table->timestamps();

            $table->foreign('problem_id')->references('id')->on('problems')->onDelete('cascade');
        });
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('value');
            $table->unsignedInteger('demande_id');
            $table->timestamps();

            $table->foreign('demande_id')->references('id')->on('demandes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('diagnostics');
        Schema::dropIfExists('options');
        Schema::dropIfExists('interventions');
        Schema::dropIfExists('problems');
        Schema::dropIfExists('demandes');
        Schema::dropIfExists('users');    }
};
