<?php

use App\Models\Asset;
use App\Models\Report;
use App\Models\RiskLevel;
use App\Models\Status;
use App\Models\User;
use App\Models\Vulnerability;
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
        Schema::create('associated_vulnerabilities', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Asset::class);
            $table->foreignIdFor(Vulnerability::class);
            $table->foreignIdFor(RiskLevel::class);
            $table->foreignIdFor(Status::class);
            $table->foreignIdFor(User::class);
            $table->foreignIdFor(Report::class);
            $table->date('patch_max_at')->nullable();
            $table->date('last_scan_at')->nullable();
            $table->date('patch_at')->nullable();
            $table->text('comments')->nullable();
            $table->string('port',20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('associated_vulnerabilities');
    }
};
