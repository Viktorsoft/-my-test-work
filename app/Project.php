<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    public const WORK = 'work';
    public const BOOK = 'book';
    public const COURSE = 'course';
    public const BLOG = 'blog';
    public const OTHER = 'other';

    public const EXCEL = 'xls';
    public const CSV = 'csv';

    /**
     * @return array
     */
    public static function getType()
    {
        return [
            self::WORK => 1,
            self::BOOK => 2,
            self::COURSE => 3,
            self::OTHER => 4,
        ];
    }

    /**
     * @return array
     */
    public static function getTypeFile()
    {
        return [
            1 => self::EXCEL,
            2 => self::CSV ,
        ];
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'user_id',
        'description',
        'organization',
        'start',
        'end',
        'role',
        'link',
        'skill_id',
        'type_id',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function skill()
    {
        return $this->belongsToMany(Skill::class, 'project_skills');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->hasOne(ProjectType::class, 'id', 'type_id');
    }
}
