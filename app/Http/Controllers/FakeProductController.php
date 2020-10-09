<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FakeProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = $this->getData();
        return response($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $this->getData();
        $newData = $request->all();
        $data = $data->push($newData);

        return response($data);
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
        $data = $this->getData();
        $form = $request->all();
        $selectedData = $data->where('id', $id)->first();
        $selectedData = $selectedData->merge($form);
        return response($selectedData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->getData();
        $data = $data->filter(function ($product) use ($id) {
            return $product['id'] != $id;
        });
        return response($data->values());
    }

    public function getData()
    {
        return collect([
            collect([
                'id' => 0,
                'title' => '測試商品一',
                'Content' => '這是很棒的商品',
                'price' => 100,
            ]),
            collect([
                'id' => 1,
                'title' => '測試商品二',
                'Content' => '這是有點棒的商品',
                'price' => 50,
            ])
        ]);
    }
}
