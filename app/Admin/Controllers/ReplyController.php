<?php

namespace App\Admin\Controllers;

use App\Models\Reply;
use App\User;
use App\Models\Thread;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ReplyController extends Controller
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

            $content->header('回复管理');
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

            $content->header('回复管理');
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

            $content->header('回复管理');
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
        return Admin::grid(Reply::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('thread.title', '问题');
            $grid->column('onwer.name', '回复者');
            $grid->column('body', '回复内容');
            $grid->favorites_count('点赞');
            $grid->created_at('回复时间');
            // $grid->updated_at();
        });
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        return Admin::form(Reply::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->select('thread_id', '问题')->options(Thread::all()->pluck('title', 'id'));
            $form->select('user_id', '回复者')->options(User::all()->pluck('name', 'id'));
            $form->textarea('body', '回复内容');
            $form->number('favorites_count', '点赞');
            $form->display('created_at', '回复时间');
            // $form->display('updated_at', 'Updated At');
        });
    }
}
