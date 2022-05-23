<?php

namespace App\Orchid\Layouts\Project;

use App\Orchid\Filters\Project\ProjectListFilter;
use App\Orchid\Filters\Project\ProjectSoftSelectFilter;
use App\Orchid\Filters\Project\ProjectStatusSelectFilter;
use Orchid\Filters\Filter;
use Orchid\Screen\Layouts\Selection;

class ProjectSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            ProjectSoftSelectFilter::class,
            ProjectListFilter::class,
        ];
    }
}
