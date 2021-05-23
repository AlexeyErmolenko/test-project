<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(User::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->string(User::FIRST_NAME,30)->nullable();
            $table->string(User::LAST_NAME, 30)->nullable();
            $table->string(User::EMAIL, 100)->unique();
            $table->string(User::PASSWORD, 120);
            $table->enum(User::ROLE, [User::ROLE_ADMIN, User::ROLE_USER])->default(User::ROLE_USER);
            $table->timestamp(User::CREATED_AT, 0)->nullable();
            $table->timestamp(User::UPDATED_AT, 0)->nullable();
            $table->timestamp(User::DELETED_AT, 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(User::TABLE_NAME);
    }
}
