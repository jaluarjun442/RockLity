<?php

namespace App\Http\Controllers\admin;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use DataTables;

class SettingsController extends Controller
{
    public $route = 'admin/setting';
    public $view  = 'admin/setting.';
    public $moduleName = 'setting';

    public function index()
    {
        $moduleName = $this->moduleName;
        $setting = Setting::find(1);
        return view($this->view . 'index', compact('setting', 'moduleName'));
    }

    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);

        // Validation
        $request->validate([
            'name' => 'required',
            'mobile' => 'required',
            'email' => 'required',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
            'favicon' => 'nullable|mimes:jpeg,jpg,png,gif,svg,webp,avif,bmp,tif,tiff,ico|max:4096',
        ]);

        $data = [
            'name' => $request->name,
            'tagline' => $request->tagline,
            'mobile' => $request->mobile,
            'email' => $request->email,
            'address_line_1' => $request->address_line_1,
            'address_line_2' => $request->address_line_2,
            'city' => $request->city,
            'state' => $request->state,
            'pincode' => $request->pincode,
            'gst' => $request->gst,
            'pan' => $request->pan,
            'invoice_prefix' => $request->invoice_prefix,
            'invoice_remarks' => $request->invoice_remarks
        ];
        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            $imageName = date('YmdHis') . '_' . rand(100000, 999999) . '.' . $logo->getClientOriginalExtension();
            $destinationPath = public_path('uploads/setting');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $logo->move($destinationPath, $imageName);
            if ($setting->logo && file_exists($destinationPath . '/' . $setting->logo)) {
                unlink($destinationPath . '/' . $setting->logo);
            }
            $data['logo'] = $imageName;
        }
        if ($request->hasFile('favicon')) {
            $favicon = $request->file('favicon');
            $imageName = date('YmdHis') . '_' . rand(100000, 999999) . '.' . $favicon->getClientOriginalExtension();
            $destinationPath = public_path('uploads/setting');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $favicon->move($destinationPath, $imageName);
            if ($setting->favicon && file_exists($destinationPath . '/' . $setting->favicon)) {
                unlink($destinationPath . '/' . $setting->favicon);
            }
            $data['favicon'] = $imageName;
        }
        $setting->update($data);
        return redirect($this->route)->with('success', $this->moduleName . ' Updated successfully!');
    }
}
