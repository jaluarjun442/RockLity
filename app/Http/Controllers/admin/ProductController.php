<?php

namespace App\Http\Controllers\admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use DataTables;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public $route = 'admin/product';
    public $view  = 'admin/product.';
    public $moduleName = 'product';

    public function index()
    {
        $moduleName = $this->moduleName;
        return view($this->view . 'index', compact('moduleName'));
    }

    public function getData()
    {
        $query = Product::query();
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                if ($row->image) {
                    $url = asset('public/uploads/product/' . $row->image);
                    return '<img src="' . $url . '" alt="Image" width="100" height="100">';
                }
                return '';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('product.edit', $row->id);
                $deleteUrl = route('product.delete', $row->id);
                $viewImageUrl = $row->image ? asset('public/uploads/product/' . $row->image) : '';
                $btn = '';
                $btn .= '<a href="' . $editUrl . '" class="edit btn btn-primary btn-sm" style="margin-left:5px;"><i class="fa fa-pencil"> </i> Edit</a>';
                $btn .= '<button type="button" data-delete_url="' . $deleteUrl . '" class="edit btn btn-danger btn-sm" id="delete_model_btn" name="delete_model_btn" style="margin-left:5px;"> <i class="ri-delete-bin-line"></i> Delete</button>';
                if ($viewImageUrl) {
                    $btn .= '<button type="button" 
                            class="btn btn-info btn-sm view-image-btn" 
                            data-image_url="' . $viewImageUrl . '" 
                            style="margin-left:5px;">
                            <i class="ri-image-line"></i> Image
                        </button>';
                }
                return $btn;
            })
            ->editColumn('status', function ($row) {
                return $row->status == 1 ? 'Active' : 'InActive';
            })
            ->rawColumns(['action', 'image'])
            ->order(function ($query) {
                $query->orderBy('id', 'desc');
            })
            ->make(true);
    }

    public function create()
    {
        $moduleName = $this->moduleName;
        $categories = Category::where('status', 1)->get();
        return view($this->view . 'form', compact('moduleName', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string',
            'sku'         => 'nullable|string|max:255',
            'price'       => 'nullable|numeric|min:0',
            'discount'    => 'nullable|numeric|min:0',
            'unit_type'   => 'required|in:Piece,KG,Meter,Litre,Gram',
            'category_id' => 'nullable|exists:category,id',
            'status'      => 'required|in:1,0',
            'image'       => 'nullable|mimes:jpeg,jpg,png,gif,svg,webp,avif,bmp,tif,tiff,ico|max:4096',
        ]);

        $data = $request->only([
            'name',
            'description',
            'sku',
            'price',
            'discount',
            'unit_type',
            'category_id',
            'status'
        ]);

        $data['created_by'] = Auth::id();

        // Handle image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = date('YmdHis') . '_' . rand(100000, 999999) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/product');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $imageName);
            $data['image'] = $imageName;
        }

        Product::create($data);
        return redirect($this->route)->with('success', $this->moduleName . ' added successfully!');
    }

    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $categories = Category::where('status', 1)->get();
        $product = Product::find($id);
        return view($this->view . '_form', compact('product', 'moduleName', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'status'      => 'required|in:1,0',
            'image'       => 'nullable|mimes:jpeg,jpg,png,gif,svg,webp,avif,bmp,tif,tiff,ico|max:4096',
            'price'       => 'nullable|numeric',
            'discount'    => 'nullable|numeric',
            'unit_type'   => 'required|string|max:50',
            'category_id' => 'nullable|integer',
        ]);

        $product = Product::findOrFail($id);

        $data = [
            'name'        => $request->name,
            'description' => $request->description,
            'sku'         => $request->sku,
            'price'       => $request->price,
            'discount'    => $request->discount,
            'unit_type'   => $request->unit_type,
            'category_id' => $request->category_id,
            'status'      => $request->status,
            'updated_by'  => Auth::id(),
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = date('YmdHis') . '_' . rand(100000, 999999) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/product');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            if ($product->image && file_exists($destinationPath . '/' . $product->image)) {
                unlink($destinationPath . '/' . $product->image);
            }
            $image->move($destinationPath, $imageName);
            $data['image'] = $imageName;
        }

        $product->update($data);

        return redirect($this->route)->with('success', $this->moduleName . ' updated successfully!');
    }

    public function delete($id)
    {
        Product::find($id)->delete();
        return redirect($this->route)->with('success', $this->moduleName . ' deleted successfully!');;
    }
}
