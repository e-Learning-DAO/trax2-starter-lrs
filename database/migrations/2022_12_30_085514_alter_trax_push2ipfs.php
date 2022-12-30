<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTraxPush2ipfs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trax_push2ipfs', function (Blueprint $table) {
            $table->text('wallet_address')->after('id');
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
            $table->dropColumn('wallet_address');
        });
    }
}
