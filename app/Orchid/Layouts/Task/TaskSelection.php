<?php

namespace App\Orchid\Layouts\Task;

use App\Orchid\Filters\Task\TaskListFilter;
use App\Orchid\Filters\Task\TaskSoftSelectFilter;
use App\Orchid\Filters\Task\TaskStatusSelectFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class TaskSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            TaskListFilter::class,
            TaskSoftSelectFilter::class,
            TaskStatusSelectFilter::class
        ];
    }
}
