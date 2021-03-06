<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * User object.
 *
 * @property int $id User identifier
 * @property string $firstName User first name
 * @property string $lastName User last name
 * @property string $email User email
 * @property string $password User hash password
 * @property string $role User role
 * @property Carbon $createdAt User created at
 * @property Carbon $updatedAt User updated at
 * @property Carbon $deletedAt User deleted at
 *
 * @property-read Collection|Message[] $messages User messages
 */
class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes;
    
    public const ID = 'id';
    public const FIRST_NAME = 'firstName';
    public const LAST_NAME = 'lastName';
    public const EMAIL = 'email';
    public const PASSWORD  = 'password';
    public const ROLE = 'role';
    public const CREATED_AT = 'createdAt';
    public const UPDATED_AT = 'updatedAt';
    public const DELETED_AT = 'deletedAt';
    
    public const TABLE_NAME = 'users';
    
    public const ROLE_ADMIN = 'admin';
    public const ROLE_USER = 'user';
    
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
        self::LAST_NAME,
        self::FIRST_NAME,
        self::EMAIL,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        self::PASSWORD,
    ];
    
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [
        self::PASSWORD,
        self::ROLE,
    ];
    
    /**
     * {@inheritDoc}
     */
    public function getJWTIdentifier(): string
    {
        return $this->getKey();
    }
    
    /**
     * {@inheritdoc}
     */
    public function getJWTCustomClaims(): array
    {
        return [];
    }
    
    /**
     * User messages.
     *
     * @return HasMany
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }
}
