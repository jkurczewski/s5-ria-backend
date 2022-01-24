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
            ->select(DB::raw('DISTINCT(addition_name)'))
            ->orderBy('addition_name', 'asc')
            ->get()->toArray();

        $alcohols =
        DB::table('alcohols')
            ->select(DB::raw('DISTINCT(alcohol_name)'))
            ->orderBy('alcohol_name', 'asc')
            ->get()->toArray();

        $beverages =
        DB::table('beverages')
            ->select(DB::raw('DISTINCT(beverage_name)'))
            ->orderBy('beverage_name', 'asc')
            ->get()->toArray();

        $ingredients = array('additions' => $additions, 'alcohols' => $alcohols, 'beverages' => $beverages);

        return response()->json($ingredients);
    }
}
