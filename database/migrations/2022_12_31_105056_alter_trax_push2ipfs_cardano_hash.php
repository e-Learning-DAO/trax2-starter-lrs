<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTraxPush2ipfsCardanoHash extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trax_push2ipfs', function (Blueprint $table) {
            $table->text('cardano_hash')->nullable(true)->after('hash');
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
            $table->dropColumn('cardano_hash');
        });
    }
}
