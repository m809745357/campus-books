<?php

namespace App\Admin\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\User;

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
            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();
            $grid->column('onwer.name', '发布方')->badge('red');
            $grid->column('category.name', '类目')->badge('danger');
            $grid->column('title', '书名')->badge('green');
            $grid->column('keywords', '关键词')->display(function ($keywords) {
                return implode(', ', $keywords);
            })->badge('blue');
            $grid->cover('封面')->image('80', '80');
            // $grid->images('组图')->image();
            $grid->column('info', '图书详情')->display(function () {
                return '编者：'.$this->author.'<br/>'.
                '出版社：'.$this->press.'<br/>'.
                '出版时间：'.$this->published_at.'<br/>'.
                '附件信息：'.$this->annex.'<br/>'.
                '商品描述：'.'<span width="250px;">'.$this->body.'</span>';
            });
            $grid->column('info', '售卖详情')->display(function () {
                return '编号：'.$this->book_number.'<br/>'.
                '价格：'.$this->money.'<br/>'.
                '物流方式：'.$this->logistics.'<br/>'.
                '运费：'.$this->freight.'<br/>'.
                '状态：'.$this->status.'<br/>'.
                '发布时间：'.$this->created_at;
            });
            $grid->type('图书类型')->display(function ($type) {
                $datas = [
                    'PBook' => '实体书',
                    'EBook' => '电子书'
                ];
                return $type ? $datas[$type] : '';
            });
            $grid->column('favorites_count', '浏览信息')->display( function ($count) {
                return '<i class="fa fa-heart" aria-hidden="true" title="喜欢"></i> <span class="sr-only">'. $count .'</span>'
                .'<br/>'
                .'<i class="fa fa-eye" aria-hidden="true" title="看过"></i> <span class="sr-only">'. $this->views_count .'</span>';
            });

            $grid->disableRowSelector();
            $grid->disableCreation();
            $grid->actions(function ($actions) {
                $actions->disableDelete();
            });
            $grid->disableExport();
            $grid->filter(function ($filter) {
                // 去掉默认的id过滤器
                $filter->disableIdFilter();
                // 在这里添加字段过滤器
                $filter->like('title', '书名');
                $filter->equal('user_id', '发布方')->select(User::all()->pluck('name', 'id'));
                $filter->like('keywords', '关键词');
                $filter->like('author', '编者');
                $filter->like('press', '出版社');
                $filter->between('created_at', '发布时间')->datetime();
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
        return Admin::form(Book::class, function (Form $form) {
            $form->tab('基本信息', function ($form) {
                $form->display('id', 'ID');
                $form->display('book_number', '图书编号');
                $form->display('onwer.name', '发布方');
                $form->display('category.name', '类目');
                $form->display('title', '书名');
                $form->display('keywords', '关键词')->with(function ($keywords) {
                    return $this->getTags($keywords);
                });
                $form->display('money', '价格');
                $form->display('logistics', '物流方式');
                $form->display('freight', '运费');
            })->tab('图书详情', function ($form) {
                $form->display('author', '编者');
                $form->display('press', '出版社');
                $form->display('published_at', '出版时间');
                $form->image('cover', '封面');
                $form->multipleImage('images', '组图')->uniqueName()->removable();
                $form->textarea('body', '商品描述')->rows(10)->help('*可修改');
                $form->display('annex', '附件信息');
            })->tab('其他信息', function ($form) {
                $form->display('views_count', '浏览');
                $form->display('favorites_count', '喜欢');
                $form->display('created_at', '发布时间');
            });
        });
    }
}
