<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    //index
    public function index()
    {
        $categories = Category::all(); // Lấy tất cả danh mục
        $totalProducts = Product::count();
        $lowStockProducts = Product::where('stock_quantity', '>', 0)->where('stock_quantity', '<=', 5)->count();
        $outOfStockProducts = Product::where('stock_quantity', '=', 0)->count();
        $activeProducts = $totalProducts - $outOfStockProducts;
        $products = Product::with('category')->paginate(4);

        return view('admin.products.index', compact('categories', 'totalProducts', 'lowStockProducts', 'activeProducts', 'outOfStockProducts', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'unit' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'image_url' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image_url')) {
            $validated['image_url'] = $request->file('image_url')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->back()->with('success', 'Thêm sản phẩm thành công!');
    }

    public function edit($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:products,slug,' . $id,
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'unit' => 'required|string',
            'description' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('image_url')) {
            $validatedData['image_url'] = $request->file('image_url')->store('products', 'public');
        }

        $product->update($validatedData);

        return response()->json(['success' => true, 'message' => 'Cập nhật sản phẩm thành công!']);
    }
}
