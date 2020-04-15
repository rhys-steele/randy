<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Robot;

class PopulateRobotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $robot = new Robot();
        $robot->name = "Randy";
        $robot->ip_address = "192.168.0.25";
        $robot->control_port = "8000";
        $robot->webcam_port = "8081";
        $robot->motor_a_en_pin = 26;
        $robot->motor_a_in_1_pin = 0;
        $robot->motor_a_in_2_pin = 3;
        $robot->motor_b_en_pin = 1;
        $robot->motor_b_in_1_pin = 21;
        $robot->motor_b_in_2_pin = 22;
        $robot->webcam_x_pin = 23;
        $robot->webcam_y_pin = 24;
        $robot->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Robot::find(1)->delete();
    }
}
