<?php // Ensure there are no lines above this

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User; // Ensure proper capitalization
use App\Models\Product; // Ensure proper capitalization
use App\Models\Cart;
use App\Models\Order;

class HomeController extends Controller
{
    public function redirect()
    {
        if (Auth::check()) {
            $usertype = Auth::user()->usertype;
            if ($usertype == '1') {
                return view('admin.home');
            } else {
                $data = Product::paginate(3);
                $count = Cart::where('phone', Auth::user()->phone)->count();
                return view('user.home', compact('data', 'count'));
            }
        } else {
            return redirect()->route('login');
        }
    }

    public function index()
    {
        $data = Product::paginate(3);
        $count = 0;

        if (Auth::check()) {
            $user = auth()->user();
            $count = Cart::where('phone', $user->phone)->count();
        }

        return view('user.home', compact('data', 'count'));
    }

    public function search(Request $request)
    {
        $search = $request->search; 
        $count = 0;

        if (Auth::check()) {
            $user = auth()->user();
            $count = Cart::where('phone', $user->phone)->count();
        }

        if ($search == '') {
            $data = Product::paginate(3);
            return view('user.home', compact('data', 'count'));
        }

        $data = Product::where('title', 'Like', '%' . $search . '%')->get();
        return view('user.home', compact('data', 'count'));
    }

    public function addcart(Request $request, $id)
    {
        if (Auth::id()) {
            $user = auth()->user();
            $product = Product::find($id);
            $cart = new Cart();
            $cart->name = $user->name;
            $cart->phone = $user->phone;
            $cart->address = $user->address;
            $cart->product_title = $product->title;
            $cart->price = $product->price;
            $cart->quantity = $request->quantity;
            $cart->save();

            return redirect()->back()->with('message', 'Product Added successfully');
        } else {
            return redirect('login');
        }
    }
    public function showcart()
    {
        // Get the current authenticated user
        $user = auth()->user();
    
        // Fetch all cart items associated with this user
        $cart = Cart::where('phone', $user->phone)->get(); // Use get() to retrieve all items
    
        // Count the number of cart items
        $count = $cart->count();
    
        // Pass the cart items and count to the view
        return view('user.showcart', compact('count', 'cart'));
    }
    
public function deletecart($id)
{
  $data=cart::find($id)  ;
  $data->delete();
  return redirect()->back() ->back()->with('message', 'Product Removed successfully');
}

public function confirmorder( Request $request)
{
    $user=auth()->user();
    $name=$user->name;
    $phone=$user->phone;
    $address=$user->address;
    foreach ($request->productname as $key => $productname)

    {
        $order=new order;
        $order->product_name=$request->productname[$key];
        $order->price=$request->price[$key];
        $order->quantity=$request->quantity[$key];
        $order->name=$name;
        $order->phone=$phone;
        $order->address=$address;
        $order->status='not delivered';

        $order->save();

    }
    DB::table('carts')->where('phone',$phone)->delete();
    return redirect()->back()->with('message', 'Product Removed successfully');
}

}

