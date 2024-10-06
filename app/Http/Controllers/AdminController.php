<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\product;

use App\Models\Order;
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
   public function updateview($id)
    {
        // Fetch the item by ID (assuming it's a Product)
        $data = Product::find($id);

        // Check if product exists
        if ($data) {
            // Return the view with the product data
            return view('admin.updateview', compact('data'));
        } else {
            // Return error if product doesn't exist
            return redirect()->back()->with('error', 'Product not found');
        }
    }
    public function updateproduct(Request $request,$id)
    {
      $data =product::find($id);
      $image=$request->file;
      if($image)
      {

     
      $imagename = time() . '.' . $image->getClientOriginalExtension();
  
      $request->file->move('productimage',$imagename);
      $data->image=$imagename;
   }
      $data->title=$request->title;
      $data->price=$request->price;
      $data->description=$request->description;
      $data->quantity=$request->quantity;
      $data->save();
      return redirect()->back()->with('message', 'Product updated succesfully');
     
    }
   public function showorder()
   {
      $order=order:: all();
      return view('admin.showorder',compact('order'));
   }
   public function updatestatus($id)

   {
      $order=order::find($id);
      $order->status='delivered';
      $order->save();
      return redirect()->back();
   }

   }
