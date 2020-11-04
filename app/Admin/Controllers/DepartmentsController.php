<?php


namespace App\Admin\Controllers;


use App\Models\NPDepartment;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Illuminate\Database\Eloquent\Builder;

class DepartmentsController
{
    use HasResourceActions;


    /**
     * Index interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Departments')
            ->description(' ')
            ->body($this->grid());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new NPDepartment());

        $grid->disableExport();
        $grid->disableActions();
        $grid->disableCreateButton();

        $grid->filter(function ($filter) {
            // Remove the default id filter
            $filter->disableIdFilter();

            $filter->where(function ($query) {

                $query->where('department', 'like', "%{$this->input}%");

                $query->orWhereHas('city', function (Builder $builder) {
                    $builder->where('name', 'like', "%{$this->input}%");
                });

            }, 'Search');

        });

        $grid->id('Id');

        $grid->np_id('Nova Poshta Id');

        $grid->column('city.name', 'City')->sortable();

        $grid->department('Department')->sortable();

        return $grid;
    }
}
