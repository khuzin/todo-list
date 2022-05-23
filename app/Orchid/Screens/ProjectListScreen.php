<?php

namespace App\Orchid\Screens;

use App\Models\Project;
use App\Orchid\Filters\Project\ProjectListFilter;
use App\Orchid\Filters\Project\ProjectSoftSelectFilter;
use App\Orchid\Layouts\Project\ProjectListLayout;
use App\Orchid\Layouts\Project\ProjectSelection;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;

class ProjectListScreen extends Screen
{
    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'projects' => Project::filtersApplySelection(ProjectSelection::class)
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
        return __('Список проектов');
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Добавить'))
                ->icon('plus')
                ->route('platform.screens.project.create'),
        ];
    }

        /**
     * @param Request $request
     */
    public function remove(Request $request): void
    {
        Project::findOrFail($request->get('id'))->delete();

        Toast::info(__('Проект помечан на удаление!'));
    }

    /**
     * @param Request $request
     */
    public function restore(Request $request): void
    {
        Project::onlyTrashed()->findOrFail($request->get('id'))->restore();

        Toast::info(__('Проект восстановлен!'));
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ProjectSelection::class,
            ProjectListLayout::class,
        ];
    }
}
