<?php

namespace App\Http\Controllers;

use App\Models\Addition;
use App\Models\AdditionInDrink;
use App\Http\Requests\StoreAdditionRequest;
use App\Http\Requests\UpdateAdditionRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdditionController extends Controller
{
    public function getUsableColumns()
    {
        $columns_raw = DB::select('describe additions');
        $usable_cols = array();

        foreach ($columns_raw as $column) {
            if (Str::contains($column->Type, ['varchar', 'text'])) {
                array_push($usable_cols, $column->Field);
            }
        }

        return $usable_cols;
    }
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchable_cols = $this->getUsableColumns();

        if (!empty($request->all())) {
            $query = DB::table('additions');
            foreach ($request->all() as $key => $value) {
                if (in_array($key, $searchable_cols)) {
                    $query->where($key, 'LIKE', "%{$value}%");
                } else {
                    $query->where($key, '=', $value);
                }
            }
            $additions_raw = $query->get()->toArray();
        } else {
            $additions_raw =
                DB::table('additions')
                ->orderBy('additions.addition_name', 'asc')
                ->get()->toArray();
        }

        $items = array();

        foreach ($additions_raw as $item) {
            $drinks =
                DB::table('drinks')
                ->join('addition_in_drinks', 'addition_in_drinks.drink_id', '=', 'drinks.id')
                ->where('addition_in_drinks.addition_id', '=', $item->id)
                ->orderBy('drinks.name', 'asc')
                ->get()->toArray();

            $item = (array)$item;
            $item['related_drinks'] = $drinks;
            array_push($items, $item);
        }

        return response()->json($items);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAdditionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdditionRequest $request)
    {
        $request->validate([
            'addition_name' => 'required',
            'addition_image_url' => 'required|image:jpeg,png,jpg|max:2048'
        ]);

        $uploadFolder = 'images/additions';
        $image = $request->file('addition_image_url');
        $image_uploaded_path = $image->store($uploadFolder, 'public');

        $addition = Addition::create([
            'addition_name' => $request->addition_name,
            'addition_image_url' => 'http://localhost:8000/storage/' . $image_uploaded_path
        ]);

        return response()->json(['Addition created successfully', $addition]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Addition  $addition
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $addition = DB::table('additions')
            ->where('additions.id', '=', $id)
            ->orderBy('additions.id', 'asc')
            ->get();

        if (is_null($addition)) {
            return response()->json('Data not found', 404);
        }

        $drinks =
            DB::table('drinks')
            ->join('addition_in_drinks', 'addition_in_drinks.drink_id', '=', 'drinks.id')
            ->where('addition_in_drinks.addition_id', '=', $id)
            ->orderBy('drinks.name', 'asc')
            ->get()->toArray();

        $addition['related_drinks'] = $drinks;

        return response()->json($addition);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAdditionRequest  $request
     * @param  \App\Models\Addition  $addition
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdditionRequest $request, $id)
    {
        $request->validate([
            'addition_image_url' => 'image:jpeg,png,jpg|max:2048'
        ]);

        $addition = Addition::find($id);

        $addition->addition_name = $request->addition_name;

        if ($request->file('addition_image_url')) {
            $uploadFolder = 'images/additions';
            $image = $request->file('addition_image_url');
            $image_uploaded_path = $image->store($uploadFolder, 'public');
            $addition->addition_img_url = 'http://localhost:8000/storage/' . $image_uploaded_path;
        }

        $addition->save();

        return response()->json(['addition updated successfully', $addition]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Addition  $addition
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $addition = Addition::find($id);

        if ($addition_in_drink = AdditionInDrink::where('addition_id', '=', $id)->firstOrFail()) {
            return response()->json(['Addition connected with Drink. Delete connection to free the addition', $addition_in_drink], 404);
        }

        $addition->delete();

        return response()->json('Addition deleted successfully');
    }
}
