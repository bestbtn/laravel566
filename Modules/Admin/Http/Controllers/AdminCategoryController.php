<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Requests\RequestCategory;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;


class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $categories = Category::select('id','c_name','c_title_seo','c_active','c_home')->get();
        $viewData   = [
            'categories' => $categories
        ];
        return view('admin::category.index',$viewData);
    }

    public function create()
    {
        return view('admin::category.create');
    }

    public function store(RequestCategory $requestCategory)
    {

        $this->insertOrUpdate($requestCategory);
        return redirect()->back()->with('success','Thêm mới thành công');

    }
    public function edit($id){
        $category = Category::find($id);
        return view('admin::category.update',compact('category'));
    }
    public  function update(RequestCategory $requestCategory,$id){
        $this->insertOrUpdate($requestCategory,$id);
        return redirect()->back();
    }

    public function insertOrUpdate($requestCategory,$id=''){
        $code =1;
        try{
            $category                   = new Category();
            if ($id){
                $category               = Category::find($id);
            }
            $category->c_name           = $requestCategory->name;
            $category->c_slug           = str_slug($requestCategory->name);
            $category->c_icon           = str_slug($requestCategory->icon);
            $category->c_title_seo      = $requestCategory->c_title_seo ? $requestCategory->c_title_seo : $requestCategory->name;
            $category->c_decription_seo = $requestCategory->c_decription_seo;
            $category->save();
        }catch (\Exception $exception)
        {
            $code = 0;
            Log::error("[Error insert or update Categories]".$exception->getMessage());
        }
        return $code;
    }
    public function action(Request $request,$action,$id){
        $messenge = '';

        if($action){
            $category = Category::find($id);
            switch ($action){
                case 'delete':
                    $category->delete();
                    $messenge = "Xóa dữ liệu thành công";
                    break;
                case 'home':
                    $category->c_home = $category->c_home == 1 ? 0 : 1;
                    $messenge = "Chuyển đổi thành công";
                    $category->save();
                    break;
                case 'active':
                    $category->c_active = $category->c_active == 1 ? 0 : 1;
                    $messenge = "Chuyển đổi thành công";
                    $category->save();
                    break;
            }
        }
        return redirect()->back()->with('success',$messenge);

    }




}

