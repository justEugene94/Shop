<?php


namespace App\Admin\Controllers;


use App\Models\City;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;

class CitiesController
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
            ->header('Cities')
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
        $grid = new Grid(new City());

        $grid->disableExport();
        $grid->disableActions();
        $grid->disableCreateButton();

        $grid->filter(function ($filter) {
            // Remove the default id filter
            $filter->disableIdFilter();

            $filter->where(function ($query) {

                $query->where('name', 'like', "%{$this->input}%");

            }, 'Search');

        });

        $grid->id('Id');

        $grid->np_id('Nova Poshta Id');

        $grid->name('Name')->sortable();

        return $grid;
    }
}
