<?php

namespace App\Orchid\Layouts\Project;

use App\Enums\Models\TaskStatusEnum;
use App\Models\Task;
use App\Models\User;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Layouts\Rows;

class TasksEditLayout extends Rows
{

    public $statuses;

    public function __construct(
        public int $projectId,
        public Task|null $task = null
    )
    {
        $this->statuses = array_combine(
            collect(TaskStatusEnum::cases())->pluck('value')->toArray(),
            [
                __('в ожидании'),
                __('в разработке'),
                __('на тестировании'),
                __('на проверке'),
                __('выполнено')
            ],
        );
    }

    /**
     * Used to create the title of a group of form elements.
     *
     * @var string|null
     */
    protected $title;

    /**
     * Get the fields elements to be displayed.
     *
     * @return Field[]
     */
    protected function fields(): iterable
    {
        return [
            TextArea::make('task.description')
                ->value($this->task?->description)
                ->required()
                ->title(__('Описание')),

            Select::make('task.status')
                ->options($this->statuses)
                ->value($this->task?->status ?? $this->statuses['waiting'])
                ->required()
                ->title(__('Статус')),

            Select::make('task.user_id')
                ->fromModel(User::class, 'name')
                ->required()
                ->value($this->task?->user_id)
                ->empty(__('Укажите пользователя')),

            Input::make('task.project_id')
                ->type('hidden')
                ->value($this->projectId),

            Input::make('task.id')
                ->type('hidden')
                ->value($this->task?->id)
        ];
    }
}
