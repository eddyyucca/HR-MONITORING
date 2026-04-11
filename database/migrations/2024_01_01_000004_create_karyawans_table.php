<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('salutation', 10)->nullable();
            $table->string('nama');
            $table->string('no_karyawan', 50)->nullable()->unique();
            $table->text('alamat')->nullable();
            $table->string('no_telp', 30)->nullable();
            $table->string('email')->nullable();
            $table->string('company')->default('PT Sulawesi Cahaya Mineral');
            $table->string('position');
            $table->foreignId('jabatan_id')->nullable()->constrained('jabatans')->nullOnDelete();
            $table->foreignId('departemen_id')->nullable()->constrained('departemens')->nullOnDelete();
            $table->foreignId('divisi_id')->nullable()->constrained('divisis')->nullOnDelete();
            $table->string('work_location')->default('Konawe Site');
            $table->enum('tipe', ['Staff','Non-Staff'])->default('Staff');
            $table->string('level')->nullable();
            $table->string('level_direct_report')->nullable();
            $table->integer('grade')->nullable();
            $table->enum('terms', ['PKWT','PKWTT'])->default('PKWT');
            $table->string('durasi')->nullable();
            $table->string('durasi_en')->nullable();
            $table->enum('status', ['Kontrak','Percobaan','Tetap','Selesai'])->default('Kontrak');
            $table->date('tgl_ol')->nullable();
            $table->date('tgl_berakhir')->nullable();
            $table->string('poh')->nullable();
            $table->decimal('basic_salary', 15, 2)->nullable();
            $table->string('nominal_terbilang')->nullable();
            $table->string('nominal_terbilang_id')->nullable();
            $table->integer('weeks_on')->nullable();
            $table->integer('weeks_off')->nullable();
            $table->decimal('inpatient_local', 15, 2)->nullable();
            $table->decimal('inpatient_interlokal', 15, 2)->nullable();
            $table->decimal('outpatient', 15, 2)->nullable();
            $table->decimal('frames', 15, 2)->nullable();
            $table->decimal('lens', 15, 2)->nullable();
            $table->string('signature_name')->nullable();
            $table->string('signature_title')->nullable();
            $table->foreignId('rekrutmen_id')->nullable()->constrained('rekrutmens')->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['tipe', 'status']);
            $table->index(['divisi_id', 'tipe']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('karyawans');
    }
};
