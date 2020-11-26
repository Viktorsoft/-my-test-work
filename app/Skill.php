<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = [
        'title',
        ];

    public const PHP = 'php';
    public const C = 'c';
    public const JAVA = 'java';
    public const PYTHON = 'python';
    public const ASSEMBLER = 'assembler';

    public static function getDefaultSkills()
    {
        return [
            self::PHP => 1,
            self::C => 2,
            self::JAVA => 3,
            self::PYTHON => 4,
            self::ASSEMBLER => 5,
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function project()
    {
        return $this->belongsToMany(Project::class, 'project_skills');
    }
}
