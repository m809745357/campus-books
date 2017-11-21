<?php

namespace App\Admin\Controllers;

use App\Models\Withdraw;
use App\User;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;
use App\Admin\Extensions\CheckRow;
use App\Admin\Extensions\Tools\BankGender;

class WithdrawController extends Controller
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

            $content->header('提现管理');
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

            $content->header('提现管理');
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

            $content->header('提现管理');
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
        return Admin::grid(Withdraw::class, function (Grid $grid) {

            if (in_array(request()->get('gender'), ['1', '2'])) {
                $grid->model()->where('status', request()->get('gender'))->orderBy('id', 'desc');
            } else {
                $grid->model()->orderBy('id', 'desc');
            }
            $grid->id('ID')->sortable();
            $grid->column('onwer.name', '用户名');
            $grid->money('提现金额');
            $grid->column('status', '审核状态')->display(function ($status) {
                return $status == 1 ? '<a class="btn btn-xs btn-danger fa " data-id="14">待审核</a>' : '审核成功';
            });
            $grid->created_at('提交时间');
            $grid->updated_at('审核时间');
            $grid->disableCreation();
            $grid->disableExport();
            $grid->disableRowSelector();
            $grid->tools(function ($tools) {
                // $tools->batch(function ($batch) {
                //     $batch->disableDelete();
                // });
                $tools->append(new BankGender());
            });
            $grid->actions(function ($actions) {
                $actions->disableDelete();
                $actions->disableEdit();
                if ($actions->row->status == 1) {
                    $actions->append(new CheckRow($actions->getKey()));
                }
            });
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->where(function ($query) {
                    $query->whereHas('onwer', function ($query) {
                        $query->where('name', 'like', "%{$this->input}%");
                    });
                }, '用户名');
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
        // dd(request()->all());
        return Admin::form(Withdraw::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('onwer.name', '用户名');
            $form->display('money', '提现金额');
            $states = [
                'on'  => ['value' => 2, 'text' => '审核完成', 'color' => 'success'],
                'off' => ['value' => 1, 'text' => '待审核', 'color' => 'danger'],
            ];
            $form->switch('status', '审核状态')->states($states);
            // $form->display('change_type', '类型')->value('decrement');
            // $form->display('remark', '备注')->value('提现');
            $form->display('created_at', '提交时间');
            $form->display('updated_at', '审核时间');
        });
    }

    public function checkrow()
    {
        $data = Withdraw::find(request()->get('id'));
        $data->status = 2;
        $data->save();
    }
}
