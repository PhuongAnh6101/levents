<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Http\Requests\Menu\CreateFormRequest;
use Illuminate\Http\Request;
use App\Http\Services\Menu\MenuService;
use App\Helper\Helper;
class MenuController extends Controller
{
    protected $menuService;
    public function __construct(MenuService $menuService)
    {
        $this->menuService = $menuService;
    }
    public function create(){
        return view('admin.menu.add',[
            'title'=>'Them danh muc moi',
            'menus' => $this->menuService->getParent()
        ]);
    }

    public function store(CreateFormRequest $request)
    {
        $this->menuService->create($request);

        return redirect()->back();
    }

    public function index(){
        return view('admin.menu.list',[
            'title' => 'Danh sach danh muc moi nhat',
            'menus' => $this->menuService->getAll()
        ]);
    }
    public function show(Menu $menu)
    {
    
       return view('admin.menu.edit',[
            'title' => 'Chinh sua danh muc: '.$menu->name,
            'menu' => $menu,
            'menus' => $this->menuService->getParent()
        ]);
        //dd($menu);
    }

    public function update(Menu $menu,CreateFormRequest $request)

    {
      $this->menuService->update($request, $menu);
      return redirect('/admin/menus/list');

    }


    public function destroy(Request $request) 
    {
        $resulf = $this->menuService->destroy($request);
        if ($resulf){
            return response()->json([
                'error' => false,
                'message'=> 'Xoa thanh cong danh muc'
            ]);
        }
        return response()->json([
            'error' => true
        
        ]);
    }
}
