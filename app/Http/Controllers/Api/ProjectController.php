<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\StoreProjectRequest;
use App\Project;
use App\Repositories\ProjectRepository;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;
    /**
     * @var ProjectService
     */
    private $projectService;

    /**
     * ProjectController constructor.
     * @param ProjectRepository $projectRepository
     * @param ProjectService $projectService
     */
    public function __construct(
        ProjectRepository $projectRepository,
        ProjectService $projectService
    )
    {
        $this->projectRepository = $projectRepository;
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            return response()->json($this->projectRepository->getProjects(config('app.pagination_limit')), 200);
        } catch (\Throwable  $e) {
            return response()->json(['error' => $e], 404);
        }
    }


    /**
     * @param StoreProjectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreProjectRequest $request)
    {
        try {
            return response()->json($this->projectService->createProject(collect($request->all())),201);
        } catch (\Throwable  $e) {
            return response()->json(['error' => $e],404);
        }
    }


    public function show(Project $project)
    {
        try {
            return response()->json($project->load('skill', 'user', 'type'), 200);
        } catch (\Throwable  $e) {
            return response()->json(['error' => $e], 404);
        }
    }

    /**
     * @param StoreProjectRequest $request
     * @param Project $project
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(StoreProjectRequest $request, Project $project)
    {
        try {
            return response()->json($this->projectService->updateProject(collect($request->all()), $project), 200);
        } catch (\Throwable  $e) {
            return response()->json(['error' => $e], 404);
        }
    }


    /**
     * @param Project $project
     * @return mixed
     */
    public function destroy(Project $project)
    {
        try {
            $this->projectService->delete($project);

            response()->json('success deleted', 200);
        } catch (\Throwable  $e) {
            return response()->json(['error' => $e], 404);
        }
    }
}
