<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePageRequest;
use App\Http\Requests\UpdatePageRequest;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PageController extends Controller
{
    public function index(Request $request) {
        $search = $request->input('search');
        $searchBy = 'name';
        $sortBy = in_array($request->input('sort_by'), ['id', 'name']) ? $request->input('sort_by') : 'id';
        $sort = in_array($request->input('sort'), ['asc', 'desc']) ? $request->input('sort') : 'desc';
        $status = $request->input('status');
        $perPage = in_array($request->input('per_page'), [10, 25, 50, 100]) ? $request->input('per_page') : config('settings.paginate');

        $pages = Page::when($search, function ($query) use ($search, $searchBy) {
            return $query->searchName($search);
        })
        ->orderBy($sortBy, $sort)
        ->paginate($perPage)
        ->appends(['search' => $search, 'search_by' => $searchBy, 'sort_by' => $sortBy, 'sort' => $sort, 'per_page' => $perPage]);

        return view('admin.pages.index', compact('pages'));
    }
    //TODO
    public function show($id)
    {
        $page = Page::where('slug', $id)->firstOrFail();
        return view('pages.index', compact('page'));
    }
    public function createPage(){
        return view('admin.pages.new');
    }
    public function storePage(StorePageRequest $request)
    {
        $page = new Page;

        $page->name = $request->input('name');
        $page->slug = $request->input('slug');
        $page->content = $request->input('content');

        $page->save();

        return Redirect::route('pages')->with('success', __(':name has been created.', ['name' => $request->input('name')]));
    }
    public function editPage($id){
        $page = Page::where('id', $id)->firstOrFail();

        return view('admin.pages.edit', compact('page'));
    }
    public function updatePage(UpdatePageRequest $request, $id)
    {
        $page = Page::findOrFail($id);

        $page->name = $request->input('name');
        $page->slug = $request->input('slug');
        $page->content = $request->input('content');

        $page->save();

        return Redirect::route('pages.edit', $id)->with('success', __('Settings saved.'));
    }
    public function destroyPage($id){
        $page = Page::findOrFail($id);
        $page->delete();

        return Redirect::route('pages')->with('success', __(':name has been deleted.', ['name' => $page->name]));
    }
}
