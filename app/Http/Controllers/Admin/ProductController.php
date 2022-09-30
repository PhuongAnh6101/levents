<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Services\Product\productAdminService;
use App\Http\Requests\Product\ProductRequest ;
use App\Helper\Helper;

class ProductController extends Controller
{

    protected $productAdminService;
    public function __construct(ProductAdminService $productAdminService)
    {
        $this ->productAdminService = $productAdminService;
    }
    public function create()
    {
        //
        return view ('admin.product.add',[
            'title' =>'Them danh muc moi',
            'menus' => $this->productAdminService->getMenu()
        ]);
    }
    public function store(ProductRequest $request)
    {
        //
         $this->productAdminService->insert($request);
         return redirect()->back();
    }
   public function index()
    {
        return view('admin.product.list',[
            'title' => 'Danh sach san pham moi nhat',
            //'products' => $this->productAdminservice->getAll()
            'products' => $this->productAdminService->getAll()
        ]);
    }
    public function show(Product $product)
    {
        return view('admin.product.edit',[
            'title' =>'Chinh sua danh san pham :'.$product->name,
            'product'=>$product,
            'menus' =>$this ->productAdminService->getMenu()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $result = $this->productAdminService->update($request,$product);
        if($result){
            return redirect('admin/products/list');
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $result = $this->productAdminService->delete($request);
        if($result){
        return response()->json([
            'error' => false,
            'message' => 'Xoa thanh cong san pham'

        ]);
    }
    return response()->json(['error' => true]);
}
}
