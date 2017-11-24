<?php

namespace App\Admin\Controllers;

use App\Models\Order;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\BookDetail;

class OrderController extends Controller
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

            $content->header('订单管理');
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

            $content->header('订单管理');
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

            $content->header('订单管理');
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
        return Admin::grid(Order::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->order_number('订单编号');
            $grid->column('book.title', '图书')->badge('green');
            $grid->column('onwer.name', '买家')->badge('blue');
            $grid->column('book_detail', '价格')->display(function ($book) {
                return $book['money'];
            })->color('red');
            $grid->address('收件信息')->display(function ($addr) {
                return  '<div style="width:350px;height:90px;">'
                        .'<span>收件人：'.$addr['user_name'].'</span></br>'
                        .'<span>电话：'.$addr['tel_number'].'</span></br>'
                        .'<span>地址：'.$addr['province_name'].$addr['city_name'].$addr['country_name'].$addr['detail_info'].'</span></br>'
                        .'<span>备注：'.$this->remark.'</span></div>';
            });

            $grid->pay('支付方式')->display(function ($pay) {
                $datas = [
                    'wechatpay' => '微信支付',
                    'balances' => '余额支付'
                ];
                return $pay ? $datas[$pay] : '';
            });
            $grid->status('订单状态')->display(function ($status) {
                $datas = [
                    '-1' => '订单取消',
                    '-2' => '交易关闭',
                    '0000' => '待支付',
                    '0100' => '已支付',
                    '0110' => '已发货',
                    '0111' => '买家确认',
                    '1110' => '卖家确认',
                    '1111' => '双方确认'
                ];
                return $datas[$status];
            })->badge('danger');
            $grid->created_at('创建时间');

            $grid->disableExport();
            $grid->disableCreation();
            $grid->disableRowSelector();
            $grid->disableActions();
            // $grid->actions(function ($actions) {
            //     $actions->disableEdit();
            //     $actions->disableDelete();
            // });
            $grid->filter(function ($filter) {
                $filter->equal('order_number', '订单编号');
                $filter->where(function ($query) {
                    $query->whereHas('onwer', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%");
                    });
                }, '买家');
                $filter->where(function ($query) {
                    $query->whereHas('book', function ($query) {
                        $query->where('title', 'like', "%{$this->input}%");
                    });
                }, '图书');
                $filter->select('pay', '支付方式')->options([]);
                $filter->select('status', '订单状态')->options([]);
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
        return Admin::form(Order::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->display('order_number', '订单编号');
            $form->display('book.title', '图书');
            $form->display('onwer.name', '买家');
            $form->display('book_detail', '图书信息');
            $form->display('address', '收货地址');
            $form->display('remark', '备注');
            $form->display('pay', '支付方式');
            $form->display('status', '订单状态');

            $form->display('created_at', '创建时间');
            $form->display('updated_at', '编辑时间');
        });
    }
}
