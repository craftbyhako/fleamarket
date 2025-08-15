<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Sold;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;


class ItemController extends Controller
{
    public function index(Request $request){

        if (auth()->check()) {
            return redirect()->route('mylist', ['tab' => 'mylist']);
        }

        $keyword = $request->input('keyword');

        // Itemのデータを、user, sold, likes のデータも同時取得する
        $query = Item::with(['user', 'sold', 'likes']);

        if(!empty($keyword)) {
            $query->where('item_name', 'like', '%' . $keyword . '%');
        }

        $items = $query->get();
        return view('home', compact('items', 'keyword'));
    }

    // 詳細画面表示
    public function show($item_id){
    {
        $item = Item::with('user', 'categories', 'comments.user', 'condition')->withCount(['likes', 'comments'])->findOrFail($item_id);
        $comments = $item->comments;


        return view('item', compact('item', 'comments'));
    }
    }

    public function create()
    {
        $allCategories = Category::all();

        return view ('sell', compact('allCategories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $data = $request->validated();

        if($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $data['image'] = $path;
        }

        $data['user_id'] = auth()->id();

        $item = Item::create($data);

        if($request->has('categories')) 
        {
            $item->categories()->attach($request->categories);
        }
        
        return redirect()->route('item.create');
    }

}
