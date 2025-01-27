@extends('layouts.base')

@section('title', 'To do List Panel')

@section('css', asset('css/dashboard.css'))

@section('content')
<meta id="csrf_token" value="{{csrf_token()}}">
<nav class="navbar navbar-expand-lg bg-body-tertiary" id="nav">
    <div class="container-fluid">
        <a id="brand" class="navbar-brand" href="#">To do List</a>
        <form action="{{ route('logout') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-dark">Logout</button>
        </form>
    </div>
</nav>
<div class="list-manager-area">
    <h1>Task List</h1>
    @if (isset($list) && count($list) > 0)
    <table class="table">
        <thead class="table-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Status</th>
                <th scope="col">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $task)
            <tr>
                <td>{{ $i }}</td>
                <td>{{ $task->title }}</td>
                <td>{{ $task->getLimitedDescription(15) }}</td>
                <td class="status-column">
                    <img class="status-icon" src="{{ $task->getIcon() }}" alt="status">
                </td>
                <td class="action-column">
                    <button class="btn btn-success" data-bs-toggle="modal" modal-replacers="title:{{ $task->title }}" data-bs-target="#check-modal" taskid="{{ $task->id }}" @if (!$task->canBeEdited()) disabled @endif >
                        <i class="bi bi-check dashboard-button-icon"></i>
                        Check
                    </button>
                    <a href="{{route('task.create', ['id' => $task->id])}}" class="btn btn-primary edit-button" @if (!$task->canBeEdited()) disabled @endif >
                        <i class="bi bi-pencil-square dashboard-button-icon"></i>
                        Edit
                    </a>
                    <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#delete-modal" modal-replacers="title:{{ $task->title }}" taskid="{{ $task->id }}">
                        <i class="bi bi-trash dashboard-button-icon"></i>
                        Delete
                    </button>
                </td>
            </tr>
            @php($i++)
            @endforeach
            <tr>
                <td colspan="5">
                    <div class="table-actions">
                        <button class="btn btn-primary page-button" 
                            @if (is_null($oldPage)) 
                                disabled
                            @endif
                        >
                            <a href=" {{route('dashboard', ['page' => $oldPage])}}">
                                <i class="bi bi-chevron-double-left dashboard-button-icon"></i>
                            </a>
                        </button>
                        
                        <button class="btn btn-primary page-button"
                            @if (is_null($nextPage)) 
                                disabled
                            @endif
                        >
                            <a href="{{route('dashboard', ['page' => $nextPage])}}">
                                <i class="bi bi-chevron-double-right dashboard-button-icon"></i>
                            </a>
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
    @else
    <div class="empty">
        <h1>You do not have any task to do</h1>
        <a href="/create" class="btn btn-primary">Create</a>
    </div>
    @endif
    <div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="delete-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="delete-modal-title" model-text="Delete {title} task? "></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to delete <strong id="delete-modal-text" model-text="{title} Task"></strong> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" confirmation id="delete-confirmation" onclick="deleteTask(this.getAttribute('taskid'), '{{ route('task.delete') }}')">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="check-modal" tabindex="-1" role="dialog" aria-labelledby="check-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="check-modal-title" model-text="Check {title}"></h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure to check <strong id="check-modal-text" model-text="{title} Task"></strong> ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-success" id="check-confirmation" confirmation onclick="checkTask(this.getAttribute('taskid'), '/task/check/')">Check</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src=" {{ asset('js/dashboard.js') }}"></script>

@endsection