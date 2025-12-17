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
        // SQLite doesn't support changing columns directly, so we skip this for SQLite
        if (Schema::getConnection()->getDriverName() !== 'sqlite') {
            Schema::table('articles', function (Blueprint $table) {
                $table->text('resume')->nullable()->change();
                $table->text('texte')->nullable()->change();
                $table->string('image')->nullable()->change();
                $table->string('media')->nullable()->change();
                $table->unsignedBigInteger('rythme_id')->nullable()->change();
                $table->unsignedBigInteger('accessibilite_id')->nullable()->change();
                $table->unsignedBigInteger('conclusion_id')->nullable()->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // SQLite doesn't support changing columns directly, so we skip this for SQLite
        if (Schema::getConnection()->getDriverName() !== 'sqlite') {
            Schema::table('articles', function (Blueprint $table) {
                $table->text('resume')->nullable(false)->change();
                $table->text('texte')->nullable(false)->change();
                $table->string('image')->nullable(false)->change();
                $table->string('media')->nullable(false)->change();
                $table->unsignedBigInteger('rythme_id')->nullable(false)->change();
                $table->unsignedBigInteger('accessibilite_id')->nullable(false)->change();
                $table->unsignedBigInteger('conclusion_id')->nullable(false)->change();
            });
        }
    }
};
