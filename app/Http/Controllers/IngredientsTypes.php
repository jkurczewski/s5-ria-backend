<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class IngredientsTypes extends Controller
{
    public function index()
    {
        $additions =
            DB::table('additions')
            ->select(DB::raw('addition_name, id'))
            ->orderBy('addition_name', 'asc')
            ->get()->toArray();

        $alcohols =
            DB::table('alcohols')
            ->select(DB::raw('alcohol_name, id, alcohol_type'))
            ->orderBy('alcohol_type', 'asc')
            ->get()->toArray();

        $beverages =
            DB::table('beverages')
            ->select(DB::raw('beverage_name, id'))
            ->orderBy('beverage_name', 'asc')
            ->get()->toArray();

        $ingredients = array('additions' => $additions, 'alcohols' => $alcohols, 'beverages' => $beverages);

        return response()->json($ingredients);
    }
}
