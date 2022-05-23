<?php

namespace App\Orchid\Filters\Task;

use App\Enums\Models\TaskStatusEnum;
use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class TaskStatusSelectFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return __('Отобрать по статусам');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['status'];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        if (($status = request()->get('status', [])) != []) {
            return $builder->whereIn('status', $status);
        }

        return $builder;
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): iterable
    {
        return [
            Select::make('status')
                ->options(
                    array_combine(
                        collect(TaskStatusEnum::cases())->pluck('value')->toArray(),
                        [
                            __('в ожидании'),
                            __('в разработке'),
                            __('на тестировании'),
                            __('на проверке'),
                            __('выполнено')
                        ],
                    )
                )
                ->multiple()
                ->title(__('Отбирать по статусам'))
        ];
    }
}
