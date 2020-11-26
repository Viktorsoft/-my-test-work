<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->smallInteger('user_id');
            $table->string('title', 255);
            $table->text('description', 2000);
            $table->string('organization', 255)->nullable()->default(null);
            $table->timestamp('start')->nullable()->default(null);
            $table->timestamp('end')->nullable()->default(null);
            $table->string('role', 255);
            $table->string('link', 255)->nullable()->default(null);
            $table->smallInteger('type_id');
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
        Schema::dropIfExists('projects');
    }
}
