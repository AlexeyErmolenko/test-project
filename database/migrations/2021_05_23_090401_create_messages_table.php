<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Message;
use App\Models\User;

class CreateMessagesTable extends Migration
{
    protected const FK_USERS_MESSAGES = 'FK_users_messages';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Message::TABLE_NAME, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger(Message::USER_ID);
            $table->text(Message::MESSAGE)->nullable();
            $table->timestamp(Message::CREATED_AT, 0)->nullable();
            $table->timestamp(Message::UPDATED_AT, 0)->nullable();
            $table->timestamp(Message::DELETED_AT, 0)->nullable();
        });
        
        Schema::table(Message::TABLE_NAME, function (Blueprint $table) {
            $table->foreign(Message::USER_ID, self::FK_USERS_MESSAGES)
                ->references(User::ID)
                ->on(User::TABLE_NAME)
                ->onUpdate('RESTRICT')
                ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table(Message::TABLE_NAME, function (Blueprint $table) {
            $table->dropForeign(self::FK_USERS_MESSAGES);
        });
        
        Schema::dropIfExists(Message::TABLE_NAME);
    }
}
