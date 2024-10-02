<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\product;
use Illuminate\Http\RedirectResponse;

class AdminController extends Controller
{
   public function product()
   {
    return view('admin.product');
   }
   
   
   public function uploadproduct(Request $request)
   {
    $data=new product;
    $image=$request->file;
    $imagename = time() . '.' . $image->getClientOriginalExtension();

    $request->file->move('productimage',$imagename);
    $data->image=$imagename;
    $data->title=$request->title;
    $data->price=$request->price;
    $data->description=$request->description;
    $data->quantity=$request->quantity;
    $data->save();
    return redirect()->back()->with('message', 'Product added succesfully');
   
   } 
   public function showproduct()
   {
    $data = product::all();
    return view('admin.showproduct', compact('data'));
   }
   public function deleteproduct($id)
   {
    $data = product::find($id);
    $data->delete();
    return redirect()->back() ->with('message', 'Product deleted ');;
   }
}
