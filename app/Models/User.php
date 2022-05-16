<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentsAsRecipient()
    {
        return $this->hasMany(Comment::class, 'recipient_id');
    }

    public function books()
    {
        return $this->hasMany(Books::class);
    }

    public function readers()
    {
        return $this->belongsToMany(self::class, 'books_access', 'owner_id', 'reader_id');
    }

    public function hasLibraryAccess()
    {
        return $this->belongsToMany(self::class, 'books_access', 'reader_id', 'owner_id');
    }

    public function hasBooksAccess(int $ownerId)
    {
        return DB::table('books_access')
            ->where('owner_id', $ownerId)
            ->where('reader_id', $this->id)
            ->first();
    }
}
