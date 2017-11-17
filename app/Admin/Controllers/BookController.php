<?php

namespace App\Admin\Controllers;

use App\models\Book;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class BookController extends Controller
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

            $content->header('在线售书');
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

            $content->header('在线售书');
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

            $content->header('在线售书');
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
        return Admin::grid(Book::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('onwer.name', '发布方');
            $grid->column('category.name', '类目');
            $grid->column('title', '书名');
            $grid->cover('封面')->image();
            $grid->keywords('关键词')->badge('blue');

            // $grid->images('组图')->image();
            $grid->column('info', '图书详情')->display(function () {
                return '编者：'.$this->author.'<br/>'.
                '出版社：'.$this->press.'<br/>'.
                '出版时间：'.$this->published_at.'<br/>'.
                '附件信息：'.$this->annex.'<br/>'.
                '商品描述：'.'<span width="250px;">'.$this->body.'</span>';
            });
            $grid->column('info', '售卖详情')->display(function () {
                return '价格：'.$this->money.'<br/>'.
                '物流方式：'.$this->logistics.'<br/>'.
                '运费：'.$this->freight;
            });
            $grid->column('favorites_count', '浏览')->display( function ($count) {
                return '<i class="fa fa-heart" aria-hidden="true" title="喜欢"></i> <span class="sr-only">'. $count .'</span>'
                .'<br/>'
                .'<i class="fa fa-eye" aria-hidden="true" title="看过"></i> <span class="sr-only">'. $this->views_count .'</span>';
            });
            $grid->status('状态');

            // $grid->created_at('发布时间');
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
        return Admin::form(Book::class, function (Form $form) {
            $form->tab('基本信息', function ($form) {
                $form->display('id', 'ID');
                $form->select('user_id', '发布方')->options(User::all()->pluck('name', 'id'));
                $form->select('category_id', '类目')->options(Category::all()->pluck('name', 'id'));
                $form->display('title', '书名');
                $form->display('keywords', '关键词');
                $form->display('money', '价格');
                $form->display('logistics', '物流方式');
                $form->display('freight', '运费');
            })->tab('图书详情', function ($form) {
                $form->display('author', '编者');
                $form->display('press', '出版社');
                $form->display('published_at', '出版时间');
                $form->image('cover', '封面');
                $form->multipleImage('images', '组图')->uniqueName()->removable();
                $form->textarea('body', '商品描述')->rows(10);
                $form->display('annex', '附件信息');
            })->tab('其他信息', function ($form) {

                 $form->hasMany('jobs', function () {
                     $form->text('company');
                     $form->date('start_date');
                     $form->display('created_at', '发布时间');
                 });

             });


            $form->display('updated_at', 'Updated At');
        });
    }
}
