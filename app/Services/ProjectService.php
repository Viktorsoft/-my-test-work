<?php

namespace App\Services;


use App\Imports\ProjectsImport;
use App\Project;
use App\Repositories\ProjectRepository;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProjectService
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * ProjectService constructor.
     * @param ProjectRepository $projectRepository
     */
    public function __construct(
        ProjectRepository $projectRepository
    )
    {
        $this->projectRepository = $projectRepository;
    }

    /**
     * @param $data
     * @return array
     */
    public function createProject($data)
    {
        $data['user_id'] = auth()->id();

        try {
            DB::beginTransaction();
            $project = $this->projectRepository->create($data);
            if (isset($data['skills'])) {
                if (!empty($data['skills'])) {
                    foreach ($data['skills'] as $skill) {
                        $this->projectRepository->saveRelationSkill($project, $skill);
                    }
                }
            }
            DB::commit();

            return ['success' => $project];
        } catch (\Throwable  $e) {
            DB::rollback();

            return ['error' => $e];
        }
    }

    /**
     * @param $data
     * @param Project $project
     * @return array
     */
    public function updateProject($data, Project $project)
    {
        try {
            DB::beginTransaction();
            $status = $this->projectRepository->update($data->toArray(), $project);
            if ($status) {
                if (isset($data['skills'])) {
                    if (!empty($data['skills'])) {
                        $project = $project->load('skill');
                        $skillOld = $project->skill->pluck('id')->toArray();
                        foreach ($data['skills'] as $skill) {
                            if (!in_array($skill, $skillOld)) {
                                $this->projectRepository->saveRelationSkill($project, $skill);
                            }
                            if (($key = array_search($skill, $skillOld)) !== FALSE) {
                                unset($skillOld[$key]);
                            }
                        }
                        $this->projectRepository->deleteSkill($skillOld, $project);
                    }
                }
                DB::commit();
                return ['success' => $project];
            } else {
                DB::rollback();
                return ['error' => 'Not updated'];
            }
        } catch (\Throwable  $e) {
            DB::rollback();
            return ['error' => $e];
        }
    }

    /**
     * @param Project $project
     * @return array
     */
    public function delete(Project $project)
    {
        try {
            DB::beginTransaction();
            $project = $project->load('skill');
            $skillOld = $project->skill->pluck('id')->toArray();
            $this->projectRepository->deleteSkill($skillOld, $project);
            $project->delete();
            DB::commit();

            return ['success' => $project];
        } catch (\Throwable  $e) {
            DB::rollback();

            return ['error' => $e];
        }
    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchProjectTitle($data)
    {
        return $this->projectRepository->searchProjectForTitle($data);
    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchProjectOrganization($data)
    {
        return $this->projectRepository->searchProjectForOrganization($data);
    }

    /**
     * @param $data
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchProjectType($data)
    {
        return $this->projectRepository->searchProjectForType($data);
    }

    /**
     * @param $file
     */
    public function importFile($file)
    {
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        if ($finfo->file($file) == 'application/vnd.ms-excel') {
            $defaultTypeFile = Project::EXCEL;
        } else {
            $defaultTypeFile = Project::CSV;
        }

        //$defaultTypeFile = Project::getTypeFile();
        $file->move(storage_path('app'), 'temporary_name' . '.' . $defaultTypeFile);
        Excel::import(new ProjectsImport, 'temporary_name' . '.' . $defaultTypeFile);
        unlink(storage_path('app/temporary_name' . '.' . $defaultTypeFile));
    }
}