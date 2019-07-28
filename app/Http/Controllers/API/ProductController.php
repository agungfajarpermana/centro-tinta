<?php

namespace App\Http\Controllers\API;

use DB;
use App\Model\Branch;
use App\Model\Product;
use App\Model\BranchProduct;
use App\Model\ProductDetails;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ErrorFormUploadFile;
use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Product\ProductCollection as Products;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($search = null)
    {
        if(!$search){
            return Products::collection(Product::where('branch_id', 1)->orderBy('nama_product', 'ASC')->paginate(8));
        }

        return Products::collection(
            Product::where('branch_id', 1)->where('nama_product', 'LIKE', '%'.$search.'%')
                        ->orderBy('nama_product', 'ASC')
                        ->paginate(8)
        );
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
        if(!$request->ajax()) dd('Woow, Hayo mau ngapain!');
        
        try {
            DB::connection()->getPdo();
            DB::beginTransaction();

            try {

                $product = Product::create([
                    'branch_id'         => 1,
                    'nama_product'      => $request->product,
                    'jenis_product'     => 'Tinta Printer',
                    'kategori_product'  => 'Tinta',
                    'detail_product'    => 'ini dekripsi tentang product'
                ]);
        
                $product->productDetail()->create([
                    'harga'     => str_replace('.','',$request->price),
                    'penjualan' => 0
                ]);

                $branch = $product->branchProduct()->create([
                    'branch_id'    => 1,
                    'stok_awal'    => $request->stock,
                    'stok_masuk'   => $request->stock,
                    'stok_keluar'  => 0,
                    'stok_akhir'   => $request->stock
                ]);
                
                DB::commit();
                return response()->json([
                    'status' => true,
                    'msg'    => 'Data berhasil disimpan!'
                ]);

            } catch (\Exception $e) {

                DB::rollback();
                return response()->json([
                    'status' => false,
                    'msg'    => 'Ada masalah saat memasukan data product',
                    'error'  => $e->getMessage()
                ]);

            }

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'msg'    => 'Koneksi ke database terputus!',
                'error'  => $e->getMessage()
            ]);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        if(!$request->ajax()) dd('Woow, Hayo mau ngapain!');

        switch ($request->mode) {
            case 'product':
                $data = Product::where('id', $product->id)->update([
                    'nama_product' => $request->item
                ]);

                return $data;
                break;

            case 'type':
                $data = Product::where('id', $product->id)->update([
                    'jenis_product' => $request->item
                ]);

                return $data;
                break;

            case 'category':
                $data = Product::where('id', $product->id)->update([
                    'kategori_product' => $request->item
                ]);

                return $data;
                break;

            case 'price':
                $data = ProductDetails::where('product_id', $product->id)->update([
                    'harga' => $request->item
                ]);

                return $data;
                break;
            
            default:
                $data = BranchProduct::where('branch_id', 1)->where('product_id', $product->id)->update([
                    'stok_awal'  => $request->item,
                    'stok_masuk' => $request->item,
                    'stok_akhir' => $request->item
                ]);

                return $data;
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $data   = Product::findOrFail($product->id);
        $delete = $data->delete();
        
        return response()->json([
            'status' => true,
            'msg' => 'Product berhasil dihapus!'
        ]);
    }

    public function exportFileItems(Request $request)
    {
        return (new ProductsExport)->download('products.xlsx');
    }

    public function importFileItems(ErrorFormUploadFile $request)
    {
        $import = (new ProductsImport)->import($request->file('file'));
        
        if($import){
            return response()->json(['status' => true, 'msg' => 'Data berhasil di imports!']);
        }
    }
}
