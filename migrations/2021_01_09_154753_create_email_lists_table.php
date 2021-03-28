<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmailListsTable extends Migration
{
    public function up()
    {
        /**
         * List email is list email send, separating accents "," if multiple emails.
         * It will be sent each email with the content in the email template
         * params is a json, params will be map to content email when sending
         * */
        Schema::create('email_lists', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email', 150)->index();
            $table->unsignedBigInteger('template_id')->index();
            $table->text('params')->nullable();
            $table->integer('priority')->default(1);
            $table->timestamps();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('email_lists');
    }
}
