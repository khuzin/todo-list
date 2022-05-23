<?php

namespace App\Orchid\Layouts\Project;

use App\Enums\Models\TaskStatusEnum;
use App\Models\Project;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Persona;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;

class ProjectListLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'projects';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [

            TD::make('name', __('Наименование'))
                ->cantHide()
                ->render(function (Project $project) {
                    return Link::make($project->name)->route('platform.screens.project.edit', $project);
                }),

            TD::make(__('Кол-во задач'))
                ->cantHide()
                ->render(function (Project $project) {
                    return $project->tasks()->count();
                }),

            TD::make(__('Кол-во выполненных задач'))
                ->cantHide()
                ->render(function (Project $project) {
                    return $project->tasks()->where('status', TaskStatusEnum::completed)->count();
                }),

            TD::make(__('Удален'))
                ->cantHide()
                ->render(function (Project $project) {
                    return $project->trashed() ? __('Да') : __('Нет');
                }),

            TD::make(__('Действия'))
                ->align(TD::ALIGN_CENTER)
                ->width('100px')
                ->render(function (Project $project) {
                    $list = [];

                    if ($project->trashed()) {
                        $list[] = Button::make(__('Восстановить'))
                                    ->icon('reload')
                                    ->method('restore', [
                                        'id' => $project->id,
                                    ]);
                    } else {
                        $list[] = Link::make(__('Изменить'))
                                    ->route('platform.screens.project.edit', $project->id)
                                    ->icon('pencil');

                        $list[] = Button::make(__('Удалить'))
                                    ->icon('trash')
                                    ->method('remove', [
                                        'id' => $project->id,
                                    ]);
                    }

                    return DropDown::make()
                        ->icon('options-vertical')
                        ->list($list);
                }),

        ];
    }
}
