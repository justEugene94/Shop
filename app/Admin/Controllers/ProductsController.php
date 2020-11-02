<?php


namespace App\Admin\Controllers;


use App\Http\Controllers\Controller;
use App\Models\Product;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;

class ProductsController extends Controller
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
            ->header('Products')
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
            ->description('Products')
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
            ->description('Products')
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
            ->description('Products')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new Product());

        $grid->disableExport();

        $grid->actions(function ($actions) {
            $actions->disableView();
        });

        $grid->filter(function ($filter) {
            // Remove the default id filter
            $filter->disableIdFilter();

            $filter->where(function ($query) {

                $query->where('title', 'like', "%{$this->input}%");

                $query->orWhere('price', 'like', "{$this->input}");

                $query->orWhere('quantity', 'like', "{$this->input}");

            }, 'Search');

        });

        $grid->id('Id');


        $grid->column('Title')->display(function () {
            return "<a href='/admin/products/{$this->id}/edit'>{$this->title}</a>";
        });

        $grid->price('Price');

        $grid->quantity('Quantity');

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
        $show = new Show(Product::query()->findOrFail($id));

        $show->id('Id');
        $show->title('Title');
        $show->description('Description');
        $show->price('Price');
        $show->quantity('Quantity');
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
        $form = new Form(new Product());

        $form->text('title', 'Title');

        $form->divider();

        $form->number('price', 'Price');
        $form->number('quantity', 'Quantity');

        $form->divider();

        $form->textarea('description', 'Description');

        $form->divider();

        return $form;
    }
}
