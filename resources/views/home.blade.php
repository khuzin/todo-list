@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @auth
        <div class="col-md-12">
            <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button onclick="location.href = '{{ route('home', ['tab' => 1]) }}'" class="nav-link {{ request()->get('tab', 1) == 1 ? 'active' : '' }}" id="all-tasks-tab" data-bs-toggle="tab" data-bs-target="#all-tasks-tab-pane" role="tab" aria-controls="all-tasks-tab-pane" aria-selected="true">Все</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button onclick="location.href = '{{ route('home', ['tab' => 2]) }}'" class="nav-link {{ request()->get('tab') == 2 ? 'active' : '' }}" id="active-tasks-tab" data-bs-toggle="tab" data-bs-target="#active-tasks-tab-pane" role="tab" aria-controls="active-tasks-tab-pane" aria-selected="false">Активные</button>
                </li>

                <li class="nav-item" role="presentation">
                    <button onclick="location.href = '{{ route('home', ['tab' => 3]) }}'" class="nav-link {{ request()->get('tab') == 3 ? 'active' : '' }}" id="close-tasks-tab" data-bs-toggle="tab" data-bs-target="#close-tasks-tab-pane" aria-controls="close-tasks-tab-pane" aria-selected="false">Выполненные</button>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade {{ request()->get('tab', 1) == 1 ? 'show active' : '' }}" id="all-tasks-tab-pane" role="tabpanel" aria-labelledby="all-tasks-tab" tabindex="0">
                    <x-table.table :tasks="$allTasks" />
                </div>

                <div class="tab-pane fade {{ request()->get('tab') == 2 ? 'show active' : '' }}" id="active-tasks-tab-pane" role="tabpanel" aria-labelledby="active-tasks-tab" tabindex="0">
                    <x-table.table :tasks="$activeTasks" />
                </div>

                <div class="tab-pane fade {{ request()->get('tab') == 3 ? 'show active' : '' }}" id="close-tasks-tab-pane" role="tabpanel" aria-labelledby="close-tasks-tab" tabindex="0">
                    <x-table.table :tasks="$closeTasks" />
                </div>
            </div>
        </div>

        @else

        <div class="col-md-12" style="margin-top: 100px">
            <h3 class="text-center">Чтобы пользоваться инструментом, нужно <a href="{{ route('login') }}">авторизироваться</a></h3>
        </div>

        @endauth
    </div>
</div>
@endsection
