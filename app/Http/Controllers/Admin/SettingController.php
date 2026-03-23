<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::orderBy("group")->orderBy("order")->get()->groupBy("group");
        return view("admin.settings.index", compact("settings"));
    }

    public function update(Request $request)
    {
        $request->validate(["settings" => "required|array"]);

        DB::beginTransaction();
        try {
            foreach ($request->settings as $key => $value) {
                $setting = Setting::where("key", $key)->first();
                if ($setting) {
                    if ($setting->type === "image" && $request->hasFile("settings.{$key}")) {
                        $file = $request->file("settings.{$key}");
                        $filename = time() . "_" . $key . "." . $file->getClientOriginalExtension();
                        $path = $file->storeAs("settings", $filename, "public");
                        $value = "storage/" . $path;
                    }
                    $setting->value = $value;
                    $setting->save();
                }
            }
            DB::commit();
            Setting::clearCache();
            return redirect()->route("admin.settings.index")->with("success", "Cài đặt đã được cập nhật thành công!");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->with("error", "Cập nhật thất bại: " . $e->getMessage());
        }
    }
}
