<?php


namespace App\Admin\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Customer;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class CustomersController extends Controller
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
            ->header('Customers')
            ->description(' ')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('Customers')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed   $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('Customers')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     *
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('Customers')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Customer());

        $grid->disableExport();
        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->filter(function ($filter) {
            // Remove the default id filter
            $filter->disableIdFilter();

            $filter->where(function ($query) {

                $query->where('first_name', 'like', "%{$this->input}%");

                $query->where('last_name', 'like', "%{$this->input}%");

                $query->orWhere('phone_number', 'like', "{$this->input}");

                $query->orWhere('email', 'like', "%{$this->input}%");

            }, 'Search');

        });

        $grid->id('Id');


        $grid->column('First name')->display(function () {
            return "<a href='/admin/customers/{$this->id}/edit'>{$this->first_name}</a>";
        });

        $grid->last_name('Last name');

        $grid->phone_number('Phone number');

        $grid->email('Email');

        $grid->created_at('Created at');

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     *
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(Customer::query()->findOrFail($id));

        $show->id('Id');
        $show->first_name('First name');
        $show->last_name('Last name');
        $show->phone_number('Phone number');
        $show->email('Email');
        $show->created_at('Created at');
        $show->updated_at('Updated at');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Customer());

        $form->text('first_name', 'First name');

        $form->text('last_name', 'Last name');

        $form->divider();

        $form->text('phone_number', 'Phone number');

        $form->divider();

        $form->email('email', 'Email');

        $form->divider();

        return $form;
    }
}
