<?php

namespace App\Admin\Controllers;

use App\models\Category;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

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

            $content->header('图书分类');
            $content->description('列表');
            $content->body(Category::tree());
            // $content->body($this->grid());
        });
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

            $content->header('图书分类');
            $content->description('编辑');

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

            $content->header('图书分类');
            $content->description('添加');

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
            //三级目录
            $form->display('id', 'ID');
            $form->select('parent_id')->options(Category::where('parent_id', 0)->pluck('name', 'id'))->default('');
            // $form->display('created_at', 'Created At');
            // $form->display('updated_at', 'Updated At');
        });
    }
}
