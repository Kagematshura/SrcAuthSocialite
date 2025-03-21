<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('drafts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('content');
            $table->string('type');
            $table->string('status')->default('pending');
            $table->timestamps(); // This automatically adds 'created_at' and 'updated_at'
        });
    }

    public function down()
    {
        Schema::dropIfExists('drafts');
    }
};
