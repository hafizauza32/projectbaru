<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::paginate(3);
        return view('admin.page.product', [
            'name'  => 'Product',
            'title' => 'Admin Product',
            'data'  => $data,
        ]);
    }

    public function addModal()
    {
        return view('admin.modal.addModal', [
            'title' => 'Tambah Data Product',
            'sku'   => 'TGL' . rand(10000, 99999),
        ]);
    }

    public function store(Request $request)
    {
        $data = new Product();
        $data->sku = $request->sku;
        $data->nama_product = $request->nama_product;
        $data->type = $request->type;
        $data->kategory = $request->kategory;
        $data->harga = $request->harga;
        $data->quantity = $request->quantity;
        $data->discount = 0.10;
        $data->is_active = 1;

        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/product'), $filename);
            $data->foto = $filename;
        }

        $data->save();
        Alert::toast('Data berhasil disimpan', 'success');
        return redirect()->route('product');
    }

    public function show($id)
    {
        $data = Product::findOrFail($id);
        return view('admin.modal.editModal', [
            'title' => 'Edit data product',
            'data'  => $data,
        ])->render();
    }

    public function update(Request $request, $id)
    {
        // Validate request data
        $request->validate([
            'sku' => 'required',
            'nama' => 'required',
            'type' => 'required',
            'kategory' => 'required',
            'harga' => 'required',
            'quantity' => 'required',
            // Add any other validation rules as needed
        ]);

        $data = Product::findOrFail($id);

        // Handle photo update only if a new file is uploaded
        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $filename = date('Ymd') . '_' . $photo->getClientOriginalName();
            $photo->move(public_path('storage/product'), $filename);
            $data->foto = $filename;
        }

        // Update other fields
        $data->update([
            'sku' => $request->sku,
            'nama_product' => $request->nama,
            'type' => $request->type,
            'kategory' => $request->kategory,
            'harga' => $request->harga,
            'quantity' => $request->quantity,
            'discount' => 10 / 100,
            'is_active' => 1,
        ]);

        // Optionally, you can include a success message using Laravel SweetAlert
        Alert::toast('Data berhasil diupdate', 'success');
        return redirect()->route('product');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['success' => 'Data berhasil dihapus']);
    }
}
