<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKotaTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'kota';

    /**
     * Run the migrations.
     * @table kota
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('kota', 191);
            $table->unsignedInteger('provinsi_id');

            $table->index(["provinsi_id"], 'fk_kota_provinsi1_idx');
            $table->nullableTimestamps();

            $table->foreign('provinsi_id', 'fk_kota_provinsi1_idx')
                ->references('id')->on('provinsi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
