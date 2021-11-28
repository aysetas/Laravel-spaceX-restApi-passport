<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapsulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capsules', function (Blueprint $table) {
            $table->id();
            $table->string('capsule_serial')->unique();
            $table->string('capsule_id')->nullable();
            $table->string('status')->nullable();
            $table->dateTimeTz('original_launch')->nullable();
            $table->unsignedInteger('original_launch_unix')->nullable();
            $table->unsignedInteger('landings')->nullable();
            $table->string('type')->nullable();
            $table->string('details')->nullable();
            $table->unsignedInteger('reuse_count')->nullable();
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
        Schema::dropIfExists('capsules');
    }
}
