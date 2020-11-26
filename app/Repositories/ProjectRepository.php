<?php

namespace App\Repositories;


use App\Project;
use App\ProjectSkill;
use App\ProjectType;
use App\Skill;

class ProjectRepository
{
    /**
     * @return array
     */
    public function getProjectType()
    {
        return Project::getType();
    }

    /**
     * @return Skill[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getSkills()
    {
        return Skill::all();
    }

    /**
     * @param $data
     * @return mixed
     */
    public function create($data)
    {
        return Project::create($data->toArray());
    }

    public function update($data, Project $project)
    {
        return $project->update($data);
    }

    /**
     * @param $title
     * @return mixed
     */
    public function createSkill($title)
    {
        return Skill::firstOrCreate(['title' => $title]);
    }

    /**
     * @param Project $project
     * @param Skill $skill
     * @return mixed
     */
    public function saveRelationSkill(Project $project, $skill)
    {
        return ProjectSkill::create([
            'skill_id' => $skill,
            'project_id' => $project->id
        ]);
    }

    /**
     * @param bool $paginate
     * @return Project[]|\Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getProjects($paginate = false)
    {
        if ($paginate) {
            return Project::with('skill', 'user', 'type')
                ->orderBy('created_at', 'desc')
                ->paginate($paginate);
        } else {
            return Project::with('skill', 'user', 'type')
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    /**
     * @param $data
     * @param Project $project
     * @return mixed
     */
    public function deleteSkill($data, Project $project)
    {
        return ProjectSkill::where('project_id', $project->id)
            ->whereIn('skill_id', $data)
            ->delete();
    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchProjectForTitle($data)
    {
        return Project::with('skill', 'user', 'type')
            ->where('title', 'like', '%' . $data . '%')
            ->paginate(config('app.pagination_limit'));
    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchProjectForOrganization($data)
    {
        return Project::with('skill', 'user', 'type')
            ->where('organization', 'like', '%' . $data . '%')
            ->paginate(config('app.pagination_limit'));
    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchProjectForType($data)
    {
        return Project::with('skill', 'user', 'type')
            ->join('project_types', 'projects.type_id', 'project_types.id')
            ->where('project_types.title', 'like', '%' . $data . '%')
            ->select(['*',
                'projects.id as id',
                'projects.title as title',
            ])
            ->paginate(config('app.pagination_limit'));
    }

}