<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRobotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('robots', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 60);
            $table->string('ip_address', 15);
            $table->string('control_port');
            $table->string('webcam_port');
            $table->integer('motor_a_en_pin');
            $table->integer('motor_a_in_1_pin');
            $table->integer('motor_a_in_2_pin');
            $table->integer('motor_b_en_pin');
            $table->integer('motor_b_in_1_pin');
            $table->integer('motor_b_in_2_pin');
            $table->integer('webcam_x_pin');
            $table->integer('webcam_y_pin');
            $table->enum('state' , ['stopped', 'running'])->default('stopped');
            $table->enum('state_direction' , ['forward', 'backward'])->default('forward');
            $table->integer('state_left_speed')->default(0);
            $table->integer('state_right_speed')->default(0);
            $table->integer('state_webcam_x')->default(90);
            $table->integer('state_webcam_y')->default(90);
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
        Schema::dropIfExists('robots');
    }
}
