<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMitraTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'mitra';

    /**
     * Run the migrations.
     * @table mitra
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('pj', 191)->nullable();
            $table->unsignedInteger('user_id')->comment('akun mitra');

            $table->index(["user_id"], 'fk_mitra_users1_idx');
            $table->nullableTimestamps();

            $table->foreign('user_id', 'fk_mitra_users1_idx')
                ->references('id')->on('users')
		->onDelete('cascade');
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
