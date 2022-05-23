<?php

namespace App\Http\Controllers;

use App\Enums\Models\TaskStatusEnum;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function setCompleted(Task $task)
    {
        if (!$task) {
            return abort(404);
        }

        $task->update(['status' => TaskStatusEnum::completed]);

        return redirect()->back();
    }

    public function setUncompleted(Task $task)
    {
        if (!$task) {
            return abort(404);
        }

        $task->update(['status' => TaskStatusEnum::waiting]);

        return redirect()->back();
    }

    public function delete(Task $task)
    {
        if (!$task) {
            return abort(404);
        }

        $task->delete();

        return redirect()->back();
    }
}
