<?php

namespace App\Orchid\Layouts\Project;

use App\Enums\Models\TaskStatusEnum;
use App\Models\Task;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;
use Orchid\Support\Color;
use Orchid\Support\Facades\Layout;

class ProjectTasksEditLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'tasks';

    /**
     * Table title.
     *
     * The string to be displayed on top of the table.
     *
     * @var string
     */
    protected $title;

    private $statuses;

    public function __construct()
    {
        $this->title = __('Список задач');
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
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('description', __('Краткое описание'))
                ->cantHide()
                ->render(function (Task $task) {
                    return $task->description;
                }),

            TD::make('status', __('Статус'))
                ->cantHide()
                ->render(function (Task $task) {
                    return $this->statuses[$task->status];
                }),

            TD::make(__('Удален'))
                ->cantHide()
                ->render(function (Task $task) {
                    return $task->trashed() ? __('Да') : __('Нет');
                }),

            TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Task $task) {
                    $list = [];

                    if ($task->trashed()) {
                        $list[] = Button::make(__('Восстановить'))
                                    ->icon('reload')
                                    ->method('restoreTask', [
                                        'id' => $task->id,
                                    ]);
                    } else {
                        $list[] = ModalToggle::make(__('Изменить'))
                                    ->type(Color::DEFAULT())
                                    ->icon('pencil')
                                    ->method('saveTask')
                                    ->modal(__('Редактирование задачи #' . $task->id));

                        $list[] = Button::make(__('Удалить'))
                                    ->icon('trash')
                                    ->method('removeTask', [
                                        'id' => $task->id,
                                    ]);
                    }

                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list($list);
                }),
        ];
    }
}
