<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends FrontendController
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getListProduct(Request $request){
        $url = $request->segment(2);
        $url = preg_split('/(-)/i',$url);
        if ($id = array_pop($url)){
            $products = Product::where([
                'pro_category_id'=>$id,
                'pro_active'=>Product::STATUS_PUBLIC
            ]);
            if($request->price){

                $price = $request->price;

                switch ($price)
                {
                    case '1':
                        $products->where('pro_price','<','1000000');
                        break;
                    case '3':
                        $products->whereBetween('pro_price',[1000000,3000000]);
                        break;
                    case '5':
                        $products->whereBetween('pro_price',[3000000,5000000]);
                        break;
                    case '7':
                        $products->whereBetween('pro_price',[5000000,7000000]);
                        break;
                    case '10':
                        $products->where('pro_price','>',10000000);
                        break;
                }
            }
            if($request->orderBy){
                $orderBy = $request->orderBy;
                switch ($orderBy){
                    case 'desc':
                        $products->orderBy('id','DESC');
                        break;
                    case 'asc':
                        $products->orderBy('id','ASC');
                        break;
                    case 'price_desc':
                        $products->orderBy('pro_price','DESC');
                        break;
                    case 'price_asc':
                        $products->orderBy('pro_price','ASC');
                        break;
                    default:
                        $products->orderBy('id','DESC');
                        break;
                }
            }
            $products = $products->orderBy('id','DESC')->paginate(10);

            $cateProduct = Category::find($id);

            $viewData = [
                'products' => $products,
                'cateProduct' =>$cateProduct
            ];
            return view('product.index',$viewData);
        }
        return redirect('/');
    }
}
