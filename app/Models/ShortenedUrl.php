<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ShortenedUrl
 * @package App\Models
 *
 * @property int $id
 * @property string $url
 * @property string $short_url
 * @property string $valid_until
 * @property string|null $passcode
 * @property string $created_at
 */
class ShortenedUrl extends Model
{
    public $timestamps = false;

    const COL_ID = 'id';
    const COL_URL = 'url';
    const COL_SHORT_URL = 'short_url';
    const COL_VALID_UNTIL = 'valid_until';
    const COL_PASSCODE = 'passcode';
    const COL_CREATED_AT = 'created_at';

    // Data lengths
    const LENGTH_SHORT_URL = 6; // By DB VARCHAR
    const LENGTH_PASSCODE = 12; // By DB VARCHAR

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::COL_URL,
        self::COL_SHORT_URL,
        self::COL_VALID_UNTIL,
        self::COL_PASSCODE,
        self::COL_CREATED_AT,
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        self::COL_VALID_UNTIL => 'datetime',
        self::COL_CREATED_AT => 'datetime',
    ];
}
