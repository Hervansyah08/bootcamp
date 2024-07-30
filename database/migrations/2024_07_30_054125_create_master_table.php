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
        Schema::create('master', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('email');
            $table->string('nama');
            $table->enum('gender', ['Pria', 'Wanita']);
            $table->date('tanggal_lahir');
            $table->string('alamat');
            $table->string('no_hp');
            $table->string('status_pekerjaan');
            $table->string('instansi');
            $table->foreignId('program_id')->constrained('program')->onDelete('cascade');
            $table->string('info');
            $table->text('motivasi')->nullable();
            $table->string('status')->default('Pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master');
    }
};
