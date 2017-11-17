<?php

namespace App\Admin\Controllers;

use App\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class MemberController extends Controller
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

            $content->header('用户管理');
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

            $content->header('用户管理');
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

            $content->header('用户管理');
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
        return Admin::grid(User::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->name('用户名');
            $grid->avatar('头像')->image();
            $grid->balances('余额');
            $grid->column('sex', '性别')->display(function ($sex) {
                return $sex == 1 ? 'boy':'girl';
            });
            $grid->column('school', '学校/专业')->display(function () {
                return $this->school . '/' . $this->specialty;
            });
            $grid->mobile('手机');
            $grid->created_at('注册时间');
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(User::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->display('name', '用户名');
            $form->display('nickname', '昵称');
            $form->image('avatar', '头像')->uniqueName();
            $form->text('balances', '余额');
            $form->select('sex', '性别')->options(['1' => 'boy', '2' => 'girl']);
            $form->text('school', '学校');
            $form->text('specialty', '专业');
            $form->display('created_at', '注册时间');
            // $form->display('updated_at', 'Updated At');
        });
    }
}
