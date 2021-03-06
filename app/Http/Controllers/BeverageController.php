<?php

namespace App\Http\Controllers;

use App\Models\Beverage;
use App\Models\BeverageInDrink;
use App\Http\Requests\StoreBeverageRequest;
use App\Http\Requests\UpdateBeverageRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BeverageController extends Controller
{
    public function getUsableColumns()
    {
        $columns_raw = DB::select('describe beverages');
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
            $query = DB::table('beverages');
            foreach ($request->all() as $key => $value) {
                if (in_array($key, $searchable_cols)) {
                    $query->where($key, 'LIKE', "%{$value}%");
                } else {
                    $query->where($key, '=', $value);
                }
            }
            $beverages_raw = $query->get()->toArray();
        } else {
            $beverages_raw =
                DB::table('beverages')
                ->orderBy('beverages.beverage_name', 'asc')
                ->get()->toArray();
        }

        $items = array();

        foreach ($beverages_raw as $item) {
            $drinks =
                DB::table('drinks')
                ->join('beverage_in_drinks', 'beverage_in_drinks.drink_id', '=', 'drinks.id')
                ->where('beverage_in_drinks.beverage_id', '=', $item->id)
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
     * @param  \App\Http\Requests\StoreBeverageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBeverageRequest $request)
    {
        $request->validate([
            'beverage_name' => 'required',
            'beverage_flavour' => 'required',
            'beverage_image_url' => 'required|image:jpeg,png,jpg|max:2048'
        ]);

        $uploadFolder = 'images/beverages';
        $image = $request->file('beverage_image_url');
        $image_uploaded_path = $image->store($uploadFolder, 'public');

        $beverage = Beverage::create([
            'beverage_name' => $request->beverage_name,
            'beverage_flavour' => $request->beverage_flavour,
            'beverage_image_url' => 'http://localhost:8000/storage/' . $image_uploaded_path
        ]);

        return response()->json(['Beverage created successfully', $beverage]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Beverage  $beverage
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $beverage = DB::table('beverages')
            ->orderBy('beverages.id', 'asc')
            ->where('beverages.id', '=', $id)
            ->get();

        if (is_null($beverage)) {
            return response()->json('Data not found', 404);
        }

        $drinks =
            DB::table('drinks')
            ->join('beverage_in_drinks', 'beverage_in_drinks.drink_id', '=', 'drinks.id')
            ->where('beverage_in_drinks.beverage_id', '=', $id)
            ->orderBy('drinks.name', 'asc')
            ->get()->toArray();

        $beverage['related_drinks'] = $drinks;

        return response()->json($beverage);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateBeverageRequest  $request
     * @param  \App\Models\Beverage  $beverage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBeverageRequest $request, $id)
    {
        $request->validate([
            'beverage_image_url' => 'image:jpeg,png,jpg|max:2048'
        ]);

        $beverage = Beverage::find($id);

        $beverage->beverage_name = $request->beverage_name;
        $beverage->beverage_flavour = $request->beverage_flavour;

        if ($request->file('beverage_image_url')) {
            $uploadFolder = 'images/beverages';
            $image = $request->file('beverage_image_url');
            $image_uploaded_path = $image->store($uploadFolder, 'public');
            $beverage->beverage_img_url = 'http://localhost:8000/storage/' . $image_uploaded_path;
        }

        $beverage->save();

        return response()->json(['Beverage updated successfully', $beverage]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Beverage  $beverage
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $beverage = Beverage::find($id);

        if ($beverage_in_drink = BeverageInDrink::where('beverage_id', '=', $id)->firstOrFail()) {
            return response()->json(['Beverage connected with Drink. Delete connection to free the beverage', $beverage_in_drink], 404);
        }

        $beverage->delete();

        return response()->json('Beverage deleted successfully');
    }
}
