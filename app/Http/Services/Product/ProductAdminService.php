<?php
namespace App\Http\Services\Product;
use App\Models\Product;
use Illuminate\Support\Str;
use Session;
use App\Models\Menu;

class ProductAdminService
{
    public function getMenu()
    {
        return Menu::where('active',1)->get();
    }
    public function getAll()
    {
        return Product::with('menu')
        ->orderByDesc('id')->paginate(15);
    }
    
    protected function isValidPrice($request)
    {
        if ($request->input('price') != 0 && $request->input('price_sale') != 0
            && $request->input('price_sale') >= $request->input('price')
        ) {
            Session::flash('error', 'Giá giảm phải nhỏ hơn giá gốc');
            return false;
        }

        if ($request->input('price_sale') != 0 && (int)$request->input('price') == 0) {
            Session::flash('error', 'Vui lòng nhập giá gốc');
            return false;
        }

        return  true;
    }
    public function insert($request)
    {
        $isValidPrice = $this->isValidPrice($request);
        if($isValidPrice === false){
            return false;
        }
       // dd($request->all());
       try{
        $request->except('_token');
        Product::create($request->all());
        Session::flash('success','Them san pham thanh cong');
      }
      catch(\Exception $err) {
        Session::flash('error','Them san pham loi');
        \Log::info($err->getMessage());
        return false;
      }
     return true;

    }
    public function update($request, $product)
    {
        $isValidPrice = $this->isValidPrice($request);
        if($isValidPrice === false) return false;

        try{
            $product->fill($request->input());
            $product->save();
            Session::flash('success','Cap nhat thanh cong');
        } catch(\Exception $err){
            Session::flash('err','Cap nhat khong thanh cong');
            \log::info($err->getMessage());
            return false;
        }
        return true;

    }
    public function delete($request)
    {
        $product = Product::where('id', $request->input('id'))->first();
        if ($product) {
            $product->delete();
            return true;
        }

        return false;
    }
  
}