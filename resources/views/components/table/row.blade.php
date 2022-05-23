<tr>
    <td style="width: 0px;">
        <form action="{{ $task->status == 'completed' ? route('task.uncompleted', $task) : route('task.completed', $task) }}">
            <input type="checkbox" {{ $task->status == 'completed' ? 'checked' : '' }} onchange="this.form.submit()">
        </form>
    </td>
    <td class="text-center">
        @if($task->status != 'completed')

        <span>{{ $task->description }}</span>

        @else

        <strike class="text-success">{{ $task->description }}</strike>

        @endif
    </td>
    <td style="width: 0px">
        <form action="{{ route('task.delete', $task) }}"><button class="btn btn-danger">X</button></form>
    </td>
</tr>
