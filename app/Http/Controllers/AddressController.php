<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreAddressPost;

class AddressController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * 添加地址
     * @param  StoreAddressPost $request [description]
     * @return [type]                    [description]
     */
    public function store(StoreAddressPost $request)
    {
        $address = auth()->user()->addAddress($request->validated());

        return response($address, 201);
    }
}
