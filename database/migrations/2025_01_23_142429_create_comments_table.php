<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->text('comment');
            $table->unsignedBigInteger('commentable_id'); // Untuk polymorphic relationship
            $table->string('commentable_type'); // Nama model (User atau Pengunjung)
            $table->integer('id_berita'); // Foreign key ke tabel berita
            $table->timestamps();

            $table->foreign('id_berita')->references('id_berita')->on('berita')->onDelete('cascade');
            $table->index(['commentable_id', 'commentable_type']); // Index untuk polymorphic
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
