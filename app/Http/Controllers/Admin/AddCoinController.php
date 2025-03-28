<?php

namespace App\Http\Controllers\Admin;

use Exception;
use Illuminate\Http\Request;
use App\Models\Admin\AddCoin;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AddCoinController extends Controller
{
    public function index()
    {
        $page_title = 'Setup Coin';
        $add_coins = AddCoin::orderBy('id', 'desc')->paginate(12);
        return view('admin.sections.add-coin.index', compact('page_title', 'add_coins'));
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'coin' => 'required|integer|min:0',
            'price' => 'required|integer|min:0'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with('modal', 'coin-add');
        }

        try {
            AddCoin::create([
                'coin' => $request->coin,
                'price' => $request->price,
            ]);
        } catch (Exception $e) {
            return back()->with(['error' => ['Somthing was wrong!']]);
        }

        return back()->with(['success' => ['Added successfully']]);
    }

    public function update(Request $request)
    {
        $edit_coin_id = $request->target;
        $edit_coin = AddCoin::findOrFail($edit_coin_id);

        $validator = Validator::make($request->all(), [
            'coin' => 'required|integer|min:0',
            'price' => 'required|integer|min:0',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with(['error' => ['Somthing was wrong!']]);
        }

        $validated = $validator->validate();

        try {
            $edit_coin->update($validated);
        } catch (Exception $e) {
            return back()->with(['error' => ['Somthing was wrong!']]);
        }
        return back()->with(['success' => ['Update successfully!']]);
    }
    function delete(Request $request)
    {
        $coin_id = $request->target;
        $coin_id = AddCoin::findOrFail($coin_id);
        $validator = Validator::make($request->all(), [
            'target' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput()->with(['error' => ['Somthing was wrong!']]);
        }
        $validated = $validator->validate();

        try {
            $coin_id->delete();
        } catch (Exception $e) {
            return back()->with(['error' => ['Somthing was wrong!']]);
        }
        return back()->with(['success' => ['Delete successfully!']]);
    }
}
