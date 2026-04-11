<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('mpp_positions', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->string('job_title');
            $table->string('app_name')->nullable();
            $table->string('cost_centre')->nullable();
            $table->string('site')->default('Konawe');
            $table->foreignId('departemen_id')->nullable()->constrained('departemens')->nullOnDelete();
            $table->foreignId('divisi_id')->nullable()->constrained('divisis')->nullOnDelete();
            $table->string('category_grade')->nullable();
            // MPP Plan per bulan
            $table->integer('mpp_jan')->default(0); $table->integer('mpp_feb')->default(0);
            $table->integer('mpp_mar')->default(0); $table->integer('mpp_apr')->default(0);
            $table->integer('mpp_may')->default(0); $table->integer('mpp_jun')->default(0);
            $table->integer('mpp_jul')->default(0); $table->integer('mpp_aug')->default(0);
            $table->integer('mpp_sep')->default(0); $table->integer('mpp_oct')->default(0);
            $table->integer('mpp_nov')->default(0); $table->integer('mpp_dec')->default(0);
            // Existing per bulan
            $table->integer('existing_jan')->default(0); $table->integer('existing_feb')->default(0);
            $table->integer('existing_mar')->default(0); $table->integer('existing_apr')->default(0);
            $table->integer('existing_may')->default(0); $table->integer('existing_jun')->default(0);
            $table->integer('existing_jul')->default(0); $table->integer('existing_aug')->default(0);
            $table->integer('existing_sep')->default(0); $table->integer('existing_oct')->default(0);
            $table->integer('existing_nov')->default(0); $table->integer('existing_dec')->default(0);
            $table->text('remarks')->nullable();
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['tahun','divisi_id']);
            $table->index(['category_grade','tahun']);
        });

        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('module');
            $table->string('action');
            $table->string('subject_type')->nullable();
            $table->unsignedBigInteger('subject_id')->nullable();
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();
            $table->index(['module','action']);
        });
    }
    public function down(): void {
        Schema::dropIfExists('activity_logs');
        Schema::dropIfExists('mpp_positions');
    }
};
