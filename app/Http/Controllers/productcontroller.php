<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product; // Adjust the namespace and class name

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return view('product.index', ['products' => $products]);
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(Request $request)
    {
        // Validate data
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png,gif|max:10000'
        ]);

        // Upload image
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('products'), $imageName);

        // Create new product
        $product = new Product;
        $product->image = $imageName;
        $product->name = $request->name;
        $product->description = $request->description;

        $product->save();

        return back()->with('success', 'Product created successfully!');
    }

     public function edit($id){
        $product= product::where('id',$id)->first();

     return view ('product.edit' , ['product' => $product ]);

   
 }

 public function update(Request $request,$id){

     // Validate data
     $request->validate([
        'name' => 'required',
        'description' => 'required',
        'image' => 'nullable|mimes:jpg,jpeg,png,gif|max:10000'
    ]);


    $product = product::where('id',$id)->first();
    if(isset($request->image)){
         // Upload image

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('products'), $imageName);
        $product->image = $imageName;

    }

    
  

    // Create new product
    
    
    $product->name = $request->name;
    $product->description = $request->description;

    $product->save();

    return back()->with('success', 'Product  updated successfully!');
}
public function destroy($id){
   $product = product::where('id',$id)->first();

   $product->delete();

   return back()->with('success', 'Product  deleted successfully!');

}

 }
   
    


