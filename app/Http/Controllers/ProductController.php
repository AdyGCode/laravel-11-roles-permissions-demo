<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProductController extends Controller
{

    /**
     * Define permissions for the Product Controller
     */
    function __construct()
    {
        $this->middleware(
            ['permission:product-list|product-create|product-edit|product-delete'],
            ['only' => ['index', 'show']]);
        $this->middleware(
            ['permission:product-create'],
            ['only' => ['create', 'store']]);
        $this->middleware(
            ['permission:product-edit'],
            ['only' => ['edit', 'update']]);
        $this->middleware(
            ['permission:product-delete'],
            ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index():View
    {
        $products = Product::latest()->paginate(5);
        return view('products.index', compact(['products']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request):RedirectResponse
    {
        $validated = $request->validate([
           'name'=>'required',
           'detail'=>'required',
        ]);

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success',"Product successfully added.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product):View
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product):View
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        request()->validate([
            'name' => 'required',
            'detail' => 'required',
        ]);

        $product->update($request->all());

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully');
    }
}
