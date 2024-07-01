<?php

namespace App\Http\Controllers;

use App\Models\transaksi;
use App\Http\Requests\StoretransaksiRequest;
use App\Http\Requests\UpdatetransaksiRequest;
use App\Models\product;
use App\Models\tblCart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use RealRashid\SweetAlert\Facades\Alert;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $best = product::where('quantity_out', '>=', 5)->get();
        $data = product::paginate(15);
        return view('costumer.page.home', [
            'title'  => 'Home',
            'data'   => $data,
            'best'   => $best,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function addTocart(Request $request)
    {
        $idProduct = $request->input('idProduct');
        $product = product::find($idProduct);

        if (!$product) {
            return redirect()->back()->with('error', 'Product not found!');
        }

        $db = new tblCart;
        $field = [
            'idUser'    => 'guest123',
            'id_barang' => $idProduct,
            'qty'       => 1,
            'price'     => $product->harga,
        ];

        $db::create($field);

        return redirect('/')->with('success', 'Product added to cart!');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoretransaksiRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(transaksi $transaksi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatetransaksiRequest $request, transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(transaksi $transaksi)
    {
        //
    }
}
