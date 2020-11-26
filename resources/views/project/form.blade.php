@extends('layouts.app')

@section('content')
    <div class="card">
        <form method="post" id="run_form"
              action="{{isset($project) ? route('projects.update', ["project" => $project->id]) : route('projects.store')}}">
            @csrf
            @if(isset($project))
                @method('put')
            @endif
            <div class="card-header">{{$title . ' Projects'}}</div>
            <div class="card-body">

                <div class="form-row">
                    <div class="form-group col-md-6 {{$errors->has('title') ? ' has-error' : '' }}">
                        <label for="inputEmail4">Title</label>
                        <input type="text" class="form-control" id="inputEmail4" placeholder="Title" name="title"
                               value="{{isset($project) ? $project->title : null}}"
                               required>
                        @if($errors->has('title'))
                            <span class="help-block m-b-none text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">Organization</label>
                        <input type="text" class="form-control" id="inputPassword4" placeholder="Organization"
                               value="{{isset($project) ? $project->organization : null}}"
                               name="organization">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md {{$errors->has('description') ? ' has-error' : '' }}">
                        <label for="inputPassword4">Description</label>
                        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"
                                  placeholder="Description" name="description"
                                  required>{{isset($project) ? $project->description : null}}</textarea>
                        @if($errors->has('description'))
                            <span class="help-block m-b-none text-danger">{{ $errors->first('description') }}</span>
                        @endif
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="inputEmail4">Start</label>
                        <input type="date" class="form-control" id="inputEmail4" placeholder="Start" name="start"
                               value="{{isset($project->start) ? dateFormat($project->start) : null}}">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="inputPassword4">End</label>
                        <input type="date" class="form-control" id="inputPassword4" placeholder="End" name="end"
                               value="{{isset($project->end) ? dateFormat($project->end) : null}}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4 {{$errors->has('type_id') ? ' has-error' : '' }}">
                        <label for="inputEmail4">Type</label>
                        <select name="type_id" id="inputState" class="form-control" required>
                            <option selected>...</option>
                            @foreach($projectTypes as $title => $type)
                                <option value="{{$type}}" {{isset($project->start) ? (($project->type_id==$type) ? 'selected' : '') : ''}}>{{$title}}</option>
                            @endforeach
                        </select>
                        @if($errors->has('type_id'))
                            <span class="help-block m-b-none text-danger">{{ $errors->first('type_id') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4 {{$errors->has('role') ? ' has-error' : '' }}">
                        <label for="inputEmail4">Role</label>
                        <input type="text" class="form-control" id="inputEmail4" placeholder="Role" name="role"
                               value="{{isset($project) ? $project->role : null}}"
                               required>
                        @if($errors->has('role'))
                            <span class="help-block m-b-none text-danger">{{ $errors->first('role') }}</span>
                        @endif
                    </div>
                    <div class="form-group col-md-4">
                        <label for="inputPassword4">Link</label>
                        <input type="text" class="form-control" id="inputPassword4" placeholder="Link" name="link"
                               value="{{isset($project) ? $project->link : null}}">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md {{$errors->has('skills') ? ' has-error' : '' }}">
                        @php
                            if (isset($project)){$skillToProject = $project->skill->pluck('id')->toArray();}
                        @endphp
                        @foreach($skills as $skill)
                            <label for="inputEmail4" style="text-transform: capitalize; font-weight: 600">{{$skill->title}}</label>
                            <input type="checkbox" name="skills[{{!isset($i) ? $i=0 : ++$i}}]" value="{{$skill->id}}" {{isset($project) ? ((in_array($skill->id, $skillToProject) ? 'checked' : '')) : ''}}><br>
                        @endforeach
                    </div>
                </div>

                <a href="{{redirect()->back()}}" class="btn btn-outline-danger">Cancel</a>
                <a onclick="document.getElementById('run_form').submit()" class="btn btn-outline-success">Save</a>
            </div>
        </form>
    </div>
@endsection

@section('script')

    {{--<!-- JQuery -->--}}
    {{--<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>--}}


    {{--<!--Select2-->--}}
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />--}}
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>--}}

    {{--<script>--}}
    {{--$(document).ready(function() {--}}
    {{--$('.js-example-basic-multiple').select2();--}}
    {{--});--}}
    {{--</script>--}}

@endsection
