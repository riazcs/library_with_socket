<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $product = Product::orderBy('created_at', 'desc')->get();
        $booked = Product::where('is_borrow',1)->count();
        return response([
            'product' => $product,
            'booked' => $booked
        ], 200);
    }

    public function booked_list()
    {
        $product = Product::where('is_borrow',1)->orderBy('created_at', 'desc')->get();
        return response([
            'product' => $product
        ], 200);
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
    public function store(Request $request)
    {

        // $this->validate($request, [
        //     'name' => 'required|min:5',
        //     'price' => 'required|numeric|gt:0',
        // ]);
        // $product = Product::create([
        //     'name'     => $request->input('name'),
        //     'price'    => $request->input('price'),
        // ]);
        // return response([
        //     'product' => $product
        // ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $product = Product::find($id);
        // $product->delete();
        // return response([
        //     'result' => 'success'
        // ], 200);
    }

    public function book_now(Request $request)
    {
        $book = Product::find($request->book_id);
        if (empty($book)) {
            throw new \Exception('Failed!');
        }
        $this->validate($request, [
            'book_id' =>  'required',
        ]);
        try {
            $update_data = $book->update([
                'is_borrow' => 1,
            ]);
            if (!empty($update_data)) {
                DB::commit();
                return response([
                        'result' => 'success'
                    ], 200);
            } else {
                throw new \Exception('Failed!');
            }
        } catch (\Exception $ex) {
            DB::rollBack();
            return back()->withErrors($ex->getMessage())->withInput();
        }
    }

}
