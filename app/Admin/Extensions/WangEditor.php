<?php

namespace App\Admin\Extensions;

use Encore\Admin\Form\Field;

class WangEditor extends Field
{
    // protected $view = 'admin::form.editor';
    protected $view = 'admin.wang-editor';

    protected static $css = [
        '/packages/wangEditor-2.1.23/dist/css/wangEditor.min.css',
    ];

    protected static $js = [
        '/packages/wangEditor-2.1.23/dist/js/wangEditor.min.js',
    ];

    public function render()
    {
        $this->script = <<<EOT

var editor = new wangEditor('{$this->id}');
// 仅仅想移除某几个菜单，例如想移除『插入代码』和『全屏』菜单：
// 其中的 wangEditor.config.menus 可获取默认情况下的菜单配置
editor.config.uploadImgFileName = 'file'
editor.config.uploadImgUrl = '/upload';
// 配置自定义参数（举例）
editor.config.uploadParams = {
    // _token: LA.token
};
// 设置 headers（举例）
    editor.config.uploadHeaders = {
        'Accept' : 'text/x-json'
    };
editor.config.menus = $.map(wangEditor.config.menus, function(item, key) {
    if (item === 'insertcode') {
        return null;
    }
    if (item === 'location') {
        return null;
    }
    return item;
});

 editor.create();

EOT;
        return parent::render();
    }
}
