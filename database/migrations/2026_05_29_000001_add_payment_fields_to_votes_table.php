<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::table('votes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable()->change();
            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();

            $table->decimal('montant', 12, 2)->nullable()->after('edition_id');
            $table->string('payment_reference')->nullable()->after('montant');
            $table->string('payment_method')->nullable()->after('payment_reference');
            $table->string('payment_status')->default('completed')->after('payment_method');
        });
    }

    public function down(): void
    {
        Schema::table('votes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn(['montant', 'payment_reference', 'payment_method', 'payment_status']);
        });

        Schema::table('votes', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
