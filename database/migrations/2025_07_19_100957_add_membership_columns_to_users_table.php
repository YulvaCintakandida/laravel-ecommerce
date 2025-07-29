<?php
// database/migrations/xxxx_add_membership_columns_to_users_table.php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('membership_type', ['regular', 'vip'])->default('regular')->after('role');
            $table->timestamp('membership_expires_at')->nullable()->after('membership_type');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['membership_type', 'membership_expires_at']);
        });
    }
};