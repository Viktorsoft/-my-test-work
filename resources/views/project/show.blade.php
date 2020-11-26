@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3>Project: <strong>{{$project->title}}</strong><br></h3>

        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                <tr>
                    <th scope="col">#Id</th>
                    <th scope="col">Author</th>
                    <th scope="col">Organization</th>
                    <th scope="col">Type</th>
                    <th scope="col">Role</th>
                    <th scope="col">Start</th>
                    <th scope="col">End</th>
                    <th scope="col" colspan="2">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{$project->id}}</td>
                    <td><a class="btn btn-light" href="#">{{$project->user->name}}</a></td>
                    <td>{{$project->organization}}</td>
                    <td>{{$project->type->title}}</td>
                    <td>{{$project->role}}</td>
                    <td>{{$project->start}}</td>
                    <td>{{$project->end}}</td>
                    @if (auth()->user()->isAdmin() || auth()->user()->id == $project->user_id)
                        <td>
                            <a class="btn btn-info"
                               href="{{route('projects.edit', ['project' => $project->id])}}">Edit</a>
                        </td>
                        <td>
                            <form id="delete_form_project{{$project->id}}" method="post"
                                  action="{{route('projects.destroy', ['project' => $project->id])}}">
                                @method('DELETE')
                                @csrf
                                <a class="btn btn-danger"
                                   onclick="document.getElementById('delete_form_project{{$project->id}}').submit()">Delete</a>
                            </form>
                        </td>
                    @else
                        <td></td>
                        <td></td>
                    @endif
                </tr>
                </tbody>
            </table>
        </div>
        <div class="card-header">
            <h3>Description: </h3>
        </div>
        <div class="card-body">
            <p>{{$project->description}}</p>
        </div>
        <div class="card-header">
            <h3>Skills: </h3>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($project->skill as $skill)
                    <li class="list-group-item"><strong>{{$skill->title}}</strong></li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
