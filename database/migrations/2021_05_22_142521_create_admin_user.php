<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;

class CreateAdminUser extends Migration
{
    protected const ADMIN_EMAIL = 'admin@mail.com';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table(User::TABLE_NAME)->insert([
            User::FIRST_NAME => 'Admin',
            User::LAST_NAME => 'Admin',
            User::ROLE => User::ROLE_ADMIN,
            User::EMAIL => static::ADMIN_EMAIL,
            User::PASSWORD => password_hash('123456', PASSWORD_DEFAULT),
            User::CREATED_AT => Carbon::now(),
            User::UPDATED_AT => Carbon::now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $user = DB::table(User::TABLE_NAME)
            ->where(User::EMAIL, '=', static::ADMIN_EMAIL)
            ->first(['id']);
        if ($user) {
            DB::table(User::TABLE_NAME)->delete($user->id);
        }
    }
}
