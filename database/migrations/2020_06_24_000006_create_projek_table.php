<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjekTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'projek';

    /**
     * Run the migrations.
     * @table projek
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('nama', 191);
            $table->string('slug', 191);
            $table->text('deskripsi');
            $table->date('tenggat_waktu')->nullable();
            $table->string('nominal', 191);
            $table->string('gambar', 191)->nullable();
            $table->string('status', 191)->default('MENUNGGU');
            $table->unsignedInteger('kategori_id');
            $table->unsignedInteger('label_id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('kota_id');
	        $table->unsignedInteger('mitra')->nullable()->default(NULL);

            $table->index(["kota_id"], 'fk_projek_kota1_idx');

            $table->index(["user_id"], 'fk_projek_users1_idx');
	        $table->index(["mitra"], 'fk_projek_users2_idx');

            $table->index(["kategori_id"], 'fk_projek_kategori1_idx');

            $table->index(["label_id"], 'fk_projek_label1_idx');

            $table->unique(["slug"], 'slug_UNIQUE');

            $table->unique(["nama"], 'nama_UNIQUE');
            $table->nullableTimestamps();

            $table->foreign('kategori_id', 'fk_projek_kategori1_idx')
                ->references('id')->on('kategori');

            $table->foreign('label_id', 'fk_projek_label1_idx')
                ->references('id')->on('label');

            $table->foreign('user_id', 'fk_projek_users1_idx')
                ->references('id')->on('users');

            $table->foreign('kota_id', 'fk_projek_kota1_idx')
                ->references('id')->on('kota');
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
