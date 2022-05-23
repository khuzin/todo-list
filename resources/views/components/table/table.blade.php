@props(['tasks' => ''])

<table class="table table-bordered">
    <tbody>
        @forelse ($tasks as $task)

        <x-table.row :task="$task" />

        @empty

        <x-table.row-not-found />

        @endforelse
    </tbody>
</table>
