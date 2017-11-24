<?php

namespace App\Admin\Controllers;

use App\Models\Channel;

use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Facades\Admin;
use Encore\Admin\Layout\Content;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\ModelForm;

class ChannelController extends Controller
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

            $content->header('问答分类');
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

            $content->header('问答分类');
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

            $content->header('问答分类');
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
        return Admin::grid(Channel::class, function (Grid $grid) {
            $grid->model()->orderBy('id', 'desc');
            $grid->id('ID')->sortable();
            $grid->name('标题')->badge('green');
            $grid->slug('英文标识')->badge('blue');
            $grid->icon('图标')->display( function ($icon) {
                return "<i class='fa {$icon}'></i>";
            });
            $grid->column('desc', '简述');
            $grid->created_at('创建时间');
            // $grid->updated_at();
            // $grid->disableCreation();
            // $grid->disableRowSelector();
            $grid->disableExport();
            $grid->filter(function ($filter) {
                $filter->disableIdFilter();
                $filter->where( function ($query) {
                    $query->where('name', 'like', "%{$this->input}%")
                    ->orWhere('slug', 'like', "%{$this->input}%")
                    ->orWhere('desc', 'like', "%{$this->input}%");
                }, '标题或英文标识或简述');
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
        return Admin::form(Channel::class, function (Form $form) {

            $form->display('id', 'ID');
            $form->text('name', '标题');
            $form->text('slug', '英文标识')->rules('required|regex:/^[a-z]+$/|min:4')->help('至少为4个字母');
            $form->icon('icon', trans('admin.icon'))->default('fa-bars')->rules('required')->help($this->iconHelp());
            $form->textarea('desc', '简述');
            // $form->display('created_at', 'Created At');
            // $form->display('updated_at', 'Updated At');
        });
    }

    /**
     * Help message for icon field.
     *
     * @return string
     */
    protected function iconHelp()
    {
        return 'For more icons please see <a href="http://fontawesome.io/icons/" target="_blank">http://fontawesome.io/icons/</a>';
    }
}
