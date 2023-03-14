<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return $products;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {

        $files = $request->file('images');
        $image_path = $request->file('image')->store('image', 'public');
        if (!$request->hasFile('images')) {
            return response()->json(['upload_file_not_found'], 400);
        }
        $files = $request->file('images');

        $i = 0;
        foreach ($files as $file) {
            $i = $i + 1;
            $image = new Detailimage;
            $image->detail_id = $detail->id;

            $filename = date('YmdHis') . $i . '.' . $file->getClientOriginalExtension();
            $path = 'images';
            $file->move($path, $filename);
            $image->image = url('/') . '/images/' . $filename;
            $image->save();
        }
        $data = Product::create([
            'image' => $image_path,
            'title' => $request->title,
            'images' => implode("|", $images),
            'description' => $request->description,
            'alt' => $request->alt
        ]);

        return $data;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getbyId($id)
    {
        $obj = Product::where('id', $id)->get();
        return $obj;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('products')->where('id', '=', $id)->delete();
    }
}
