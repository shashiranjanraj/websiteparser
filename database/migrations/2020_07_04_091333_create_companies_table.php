<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *  8048740318
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cin')->nullable();
            $table->string('name')->nullable();
            $table->enum('status',['Active','Not Active'])->nullable();
            $table->string('age')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('category')->nullable();
            $table->string('class')->nullable();
            $table->string('Roc_Code')->nullable();
            $table->string('numbers_of_memmber')->nullable();
            $table->string('is_listed')->nullable();
            $table->date('last_agm')->nullable();
            $table->date('last_balance_sheet')->nullable();
            $table->string('state')->nullable();
            $table->string('district')->nullable();
            $table->string('city')->nullable();
            $table->string('pin')->nullable();
            $table->string('section')->nullable();
            $table->string('divison')->nullable();
            $table->string('main_group')->nullable();
            $table->string('main_class')->nullable();

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
        Schema::dropIfExists('companies');
    }
}
