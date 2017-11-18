<?php

namespace App\Admin\Controllers;

use App\Models\Thread;
use App\User;
use App\Models\Channel;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ThreadController extends Controller
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

            $content->header('提问管理');
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

            $content->header('提问管理');
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

            $content->header('提问管理');
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
        return Admin::grid(Thread::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('channel.name', '问答分类');
            $grid->column('onwer.name', '提问者');
            $grid->column('title', '标题');
            $grid->column('body', '内容');
            $grid->column('money', '悬赏');
            $grid->column('favorites_count', '其他信息')->display(function ($count) {
                return '<i class="fa fa-heart" aria-hidden="true" title="喜欢"></i> <span class="sr-only">'. $count .'</span><br/>'
                .'<i class="fa fa-eye" aria-hidden="true" title="看过"></i> <span class="sr-only">'. $this->views_count .'</span><br/>'
                .'<i class="fa fa-eye" aria-hidden="true" title="回复"></i> <span class="sr-only">'. $this->replies_count .'</span><br/>';
            });
            $grid->created_at('创建时间');
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
        return Admin::form(Thread::class, function (Form $form) {

            $form->display('id', 'ID');
            $from->select('user_id')->options(User::all()->pluck('name', 'id'));
            $from->select('channel_id')->options(Channel::all()->pluck('name', 'id'));
            $form->text('title', '标题');
            $form->textarea('body', '内容');
            $form->number('money', '悬赏');
            $form->number('favorites_count', '喜欢');
            $form->number('views_count', '浏览');
            $form->number('replies_count', '回复');
            // $form->display('created_at', 'Created At');
            // $form->display('updated_at', 'Updated At');
        });
    }
}
