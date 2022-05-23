<?php

namespace App\Orchid\Filters\Project;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Select;

class ProjectSoftSelectFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return __('Отобрать удаленные или активные');
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['action'];
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
        if (in_array('softDel', request()->get('action')) && in_array('normal', request()->get('action'))) {
            return $builder->withTrashed();
        }

        if (in_array('softDel', request()->get('action'))) {
            return $builder->onlyTrashed();
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
            Select::make('action')
                ->options([
                    'softDel' => 'удаленные',
                    'normal'  => 'активные'
                ])
                ->multiple()
                ->title(__('Отображать только'))
        ];
    }
}
