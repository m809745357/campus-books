<?php

namespace App\Admin\Controllers;

use App\Models\Demand;
use App\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class DemandController extends Controller
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

            $content->header('求购信息');
            $content->description('列表');

            $content->body($this->grid());
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

            $content->header('求购信息');
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

            $content->header('求购信息');
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
        return Admin::grid(Demand::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('onwer.name', '求购者');
            $grid->title('标题');
            $grid->image('图片')->image();
            $grid->body('内容');
            $grid->money('价格');
            $grid->views_count('浏览');
            $grid->created_at('求购时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Demand::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('user_id', '求购者')->options(User::all()->pluck('name', 'id'));
            $form->text('title', '标题');
            $form->number('money', '价格');
            $form->image('image', '图片');
            $form->textarea('body', '内容');
            $form->display('views_count', '浏览');
            $form->display('created_at', '创建时间');
        });
    }
}
