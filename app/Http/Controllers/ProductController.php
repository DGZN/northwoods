<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Http\Requests;
use App\Http\Requests\StoreProductRequest;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return (new Product)->all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        return Product::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);


        $modifiers = [];
        $groups = [];

        foreach ($product->modifiers as $modifier) {

          $modifiers[] = $modifier->group->name;

          $groups[$modifier->group->id][] = $modifier->group->toArray();
          $groups[$modifier->group->id]['modifiers'][] = array_merge($modifier->toArray(), $modifier->type->toArray());

        }

        foreach ($groups as $group) {

          $modifiers[$group[0]['name']] = $group['modifiers'];

        }

        foreach ($modifiers as $key => $modifier) {

          if (is_int($key)) {

            unset($modifiers[$key]);

          }

        }

        $product = Product::findOrFail($id);

        $product['modifiers'] = $modifiers;

        return $product;
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
        $product = Product::find($id);
        $product->update($request->all());

        if ( $request->has('productModifierID') ) {

          $product->modifiers()->save(new \App\ProductModifierPivot($request->all()));

        }

        if ($product) {

            return ['status' => true, 'message' => 'Updated'];

        }
    }

    /**
     * Store Sub Product at the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeSubproduct(Request $request, $id)
    {
        return Product::create($request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Product::destroy($id);
    }
}
