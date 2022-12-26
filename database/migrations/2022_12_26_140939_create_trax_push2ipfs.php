<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTraxPush2ipfs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trax_push2ipfs', function (Blueprint $table) {

            $table->increments('id');
            $table->unsignedBigInteger('statement_id');
            $table->text('hash');

            $table->smallInteger('status')->unsigned();
            $table->dateTime('processed_time');
            $table->text('error');

            // Indexes.
            $table->index('status');

            // Foreign keys.
            $table->foreign('statement_id')->references('id')->on('trax_xapi_statements')
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
        Schema::table('trax_push2ipfs', function (Blueprint $table) {
            $table->dropForeign('trax_push2ipfs_statement_id_foreign');
        });
        Schema::dropIfExists('trax_push2ipfs');
    }
}
