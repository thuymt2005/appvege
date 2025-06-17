<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->date('date_of_birth')->nullable()->after('password');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['date_of_birth', 'gender']);
        });
    }
};
