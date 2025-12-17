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
        Schema::table('articles', function (Blueprint $table) {
            $table->text('resume')->nullable()->change();
            $table->text('texte')->nullable()->change();
            $table->string('image')->nullable()->change();
            $table->string('media')->nullable()->change();
            $table->foreignIdFor(\App\Models\Rythme::class)->nullable()->change();
            $table->foreignIdFor(\App\Models\Accessibilite::class)->nullable()->change();
            $table->foreignIdFor(\App\Models\Conclusion::class)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->text('resume')->nullable(false)->change();
            $table->text('texte')->nullable(false)->change();
            $table->string('image')->nullable(false)->change();
            $table->string('media')->nullable(false)->change();
            $table->foreignIdFor(\App\Models\Rythme::class)->nullable(false)->change();
            $table->foreignIdFor(\App\Models\Accessibilite::class)->nullable(false)->change();
            $table->foreignIdFor(\App\Models\Conclusion::class)->nullable(false)->change();
        });
    }
};
