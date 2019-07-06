<?php

namespace App\Http\Controllers\API;

use App\Model\Branch;
use App\Model\Product;
use App\Model\BranchProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Branch\BranchProductResource;
use App\Http\Resources\Branch\BranchProductCollection as Branches;
use App\Http\Resources\Branch\BranchSearchCollection as Searching;

class BranchProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return Branches::collection(BranchProduct::where('branch_id', 1)->paginate(8));
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
    public function show(Branch $branch)
    {
        return new BranchProductResource($branch);
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
        //
    }

    public function searchData($search)
    {
        $data = Product::where('nama_product', 'LIKE', '%'.$search.'%')->paginate(2);
        return Searching::collection($data);
    }
}
