<?php

namespace App\Http\Controllers;

use App\Models\Drink;
use App\Models\AdditionInDrink;
use App\Models\AlcoholInDrink;
use App\Models\BeverageInDrink;
use App\Http\Requests\StoreDrinkRequest;
use App\Http\Requests\UpdateDrinkRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class DrinkController extends Controller
{
    public function getUsableColumns($tables)
    {
        $usable_cols = array();

        foreach ($tables as $table) {
            $columns_raw = DB::select('describe ' . $table);

            foreach ($columns_raw as $column) {
                if (Str::contains($column->Type, ['varchar', 'text'])) {
                    array_push($usable_cols, $column->Field);
                }
            }
        }

        return $usable_cols;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\AllDrinkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchavle_cols = $this->getUsableColumns(['drinks', 'additions', 'alcohols', 'beverages']);
        $req = $request->all();

        $drinks_raw =
            DB::table('drinks')
            ->select(DB::raw('DISTINCT(drinks.id) as drink_id'))
            ->orderBy('drinks.id', 'asc')
            ->leftJoin('addition_in_drinks', 'addition_in_drinks.drink_id', '=', 'drinks.id')
            ->leftJoin('additions', 'addition_in_drinks.addition_id', '=', 'additions.id')
            ->leftJoin('alcohol_in_drinks', 'alcohol_in_drinks.drink_id', '=', 'drinks.id')
            ->leftJoin('alcohols', 'alcohol_in_drinks.alcohol_id', '=', 'alcohols.id')
            ->leftJoin('beverage_in_drinks', 'beverage_in_drinks.drink_id', '=', 'drinks.id')
            ->leftJoin('beverages', 'beverage_in_drinks.beverage_id', '=', 'beverages.id');
        if (!empty($req)) {
            foreach ($req as $key => $value) {
                if (in_array($key, $searchavle_cols)) {
                    $drinks_raw->where($key, 'LIKE', "%{$value}%");
                } else {
                    $drinks_raw->where($key, '=', $value);
                }
            }
        }
        $drinks_ids = $drinks_raw->get()->toArray();

        $drinks_query =
            DB::table('drinks')
            ->orderBy('drinks.id', 'asc');
        if (!empty($drinks_ids)) {
            foreach ($drinks_ids as $key => $value) {
                $drinks_query->orWhere('drinks.id', '=', $value->drink_id);
            }
            $empty_drinks = $drinks_query->get()->toArray();
        } else {
            return response()->json([]);
        }


        $drinks = array();

        foreach ($empty_drinks as $drink) {

            $additions =
                DB::table('addition_in_drinks')
                ->join('additions', 'addition_in_drinks.addition_id', '=', 'additions.id')
                ->where('addition_in_drinks.drink_id', '=', $drink->id)
                ->orderBy('additions.addition_name', 'asc')
                ->get()->toArray();

            $alcohols =
                DB::table('alcohol_in_drinks')
                ->join('alcohols', 'alcohol_in_drinks.alcohol_id', '=', 'alcohols.id')
                ->where('alcohol_in_drinks.drink_id', '=', $drink->id)
                ->orderBy('alcohols.alcohol_name', 'asc')
                ->get()->toArray();

            $beverages =
                DB::table('beverage_in_drinks')
                ->join('beverages', 'beverage_in_drinks.beverage_id', '=', 'beverages.id')
                ->where('beverage_in_drinks.drink_id', '=', $drink->id)
                ->orderBy('beverages.beverage_name', 'asc')
                ->get()->toArray();


            $ingredients = array('additions' => $additions, 'alcohols' => $alcohols, 'beverages' => $beverages);
            $drink = (array)$drink;
            $drink['ingredients'] = $ingredients;
            array_push($drinks, $drink);
        }

        return response()->json($drinks);
    }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \App\Http\Requests\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function uploadImage(Request $request)
    // {
    //     $validator = $request->validate([
    //         'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
    //     ]);

    //     if (!$validator) {
    //         return response()->json([$validator,  'error', 500]);
    //     }
    //     $uploadFolder = 'images/drinks';
    //     $image = $request->file('image');
    //     $image_uploaded_path = $image->store($uploadFolder, 'public');
    //     $uploadedImageResponse = array(
    //         "image_name" => basename($image_uploaded_path),
    //         "image_url" => Storage::disk('public')->url($image_uploaded_path),
    //         "mime" => $image->getClientMimeType()
    //     );
    //     return response()->json(['File Uploaded Successfully', 'success',   200, $uploadedImageResponse]);
    // }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDrinkRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDrinkRequest $request)
    {

        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'recipe' => 'required',
            'image' => 'required|image:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        $uploadFolder = 'images/drinks';
        $image = $request->file('image');
        $image_uploaded_path = $image->store($uploadFolder, 'public');

        $drink = Drink::create([
            'name' => $request->name,
            'description' => $request->description,
            'recipe' => $request->recipe,
            'image_url' => 'http://localhost:8000/storage/' . $image_uploaded_path
        ]);

        if (isset($request->beverages)) {
            foreach (explode(',', $request->beverages) as $beverage) {
                $beverage_parts = explode('-', $beverage);
                BeverageInDrink::create([
                    'drink_id' => $drink->id,
                    'beverage_id' => $beverage_parts[0],
                    'beverage_unit' => $beverage_parts[1],
                    'beverage_amount' => $beverage_parts[2]
                ]);
            }
        }

        if (isset($request->additions)) {
            foreach (explode(',', $request->additions) as $addition) {
                $addition_parts = explode('-', $addition);
                AdditionInDrink::create([
                    'drink_id' => $drink->id,
                    'addition_id' => $addition_parts[0],
                    'addition_unit' => $addition_parts[1],
                    'addition_amount' => $addition_parts[2]
                ]);
            }
        }

        if (isset($request->alcohols)) {
            foreach (explode(',', $request->alcohols) as $alcohol) {
                $alcohol_parts = explode('-', $alcohol);
                AlcoholInDrink::create([
                    'drink_id' => $drink->id,
                    'alcohol_id' => $alcohol_parts[0],
                    'alcohol_unit' => $alcohol_parts[1],
                    'alcohol_amount' => $alcohol_parts[2]
                ]);
            }
        }

        return response()->json(['Drink created successfully', $drink]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Drink  $drink
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $drink = DB::table('drinks')->where('drinks.id', '=', $id)->get()->toArray();

        if (is_null($drink)) {
            return response()->json('Data not found', 404);
        }

        $additions =
            DB::table('addition_in_drinks')
            ->join('additions', 'addition_in_drinks.addition_id', '=', 'additions.id')
            ->where('addition_in_drinks.drink_id', '=', $id)
            ->orderBy('additions.addition_name', 'asc')
            ->get()->toArray();

        $alcohols =
            DB::table('alcohol_in_drinks')
            ->join('alcohols', 'alcohol_in_drinks.alcohol_id', '=', 'alcohols.id')
            ->where('alcohol_in_drinks.drink_id', '=', $id)
            ->orderBy('alcohols.alcohol_name', 'asc')
            ->get()->toArray();

        $beverages =
            DB::table('beverage_in_drinks')
            ->join('beverages', 'beverage_in_drinks.beverage_id', '=', 'beverages.id')
            ->where('beverage_in_drinks.drink_id', '=', $id)
            ->orderBy('beverages.beverage_name', 'asc')
            ->get()->toArray();


        $ingredients = array('additions' => $additions, 'alcohols' => $alcohols, 'beverages' => $beverages);
        $drink['ingredients'] = $ingredients;

        return response()->json($drink);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDrinkRequest  $request
     * @param  \App\Models\Drink  $drink
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDrinkRequest $request, $id)
    {
        $request->validate([
            'image_url' => 'image:jpeg,png,jpg|max:2048'
        ]);

        $drink = Drink::find($id);

        $drink->name = $request->name;
        $drink->description = $request->description;
        $drink->recipe = $request->recipe;

        if ($request->file('image_url')) {
            $uploadFolder = 'images/drinks';
            $image = $request->file('image_url');
            $image_uploaded_path = $image->store($uploadFolder, 'public');
            $drink->image_url = 'http://localhost:8000/storage/' . $image_uploaded_path;
        }

        BeverageInDrink::where('drink_id', '=', $id)->delete();
        AlcoholInDrink::where('drink_id', '=', $id)->delete();
        AdditionInDrink::where('drink_id', '=', $id)->delete();

        if (isset($request->beverages)) {
            foreach (explode(',', $request->beverages) as $beverage) {
                $beverage_parts = explode('-', $beverage);
                BeverageInDrink::create([
                    'drink_id' => $id,
                    'beverage_id' => $beverage_parts[0],
                    'beverage_unit' => $beverage_parts[1],
                    'beverage_amount' => $beverage_parts[2]
                ]);
            }
        }

        if (isset($request->additions)) {
            foreach (explode(',', $request->additions) as $addition) {
                $addition_parts = explode('-', $addition);
                AdditionInDrink::create([
                    'drink_id' => $id,
                    'addition_id' => $addition_parts[0],
                    'addition_unit' => $addition_parts[1],
                    'addition_amount' => $addition_parts[2]
                ]);
            }
        }

        if (isset($request->alcohols)) {
            foreach (explode(',', $request->alcohols) as $alcohol) {
                $alcohol_parts = explode('-', $alcohol);
                AlcoholInDrink::create([
                    'drink_id' => $id,
                    'alcohol_id' => $alcohol_parts[0],
                    'alcohol_unit' => $alcohol_parts[1],
                    'alcohol_amount' => $alcohol_parts[2]
                ]);
            }
        }

        $drink->save();

        return response()->json(['Drink updated successfully', $drink]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Drink  $drink
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $drink = Drink::find($id);
        $drink->delete();

        return response()->json(['Drink deleted successfully', 200]);
    }
}
