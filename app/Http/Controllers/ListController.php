<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function index() {
        $items = Item::all();
        return view('index', compact('items'));
    }

    public function create(Request $request) {
        $item = new Item();
        $item->item = $request->text;
        $item->save();

        return 'Done';
    }

    public function update(Request $request) {
        $item =  Item::find($request->id);
        $item->item = $request->value;
        $item->save();

        return 'Done';
    }

    public function delete(Request $request) {
       Item::where('id', $request->id)->delete();
    }

    public function search(Request $request) {

        $item = $request->item;
        $items = Item::where('item', 'LIKE', '%' . $item . '%')->get();

        if(count($items == 0)) {
            $searchResult[] = 'No Items Found';
        } else {
            foreach ($items as $key => $value) {
                return $value->item;
            }
        }
    }
}
