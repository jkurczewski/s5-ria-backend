<?php

namespace App\Http\Controllers;

use App\Models\Alcohol;
use App\Models\AlcoholInDrink;
use App\Http\Requests\StoreAlcoholRequest;
use App\Http\Requests\UpdateAlcoholRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AlcoholController extends Controller
{
    public function getUsableColumns()
    {
        $columns_raw = DB::select('describe alcohols');
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
            $query = DB::table('alcohols');
            foreach ($request->all() as $key => $value) {
                if (in_array($key, $searchable_cols)) {
                    $query->where($key, 'LIKE', "%{$value}%");
                } else {
                    $query->where($key, '=', $value);
                }
            }
            $alcohols_raw = $query->get()->toArray();
        } else {
            $alcohols_raw =
                DB::table('alcohols')
                ->get()->toArray();
        }

        $items = array();

        foreach ($alcohols_raw as $item) {
            $drinks =
                DB::table('drinks')
                ->join('alcohol_in_drinks', 'alcohol_in_drinks.drink_id', '=', 'drinks.id')
                ->where('alcohol_in_drinks.alcohol_id', '=', $item->id)
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
     * @param  \App\Http\Requests\StoreAlcoholRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAlcoholRequest $request)
    {
        $request->validate([
            'alcohol_name' => 'required',
            'alcohol_type' => 'required',
            'alcohol_strength' => 'required',
            'alcohol_profile_smell' => 'required',
            'alcohol_profile_taste' => 'required',
            'alcohol_profile_finish' => 'required',
            'alcohol_image_url' => 'required|image:jpeg,png,jpg|max:2048'
        ]);

        $uploadFolder = 'images/alcohols';
        $image = $request->file('alcohol_image_url');
        $image_uploaded_path = $image->store($uploadFolder, 'public');

        $alcohol = Alcohol::create([
            'alcohol_name' => $request->alcohol_name,
            'alcohol_type' => $request->alcohol_type,
            'alcohol_strength' => $request->alcohol_strength,
            'alcohol_profile_smell' => $request->alcohol_profile_smell,
            'alcohol_profile_taste' => $request->alcohol_profile_taste,
            'alcohol_profile_finish' => $request->alcohol_profile_finish,
            'alcohol_image_url' => 'http://localhost:8000/storage/' . $image_uploaded_path
        ]);

        return response()->json(['Alcohol created successfully', $alcohol]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Alcohol  $alcohol
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $alcohol = DB::table('alcohols')
            ->where('alcohols.id', '=', $id)
            ->orderBy('alcohols.id', 'asc')
            ->get();

        if (is_null($alcohol)) {
            return response()->json('Data not found', 404);
        }

        $drinks =
            DB::table('drinks')
            ->join('alcohol_in_drinks', 'alcohol_in_drinks.drink_id', '=', 'drinks.id')
            ->where('alcohol_in_drinks.alcohol_id', '=', $id)
            ->orderBy('drinks.name', 'asc')
            ->get()->toArray();

        $alcohol['related_drinks'] = $drinks;

        return response()->json($alcohol);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAlcoholRequest  $request
     * @param  \App\Models\Alcohol  $alcohol
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAlcoholRequest $request, $id)
    {
        $request->validate([
            'addition_image_url' => 'image:jpeg,png,jpg|max:2048'
        ]);

        $alcohol = Alcohol::find($id);

        $alcohol->alcohol_name = $request->alcohol_name;
        $alcohol->alcohol_type = $request->alcohol_type;
        $alcohol->alcohol_strength = $request->alcohol_strength;
        $alcohol->alcohol_profile_smell = $request->alcohol_profile_smell;
        $alcohol->alcohol_profile_taste = $request->alcohol_profile_taste;
        $alcohol->alcohol_profile_finish = $request->alcohol_profile_finish;

        if ($request->file('alcohol_image_url')) {
            $uploadFolder = 'images/alcohols';
            $image = $request->file('alcohol_image_url');
            $image_uploaded_path = $image->store($uploadFolder, 'public');
            $alcohol->alcohol_img_url = 'http://localhost:8000/storage/' . $image_uploaded_path;
        }

        $alcohol->save();

        return response()->json(['Alcohol updated successfully', $alcohol]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Alcohol  $alcohol
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $alcohol = Alcohol::find($id);

        if ($alcohol_in_drink = AlcoholInDrink::where('alcohol_id', '=', $id)->firstOrFail()) {
            return response()->json(['Alcohol connected with Drink. Delete connection to free the alcohol', $alcohol_in_drink], 404);
        }

        $alcohol->delete();

        return response()->json('Alcohol deleted successfully');
    }
}
