<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;

class UploadController extends Controller
{
    /**
     * [__construct description]
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 保存文件
     *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function store(Request $request)
    {
        $this->validate(request(), [
            'file' => ['required', 'file']
        ]);

        $file_path = request()->file('file')->store($request->directory ?? 'books', 'public');

        app()->environment('testing') || $this->reduceSize(storage_path('app/public') . '/' . $file_path, 200, 200);

        return response($file_path, 201);
    }

    /**
     * 压缩
     * @param  [type] $file_path  [description]
     * @param  [type] $max_width  [description]
     * @param  [type] $max_height [description]
     * @return [type]             [description]
     */
    private function reduceSize($file_path, $max_width, $max_height)
    {
        // 先实例化，传参是文件的磁盘物理路径
        $image = Image::make($file_path);

        // 进行大小调整的操作
        $image->resize($max_width, $max_height, function ($constraint) {

            // 设定宽度是 $max_width，高度等比例双方缩放
            $constraint->aspectRatio();

            // 防止裁图时图片尺寸变大
            $constraint->upsize();
        });

        // 对图片修改后进行保存
        $image->save();
    }
}
