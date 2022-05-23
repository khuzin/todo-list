<?php

namespace App\Orchid\Screens\Project;

use App\Models\Project;
use App\Models\Task;
use App\Orchid\Layouts\Project\ProjectEditLayout;
use App\Orchid\Layouts\Project\ProjectTasksEditLayout;
use App\Orchid\Layouts\Project\TasksEditLayout;
use App\Orchid\Layouts\Task\TaskSelection;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Screen;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Toast;

class ProjectEditScreen extends Screen
{

    public $project;
    public $tasks;

    /**
     * Query data.
     *
     * @return array
     */
    public function query(Project $project): iterable
    {
        $project->load(['tasks']);

        return [
            'project' => $project,
            'tasks'   => $project->tasks()->filtersApplySelection(TaskSelection::class)
                            ->defaultSort('id', 'desc')
                            ->paginate()
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->project->exists ? __('Редактирование проекта') : __('Создание проекта');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    public function save(Project $project, Request $request)
    {
        $projectData = $request->get('project');

        if (!$project) {
            $project = new Project;
        }

        foreach ($projectData as $column => $value) {
            $project->$column = $value;
        }

        $project->save();

        Toast::info(__('Проект был сохранен'));

        return redirect()->route('platform.screens.project');
    }

    public function removeTask(Request $request)
    {
        Task::findOrFail($request->get('id'))->delete();

        Toast::info(__('Задача помечана на удаление!'));
    }

    public function restoreTask(Request $request)
    {
        Task::onlyTrashed()->findOrFail($request->get('id'))->restore();

        Toast::info(__('Задача восстановлена!'));
    }

    public function saveTask(Request $request)
    {
        $taskData = $request->get('task');

        if ($taskData['id'] == null) {
            $task = new Task;
        } else {
            $task = Task::find($taskData['id']);

            if (!$task) {
                return abort(404);
            }
        }

        foreach ($taskData as $column => $value) {
            $task->$column = $value;
        }

        $task->save();

        Toast::info(__('Задача сохранена!'));
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        $layouts = [
            Layout::block(ProjectEditLayout::class)
                ->commands(
                    Button::make(__('Сохранить'))
                        ->type(Color::DEFAULT())
                        ->icon('check')
                        ->method('save')),
        ];

        if ($this->project->exists) {
            $layouts[] = Layout::block([TaskSelection::class,ProjectTasksEditLayout::class])
                            ->commands(
                                ModalToggle::make(__('Добавить'))
                                    ->type(Color::DEFAULT())
                                    ->icon('plus')
                                    ->modal(__('Добавление задачи'))
                                    ->method('saveTask')
                                    ->canSee($this->project->exists));

            $layouts[] = Layout::modal(__('Добавление задачи'), new TasksEditLayout($this->project->id));

            foreach ($this->tasks as $task) {
                $layouts[] = Layout::modal(__('Редактирование задачи #' . $task->id), new TasksEditLayout($this->project->id, $task))
                                ->applyButton(__('Сохранить'))
                                ->closeButton('Закрыть');
            }

        }

        return $layouts;
    }
}
