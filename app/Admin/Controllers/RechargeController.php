<?php

namespace App\Admin\Controllers;

use App\Models\Recharge;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class RechargeController extends Controller
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

            $content->header('充值中心');
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

            $content->header('充值中心');
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

            $content->header('充值中心');
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
        return Admin::grid(Recharge::class, function (Grid $grid) {

            $grid->id('ID')->sortable();
            $grid->column('money', '充值额度');
            $states = [
                'on'  => ['value' => 1, 'text' => '显示', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '隐藏', 'color' => 'danger'],
            ];
            $grid->status('状态')->switch($states);
            // $grid->column('status', '状态');
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
        return Admin::form(Recharge::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->number('money', '充值额度');
            $states = [
                'on'  => ['value' => 1, 'text' => '显示', 'color' => 'success'],
                'off' => ['value' => 0, 'text' => '隐藏', 'color' => 'danger'],
            ];

            $form->switch('status', '状态')->states($states)->default(1);
            $form->display('created_at', '创建时间');
            // $form->display('updated_at', 'Updated At');
        });
    }
}
