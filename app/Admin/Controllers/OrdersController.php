<?php


namespace App\Admin\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Status;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
use Encore\Admin\Widgets\Box;
use Illuminate\Database\Query\Builder;


class OrdersController extends Controller
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
            ->header('Orders')
            ->description(' ')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     *
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('Orders')
            ->body($this->detail($id, $content));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     *
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('Orders')
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
            ->description('Orders')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Order());

        $grid->disableCreateButton();

        $grid->actions(function ($actions) {
            $actions->disableDelete();
            $actions->disableEdit();
        });

        $grid->filter(function ($filter) {
            // Remove the default id filter
            $filter->disableIdFilter();

            $filter->where(function ($query) {

                $query->where('amount', 'like', "{$this->input}");

                $query->orWhereHas('products', function (Builder $builder) {
                    $builder->where('title', 'like', "%{$this->input}%");
                });

                $query->orWhereHas('customer', function (Builder $builder) {
                    $builder->where('first_name', 'like', "%{$this->input}%");
                    $builder->orWhere('last_name', 'like', "%{$this->input}%");
                });

            }, 'Search');

        });

        $grid->id('Id');

        $grid->column('Customer')->display(function () {
            return "<a href='/admin/customers/{$this->customer->id}/'>{$this->customer->first_name} {$this->customer->last_name}</a>";
        });

        $grid->column('City')->display(function () {
            return "<a href='/admin/cities/{$this->npDepartment->city->id}/edit'>{$this->npDepartment->city->name}</a>";
        })->sortable();

        $grid->column('Department')->display(function () {
            return "<a href='/admin/departments/{$this->npDepartment->id}/edit'>{$this->npDepartment->department}</a>";
        });

        $grid->column('status_id', 'Status')->display(function () {
            return (new Status)->find($this->status_id)->name;
        })->filter([
            1 => 'created',
            2 => 'paid',
            3 => 'fulfilled',
            4 => 'error',
        ]);

        $grid->amount('Amount')->sortable();

        $grid->column('products', 'Products count')->display(function ($products) {
            $count = count($products);
            return "<span class='label label-warning'>{$count}</span>";
        });

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
    protected function detail($id, Content $content)
    {
        $order = Order::query()->with(['products'])->findOrFail($id);

        $show = new Show($order);

        $show->amount('Total');

        $show->divider();

        $show->status_id('Status')->as(function ($statusId) {
            return (new Status)->find($statusId)->name;
        });
        $show->created_at('Created');
        $show->updated_at('Updated');

        $show->customer('Customer', function ($customer) {
            $customer->first_name();
            $customer->last_name();

            $customer->phone_number();
            $customer->email();

            $customer->panel()->tools(function (Show\Tools $tools) {
                $tools->disableEdit();
                $tools->disableList();
                $tools->disableDelete();
            });
        });

        $content->row((new Box('Products', view('admin.order.products', ['order' => $order])))->style('info'));

        $show->panel()->tools(function (Show\Tools $tools) {
            $tools->disableEdit();
            $tools->disableList();
            $tools->disableDelete();
        });

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new Order);

        $form->display('customer.first_name', 'Customer name');

        $form->display('customer.last_name', 'Customer last name');

        $form->divider();

        $form->display('npDepartment.department', 'Department');

        $form->display('npDepartment.city.name', 'City');

        $form->divider();

        $form->multipleSelect('products', 'Products')->options(function () {
            return Product::all()->pluck('title', 'id');
        });

        $form->divider();

        $form->select('status_id', 'Status')->options((new Status)->getCollection()->pluck('name', 'id'));

        $form->divider();

        $form->number('amount', 'Amount');

        $form->divider();


        return $form;
    }
}
