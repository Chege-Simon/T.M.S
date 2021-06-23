<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrackRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('track_records', function (Blueprint $table) {
            $table->id();
            $table->String('date');
            $table->String('truck_number_plate');
            $table->String('region');
            $table->String('destination');
            $table->String('customer');
            $table->String('track_record_receipt_number');
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
        Schema::dropIfExists('track_records');
    }
}
