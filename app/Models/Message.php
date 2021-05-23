<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Message object.
 *
 * @property int $id Message identifier
 * @property int $userId User identifier
 * @property string $message Text message
 * @property Carbon $createdAt Message created at
 * @property Carbon $updatedAt Message updated at
 * @property Carbon $deletedAt Message deleted at
 *
 * @property-read User $user User of the message
 */
class Message extends Model
{
    use HasFactory, SoftDeletes;
    
    public const ID = 'id';
    public const USER_ID = 'userId';
    public const MESSAGE = 'message';
    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';
    public const DELETED_AT = 'deletedAt';
    
    public const TABLE_NAME = 'messages';
    
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;
    
    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;
    
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = self::ID;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::USER_ID,
        self::MESSAGE,
        self::USER_ID,
    ];
    
    /**
     * User of message.
     *
     * @return BelongsTo
     */
    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
