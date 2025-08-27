<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;
use App\Models\Item;
use App\Models\Sold;
use App\Models\Category;
use App\Models\Condition;
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
        $conditions = Condition::all();

        return view ('sell', compact('allCategories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        // dd($request->all());
        $data = $request->validated();

        $data['brand'] = $data['brand'] ?? '';

        // 画像保存
        if($request->hasFile('image')) {
            $path = $request->file('image')->store('items', 'public');
            $data['image'] = $path;
        }

        // ログインユーザーID
        $data['user_id'] = auth()->id();

        // Itemテーブルへの新規作成
        $item = Item::create($data);

        // カテゴリ紐付け
        if($request->filled('categories')) 
        {
            $item->categories()->sync($request->input('categories'));
        }
        
        return redirect()->route('item.create');
    }

}
