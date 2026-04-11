<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('divisis', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->string('kode', 10)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('departemens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('divisi_id')->nullable()->constrained('divisis')->nullOnDelete();
            $table->string('nama');
            $table->string('kode', 10)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            $table->index('divisi_id');
        });

        Schema::create('jabatans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('departemen_id')->nullable()->constrained('departemens')->nullOnDelete();
            $table->string('nama');
            $table->enum('level', ['Executive Committee','General Manager','Senior Manager','Manager','Assistant Manager','Supervisor','Officer','Labour Supply','Non-Staff'])->default('Officer');
            $table->integer('grade')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }
    public function down(): void {
        Schema::dropIfExists('jabatans');
        Schema::dropIfExists('departemens');
        Schema::dropIfExists('divisis');
    }
};
