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
            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();
            $grid->column('onwer.name', '求购者')->badge('blue');
            $grid->title('标题')->badge('green');
            $grid->images('图片')->image('80', '80');
            $grid->body('内容')->display(function ($body) {
                return '<div style="width:350px;height:80px;">'. mb_substr($body, 0, 150) .'</div>';
            });
            $grid->money('价格')->color('red');
            $grid->views_count('浏览')->color('green');
            $grid->created_at('求购时间');

            $grid->disableCreation();
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
            $grid->disableRowSelector();
            $grid->disableExport();
            $grid->filter(function ($filter) {
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                $filter->like('title', '书名');
                $filter->where(function ($query) {
                    $query->whereHas('onwer', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%");
                    });
                }, '求购者');
                $filter->between('created_at', '求购时间')->datetime();
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
        return Admin::form(Demand::class, function (Form $form) {
            $form->display('id', 'ID');
            $form->display('onwer.name', '求购者');
            $form->display('title', '标题');
            $form->multipleImage('images', '图片')->uniqueName();
            $form->display('money', '价格');
            $form->textarea('body', '内容');
            $form->display('views_count', '浏览');
            $form->display('created_at', '创建时间');
        });
    }
}
