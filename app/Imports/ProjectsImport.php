<?php

namespace App\Imports;


use App\Project;
use App\ProjectSkill;
use App\Skill;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ProjectsImport implements ToCollection
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {
            if ($row[0] != '#Title') {
                $type = getProjectTypeId($row[9]);
                $project = Project::create([
                    'title' => $row[0],
                    'user_id' => auth()->user()->id,
                    'description' => $row[2],
                    'organization' => $row[3],
                    'start' => Carbon::parse($row[4])->format('Y-m-d H:i:s'),
                    'end' => Carbon::parse($row[5])->format('Y-m-d H:i:s'),
                    'role' => $row[6],
                    'link' => $row[7],
                    'type_id' => $type,
                ]);

                foreach (json_decode($row[8]) as $title) {
                    $skill = Skill::firstOrCreate(['title' => $title]);

                    ProjectSkill::create([
                        'skill_id' => $skill->id,
                        'project_id' => $project->id
                    ]);
                }
            }
        }
    }
}