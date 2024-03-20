<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    //direct product list page
    public function list()
    {
        $pizzas = Product::select('products.*', 'categories.name as category_name')
            ->when(request('key'), function ($query) {
                $query->where('name', 'like', '%' . request('key') . '%');
            })
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->orderBy('created_at', 'desc')
            ->paginate(4);

        return view('admin.products.pizzalist', compact('pizzas'));
    }

    //direct product create page
    public function createPage()
    {
        $categories = Category::select('id', 'name')->get();
        return view('admin.products.create', compact('categories'));
    }

    //create pizza
    public function create(Request $request)
    {
        $this->productValidationCheck($request, "create");
        $data = $this->getProductInfo($request);

        $fileName = uniqid() . $request->file('pizzaImage')->getClientOriginalName();
        $request->file('pizzaImage')->storeAs('public', $fileName);
        $data['image'] = $fileName;

        Product::create($data);
        return redirect()->route('products#list');
    }

    //delete product
    public function delete($id)
    {
        Product::where('id', $id)->delete();
        return redirect()->route('products#list')->with(['deleteSuccess' => 'Product has been deleted successfully']);
    }

    //direct edit product page
    public function edit($id)
    {
        $pizza = Product::select('products.*', 'categories.name as category_name')
            ->leftJoin('categories', 'products.category_id', 'categories.id')
            ->where('products.id', $id)->first();
        return view('admin.products.edit', compact('pizza'));
    }

    //direct update product page
    public function updatePage($id)
    {
        $pizza = Product::where('id', $id)->first();
        $category = Category::get();
        return view('admin.products.update', compact('pizza', 'category'));
    }

    //update product
    public function update(Request $request)
    {
        $this->productValidationCheck($request, "update");
        $data = $this->getProductInfo($request);
        $productId = $request->pizzaId;

        if ($request->hasFile('pizzaImage')) {
            $oldImage = Product::where('id', $request->pizzaId)->first();
            $oldImage = $oldImage->image;

            if ($oldImage != null) {
                Storage::delete('public/' . $oldImage);
            }

            $fileName = uniqid() . $request->file('pizzaImage')->getClientOriginalName();
            $request->file('pizzaImage')->storeAs('public', $fileName);
            $data['image'] = $fileName;
        }
        Product::where('id', $request->pizzaId)->update($data);
        return redirect()->route('products#edit', ['id' => $productId])->with(['updateSuccess' => 'Your product information has been updated successfully']);
    }

    //request product info
    public function getProductInfo($request)
    {
        return [
            'category_id' => $request->pizzaCategory,
            'name' => $request->pizzaName,
            'description' => $request->pizzaDescription,
            'price' => $request->pizzaPrice,
            'waiting_time' => $request->waitingTime,
        ];
    }

    //product validation check
    public function productValidationCheck($request, $action)
    {
        $validationRules = [
            'pizzaName' => 'required|min:5|unique:products,name,' . $request->pizzaId,
            'pizzaCategory' => 'required',
            'pizzaDescription' => 'required',
            'pizzaPrice' => 'required',
            'waitingTime' => 'required'
        ];

        $validationRules['pizzaImage'] = $action == "create" ? 'required|mimes:png,jpg,jpeg|file' : 'mimes:png,jpg,jpeg|file';
        Validator::make($request->all(), $validationRules)->validate();
    }
}
