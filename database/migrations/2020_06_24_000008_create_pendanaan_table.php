<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePendanaanTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'pendanaan';

    /**
     * Run the migrations.
     * @table pendanaan
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nominal', 191);
            $table->string('metode', 191);
            $table->string('bukti', 191)->nullable();
            $table->string('keterangan', 191)->nullable();
            $table->string('status', 191)->default('MENUNGGU');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('projek_id');

            $table->index(["user_id"], 'fk_pembayaran_users1_idx');

            $table->index(["projek_id"], 'fk_pembayaran_projek1_idx');
            $table->nullableTimestamps();

            $table->foreign('user_id', 'fk_pembayaran_users1_idx')
                ->references('id')->on('users');

            $table->foreign('projek_id', 'fk_pembayaran_projek1_idx')
                ->references('id')->on('projek');
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
