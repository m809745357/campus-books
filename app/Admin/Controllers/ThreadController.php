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
            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();
            $grid->column('channel.name', '问答分类')->badge('red');
            $grid->column('onwer.name', '提问者')->badge('green');
            $grid->column('title', '问题')->badge('blue');
            $grid->column('body', '内容')->display(function ($str) {
                return '<div style="width:350px;height:80px;">'.mb_substr($str, 0, 150).'</div>';
            });
            $grid->column('money', '悬赏')->color('red');
            $grid->column('favorites_count', '其他信息')->display(function ($count) {
                return '<i class="fa fa-heart" aria-hidden="true" title="喜欢"></i> <span class="sr-only">'. $count .'</span><br/>'
                .'<i class="fa fa-eye" aria-hidden="true" title="看过"></i> <span class="sr-only">'. $this->views_count .'</span><br/>'
                .'<a href="/admin/club/reply?thread_id='.$this->id.'"><i class="fa fa-bars" aria-hidden="true" title="回复 点击查看"></i> <span class="sr-only">'. $this->replies_count . '</span></a>';
            });
            $grid->created_at('创建时间');
            $grid->disableCreation();
            $grid->disableExport();
            $grid->filter(function ($filter) {
                $filter->like('title', '问题');
                $filter->where(function ($query) {
                    $query->whereHas('onwer', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%");
                    });
                }, '提问者');
                $filter->where(function ($query) {
                    $query->whereHas('channel', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%");
                    });
                }, '问答分类');
            });
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
            $form->display('onwer.name', '提问者');
            $form->display('channel.name', '问答分类');
            $form->display('title', '问题');
            $form->textarea('body', '内容');
            $form->display('money', '悬赏');
            $form->display('favorites_count', '喜欢');
            $form->display('views_count', '浏览');
            $form->display('replies_count', '回复');
            $form->display('created_at', '提问时间');
            // $form->display('updated_at', 'Updated At');
        });
    }
}
