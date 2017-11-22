<?php

namespace App\Admin\Controllers;

use App\Models\Carousel;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class CarouselController extends Controller
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

            $content->header('轮播图片');
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

            $content->header('轮播图片');
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

            $content->header('轮播图片');
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
        return Admin::grid(Carousel::class, function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();
            $grid->image('图片')->image();
            $select = [
              'home' => '首页',
              'category' => '分类'
            ];
            $grid->type('图片类型')->select($select);
            $grid->target_url('链接')->display(function ($url) {
                return '<a href="'.$url.'" target="_blank">'.$url.'</a>';
            });
            $grid->created_at('添加时间');
            $grid->updated_at('编辑时间');
            $grid->disableExport();
            $grid->filter(function ($filter) {
                $filter->like('target_url', '链接');
                $select = [
                  'home' => '首页',
                  'category' => '分类'
                ];
                $filter->equal('type', '图片类型')->select($select);
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
        return Admin::form(Carousel::class, function (Form $form) {

            $form->display('id', 'ID');
            $select = [
              'home' => '首页',
              'category' => '分类'
            ];
            $form->select('type', '类型')->options($select);
            $form->image('image', '图片')->rules('required');
            $form->url('target_url', '链接')->help('请添加http://或https://');
            $form->display('created_at', '添加时间');
            // $form->display('updated_at', 'Updated At');
        });
    }
}
