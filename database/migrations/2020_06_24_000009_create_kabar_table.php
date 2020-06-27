<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKabarTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'kabar';

    /**
     * Run the migrations.
     * @table kabar
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('judul', 191)->nullable();
            $table->string('gambar', 191)->nullable();
            $table->string('konten', 191)->nullable();
            $table->unsignedInteger('projek_id');
            $table->unsignedInteger('user_id');

            $table->index(["user_id"], 'fk_kabar_users1_idx');

            $table->index(["projek_id"], 'fk_kabar_projek_idx');
            $table->nullableTimestamps();

            $table->foreign('projek_id', 'fk_kabar_projek_idx')
                ->references('id')->on('projek');

            $table->foreign('user_id', 'fk_kabar_users1_idx')
                ->references('id')->on('users');
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
