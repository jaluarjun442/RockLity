<?php

namespace App\Http\Controllers\admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use DataTables;

class CategoryController extends Controller
{
    public $route = 'admin/category';
    public $view  = 'admin/category.';
    public $moduleName = 'category';

    public function index()
    {
        $moduleName = $this->moduleName;
        return view($this->view . 'index', compact('moduleName'));
    }

    public function getData()
    {
        $query = Category::query();
        return Datatables::of($query)
            ->addIndexColumn()
            ->addColumn('image', function ($row) {
                if ($row->image) {
                    $url = asset('public/uploads/category/' . $row->image);
                    return '<img src="' . $url . '" alt="Image" width="100" height="100">';
                }
                return '';
            })
            ->addColumn('action', function ($row) {
                $editUrl = route('category.edit', $row->id);
                $deleteUrl = route('category.delete', $row->id);
                $viewImageUrl = $row->image ? asset('public/uploads/category/' . $row->image) : '';
                $btn = '';
                $btn .= '<a href="' . $editUrl . '" class="edit btn btn-primary btn-sm" style="margin-left:5px;"><i class="ri-edit-line"></i> Edit</a>';
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
        return view($this->view . 'form', compact('moduleName'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'status' => 'required|in:1,0',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif,svg,webp,avif,bmp,tif,tiff,ico|max:4096',
        ]);

        $data = [
            'name' => $request->name,
            'status' => $request->status,
        ];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = date('YmdHis') . '_' . rand(100000, 999999) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/category');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $imageName);
            $data['image'] = $imageName;
        }
        Category::create($data);
        return redirect($this->route)->with('success', $this->moduleName . ' added successfully!');
    }


    public function edit($id)
    {
        $moduleName = $this->moduleName;
        $category = Category::find($id);
        return view($this->view . '_form', compact('category', 'moduleName'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        // Validation
        $request->validate([
            'name' => 'required',
            'status' => 'required|in:1,0',
            'image' => 'nullable|mimes:jpeg,jpg,png,gif,svg,webp,avif,bmp,tif,tiff,ico|max:4096',
        ]);

        $data = [
            'name' => $request->name,
            'status' => $request->status,
        ];
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = date('YmdHis') . '_' . rand(100000, 999999) . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/category');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $image->move($destinationPath, $imageName);
            if ($category->image && file_exists($destinationPath . '/' . $category->image)) {
                unlink($destinationPath . '/' . $category->image);
            }
            $data['image'] = $imageName;
        }
        $category->update($data);
        return redirect($this->route)->with('success', $this->moduleName . ' edited successfully!');
    }

    public function delete($id)
    {
        Category::find($id)->delete();
        return redirect($this->route)->with('success', $this->moduleName . ' deleted successfully!');;
    }
}
