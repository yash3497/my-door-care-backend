<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Admin\ServiceArea;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class ServiceAreaController extends Controller
{
    public function index()
    {
        $page_title = 'Setup Areas';
        $service_areas = ServiceArea::orderBy('id', 'desc')->paginate(12);

        return view('admin.sections.service-area.index', compact('page_title', 'service_areas'));
    }
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'service_area' => 'required|string|unique:service_areas,service_area',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal', 'service-area-add');
        }

        try {
            ServiceArea::create([
                'service_area' => $request->service_area,
                'slug' => Str::slug($request->service_area),
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => ['Somthing was wrong!']]);
        }

        return back()->with(['success' => ['Added successfully']]);
    }

    public function update(Request $request)
    {
        $edit_service_area_id = $request->target;
        $edit_service_area = ServiceArea::findOrFail($edit_service_area_id);

        $validator = Validator::make($request->all(), [
            'service_area' => 'required|string|unique:service_areas,service_area',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with(['error' => ['Somthing was wrong!']]);
        }

        $validated = $validator->validate();

        try {
            $edit_service_area->update($validated);
        } catch (Exception $e) {
            return back()->with(['error' => ['Somthing was wrong!']]);
        }
        return back()->with(['success' => ['Update successfully!']]);
    }
    function delete(Request $request)
    {
        $service_area_id = $request->target;
        $service_area_id = ServiceArea::findOrFail($service_area_id);
        $validator = Validator::make($request->all(), [
            'target' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with(['error' => ['Somthing was wrong!']]);
        }
        $validated = $validator->validate();

        try {
            $service_area_id->delete();
        } catch (Exception $e) {
            return back()->with(['error' => ['Somthing was wrong!']]);
        }
        return back()->with(['success' => ['Delete successfully!']]);
    }
}
