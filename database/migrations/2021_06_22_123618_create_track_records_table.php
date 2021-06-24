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
            $table->date('date');
            $table->integer('truck_id')->unsigned()->index();
            $table->integer('region_id')->unsigned()->index();
            $table->String('destination');
            $table->integer('client_id')->unsigned()->index();
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
