<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePencairanTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'pencairan';

    /**
     * Run the migrations.
     * @table pencairan
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nominal', 191)->nullable();
            $table->text('deskripsi');
            $table->string('status', 191)->default('MENUNGGU');
            $table->unsignedInteger('projek_id');
            $table->unsignedInteger('user_id');
	        $table->unsignedInteger('admin_id')->comment('admin yang acc pencairan');

            $table->index(["user_id"], 'fk_pencairan_users1_idx');

	        $table->index(["admin_id"], 'fk_pencairan_users2_idx');

            $table->index(["projek_id"], 'fk_pencairan_projek1_idx');
            $table->nullableTimestamps();

            $table->foreign('projek_id', 'fk_pencairan_projek1_idx')
                ->references('id')->on('projek');

            $table->foreign('user_id', 'fk_pencairan_users1_idx')
                ->references('id')->on('users');

            $table->foreign('admin_id', 'fk_pencairan_users2_idx')
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
