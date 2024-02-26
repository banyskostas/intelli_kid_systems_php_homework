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
 * @property bool $is_manually_deleted
 * @property string $created_at
 * @property string $deleted_at
 */
class ShortenedUrlsArchive extends Model
{
    protected $table = 'shortened_urls_archive';
    public $timestamps = false;

    const COL_ID = 'id';
    const COL_URL = 'url';
    const COL_SHORT_URL = 'short_url';
    const COL_VALID_UNTIL = 'valid_until';
    const COL_IS_MANUALLY_DELETED = 'is_manually_deleted';
    const COL_CREATED_AT = 'created_at';
    const COL_DELETED_AT = 'deleted_at';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        self::COL_URL,
        self::COL_SHORT_URL,
        self::COL_VALID_UNTIL,
        self::COL_IS_MANUALLY_DELETED,
        self::COL_CREATED_AT,
        self::COL_DELETED_AT,
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
