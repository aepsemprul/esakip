<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePpkIndikatorKinerjaDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ppk_indikator_kinerja_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->smallInteger('indikator_kinerja_id')->nullable()->default(12);
            $table->text('program')->nullable()->default('text');
            $table->string('anggaran_program', 100)->nullable()->default('text');
            $table->string('indikator_program', 100)->nullable()->default('text');
            $table->string('target_program', 100)->nullable()->default('text');
            $table->timestamps();
            $table->softDeletes();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ppk_indikator_kinerja_details');
    }
}
