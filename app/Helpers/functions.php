<?php

use App\Project;
use App\Skill;

/**
 * @param $data
 * @return string
 */
function dateFormat($data)
{
    return \Carbon\Carbon::parse($data)->format('Y-m-d');
}

/**
 * @param $projects
 * @return \Illuminate\Support\Collection
 */
function exportProject($projects)
{
    $head[0] = [
        'title' => '#Title',
        'user_id' => '#Author',
        'description' => '#Description',
        'organization' => '#Organization',
        'start' => '#Start',
        'end' => '#End',
        'role' => '#Role',
        'link' => '#Link',
        'skill_id' => '#Skills',
        'type_id' => '#Type',
    ];

    $data = $projects->map(function ($project, $key) {
        return [
            'title' => $project->title,
            'user_id' => $project->user->email,
            'description' => $project->description,
            'organization' => $project->organization,
            'start' => $project->start,
            'end' => $project->end,
            'role' => $project->role,
            'link' => $project->link,
            'skill_id' => json_encode($project->skill->pluck('title')),
            'type_id' => $project->type->title,
        ];
    });

    return collect(array_merge($head, $data->toArray()));
}

/**
 * @param $title
 * @return int
 */
function getProjectTypeId($title)
{
    $type = Project::getType();

    return isset($type[$title]) ? $type[$title] : 4;
}