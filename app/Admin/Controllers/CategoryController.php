<?php

namespace App\Admin\Controllers;

use App\Models\Category;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use Encore\Admin\Layout\Column;
use Encore\Admin\Layout\Row;
use Encore\Admin\Tree;
use Encore\Admin\Widgets\Box;

class CategoryController extends Controller
{
    use ModelForm;

    /**
     * Index interface.
     *
     * @return Content
     */
    public function index()
    {
        return Admin::content(function (Content $content) {

            $content->header('图书分类列表');
            $content->description('~分类列表只取前三级哦~');
            $content->row(function (Row $row) {
                $row->column(6, $this->treeView()->render());
                $row->column(5, function (Column $column) {
                    $form = new \Encore\Admin\Widgets\Form();
                    $form->action(admin_base_path('bookmark/categories'));
                    $form->select('parent_id', trans('admin.parent_id'))->options(Category::selectOptions());
                    $form->text('name', trans('admin.title'))->rules('required');
                    $form->text('slug', '英文标识')->rules('required|regex:/^[a-z]+$/|min:4')->help('标识唯一');
                    $column->append((new Box(trans('admin.new'), $form))->style('success'));
                });
            });
            // $content->body($this->grid());
        });
    }

    /**
     * @return \Encore\Admin\Tree
     */
    protected function treeView()
    {
        return Category::tree(function (Tree $tree) {
            $tree->disableCreate();

            $tree->branch(function ($branch) {
                $payload = "<strong>{$branch['name']}</strong>";

                if (!isset($branch['children'])) {
                    // if (url()->isValidUrl($branch['slug'])) {
                    //     $uri = $branch['slug'];
                    // } else {
                    //     $uri = admin_base_path($branch['slug']);
                    // }
                    $uri = '/categories/'. $branch['slug'];
                    $payload .= "&nbsp;&nbsp;&nbsp;<a href=\"$uri\" class=\"dd-nodrag\">$uri</a>";
                }

                return $payload;
            });
        });
    }

    /**
     * Help message for icon field.
     *
     * @return string
     */
    protected function iconHelp()
    {
        return 'For more icons please see <a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a>';
    }
    /**
     * Edit interface.
     *
     * @param $id
     * @return Content
     */
    public function edit($id)
    {
        return Admin::content(function (Content $content) use ($id) {

            $content->header('图书分类编辑');
            $content->description('~分类列表只取前三级哦~');

            $content->body($this->form()->edit($id));
        });
    }

    /**
     * Create interface.
     *
     * @return Content
     */
    public function create()
    {
        return Admin::content(function (Content $content) {

            $content->header('图书分类添加');
            $content->description('~分类列表只取前三级哦~');

            $content->body($this->form());
        });
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return Admin::grid(Category::class, function (Grid $grid) {
            $grid->model()->orderBy('parent_id asc, id asc');
            $grid->id('ID')->sortable();
            $grid->parent_id('父ID');
            $grid->name('分类名');
            $grid->slug('标识');
            $grid->created_at('添加时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Category::class, function (Form $form) {
            // dd(Category::where('parent_id', 0)->childCategories());
            //三级目录
            $form->display('id', 'ID');
            $form->select('parent_id', '父级ID')->options(Category::where('parent_id', 0)->pluck('name', 'id'));
            $form->text('name', '分类名称');
            $form->text('slug', '分类标识');
        });
    }
}
