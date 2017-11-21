<?php
namespace App\Admin\Extensions;

use Encore\Admin\Admin;

class CheckRow
{
    protected $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    protected function script()
    {
        return <<<SCRIPT

$('.grid-check-row').on('click', function () {

    // Your code.
    console.log($(this).data('id'));
    var id = $(this).data('id');
    $.ajax({
        method: 'post',
        url: 'bank/checkrow',
        data: {
            _token:LA.token,
            id: id
        },
        success: function () {
            $.pjax.reload('#pjax-container');
            toastr.success('操作成功');
        },
        fail: function () {
            $.pjax.reload('#pjax-container');
            toastr.danger('操作失败');
        }
    });
});

SCRIPT;
    }

    protected function render()
    {
        Admin::script($this->script());

        return "<a class='btn btn-xs btn-success fa grid-check-row' data-id='{$this->id}'>审核</a>";
    }

    public function __toString()
    {
        return $this->render();
    }
}
?>
