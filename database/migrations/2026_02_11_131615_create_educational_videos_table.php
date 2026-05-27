<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('educational_videos', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('video_url'); // YouTube/Vimeo link
            $table->foreignId('level_id')->constrained('levels')->onDelete('cascade');
            $table->integer('exp_reward')->default(10); // EXP yang didapat setelah menonton
            $table->integer('duration')->nullable(); // dalam menit
            $table->integer('order')->default(0); // urutan video
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('educational_videos');
    }
};