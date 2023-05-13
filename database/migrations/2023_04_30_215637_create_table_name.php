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
            $table->bigIncrements('id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email')->unique();
            $table->string('password');
            $table->integer('tel');
            $table->integer('role');
            $table->timestamps();
        });

        Schema::create('cars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('matricule')->unique();
            $table->string('model');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('reclamations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->boolean('repartition')->default(false);
            $table->boolean('desinstallation')->default(false);
            $table->boolean('reinstallation')->default(false);
            $table->boolean('nouvelinstallation')->default(false);
            $table->boolean('option')->default(false);
            $table->boolean('sim')->default(false);
            $table->boolean('isValid')->default(false);
            $table->unsignedBigInteger('car_id');
            $table->foreign('car_id')->references('id')->on('cars')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('interventions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date');
            $table->string('autre')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('reclamation_id');
            $table->foreign('reclamation_id')->references('id')->on('reclamations')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('taches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('categorie');
            $table->string('type');
            $table->string('value');
            $table->unsignedBigInteger('intervention_id');
            $table->foreign('intervention_id')->references('id')->on('interventions')->onDelete('cascade');
            $table->timestamps();
        });
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('email');
            $table->string('name')->nullable();
            $table->string('number')->nullable();
            $table->text('message');
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
        Schema::dropIfExists('taches');
        Schema::dropIfExists('interventions');
        Schema::dropIfExists('reclamations');
        Schema::dropIfExists('cars');
        Schema::dropIfExists('users');
    }
};
