<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->longText('body')->nullable();
            $table->dateTime('read_at')->nullable();
            $table->string('fcm_multicast_id')->nullable();
            $table->string('fcm_success')->nullable();
            $table->string('fcm_canonical_ids')->nullable();
            $table->string('fcm_results')->nullable();
            $table->foreignUuid('receiver_id')->nullable()->references('id')->on('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
};
