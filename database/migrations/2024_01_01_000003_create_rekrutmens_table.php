<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('rekrutmens', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('no_telp', 30)->nullable();
            $table->string('email')->nullable();
            $table->enum('gender', ['Male','Female'])->nullable();
            $table->string('plan_job_title');
            $table->foreignId('departemen_id')->nullable()->constrained('departemens')->nullOnDelete();
            $table->foreignId('divisi_id')->nullable()->constrained('divisis')->nullOnDelete();
            $table->string('category_level')->nullable();
            $table->enum('status', ['Open','In Progress','Closed'])->default('Open');
            $table->string('progress')->default('Compro');
            $table->enum('priority', ['P1','P2','P3','NP'])->nullable();
            $table->enum('status_ata', ['Full Approval','Not Yet','Pending'])->nullable();
            $table->enum('sourch', ['Referral','BSI','LinkedIn','PUS','JobStreet','Indeed','Internal','Lainnya'])->nullable();
            $table->string('user_pic')->nullable();
            $table->string('site')->default('Konawe');
            $table->date('date_approved')->nullable();
            $table->date('date_progress')->nullable();
            $table->tinyInteger('month_number')->nullable();
            $table->string('month_name', 20)->nullable();
            $table->year('year')->nullable();
            $table->decimal('sla', 10, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->string('evrp_bsi')->nullable();
            $table->string('evrp_wetar')->nullable();
            $table->string('ata_status')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['progress', 'year']);
            $table->index(['divisi_id', 'year']);
            $table->index(['priority', 'status']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('rekrutmens');
    }
};
