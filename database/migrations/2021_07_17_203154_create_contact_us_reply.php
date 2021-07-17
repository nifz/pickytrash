<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactUsReply extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contact_us_reply', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_users');
            $table->bigInteger('id_contact_us');
            $table->string('name');
            $table->string('email');
            $table->string('subject');
            $table->text('message');
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
        Schema::dropIfExists('contact_us_reply');
    }
}
