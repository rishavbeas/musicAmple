<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductionRequest;
use App\Http\Requests\UpdateProductionRequest;
use App\Models\Production;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ProductionsController extends Controller
{
    public function index(Request $request){
        $search = $request->input('search');
        $searchBy = 'name';
        $sortBy = in_array($request->input('sort_by'), ['id', 'name']) ? $request->input('sort_by') : 'id';
        $sort = in_array($request->input('sort'), ['asc', 'desc']) ? $request->input('sort') : 'desc';
        $perPage = in_array($request->input('per_page'), [10, 25, 50, 100]) ? $request->input('per_page') : config('settings.paginate');

        $productions = Production::when($search, function ($query) use ($search, $searchBy) {
                if($searchBy == 'name') {
                    return $query->searchName($search);
                }
            })
            ->orderBy($sortBy, $sort)
            ->paginate($perPage)
            ->appends(['search' => $search, 'search_by' => $searchBy, 'sort_by' => $sortBy, 'sort' => $sort, 'per_page' => $perPage]);

        return view('admin.productions.index', compact('productions'));
    }

    public function createProduction(){
        return view('admin.productions.new');
    }

    public function editProduction($id){
        $production = Production::where('id', $id)->firstOrFail();

        return view('admin.productions.edit', compact('production'));
    }

    public function storeProduction(StoreProductionRequest $request)
    {
        $production = new Production;

        $production->name = $request->input('name');
        $production->slug = $request->input('slug');
        $production->public = $request->input('public');
        if($request->hasFile('image')){
            $value = $request->file('image')->hashName();
            // Save the file
            $request->file('image')->move(public_path('uploads/productions'), $value);
        }
        $production->image = $value ?? 'default.png';
        $production->save();

        return Redirect::route('productions')->with('success', __(':name has been created.', ['name' => $request->input('name')]));
    }

    public function updateProduction(UpdateProductionRequest $request, $id)
    {
        $production = Production::findOrFail($id);

        $production->name = $request->input('name');
        $production->slug = $request->input('slug');
        $production->public = $request->input('public');
        if($request->hasFile('image')){
            $value = $request->file('image')->hashName();
            if (file_exists(public_path('uploads/productions/' . $production->image))) {
                if($production->image != 'default.png'){
                    unlink(public_path('uploads/productions/' . $production->image));
                }
            }
            // Save the file
            $request->file('image')->move(public_path('uploads/productions'), $value);
            $production->image = $value;
        }

        $production->save();

        return Redirect::route('productions.edit', $id)->with('success', __('Settings saved.'));
    }

    public function unpublicProduction(Request $request, $id){
        $production = Production::findOrFail($id);
        $production->public = 2;
        $production->save();

        return Redirect::back()->with('success', __('Settings saved.'));
    }

    public function publicProduction(Request $request, $id){
        $production = Production::findOrFail($id);
        $production->public = 1;
        $production->save();

        return Redirect::back()->with('success', __('Settings saved.'));
    }

    public function destroyProduction(Request $request, $id){
        $production = Production::findOrFail($id);
        if($production->image != 'default.png'){
            if (file_exists(public_path('uploads/productions/' . $production->image))) {
                unlink(public_path('uploads/productions/' . $production->image));
            }
        }
        $production->forceDelete();
        return Redirect::back()->with('success', __(':name has been deleted.', ['name' => $production->name]));
    }
}
