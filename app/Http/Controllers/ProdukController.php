<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Produk;

class ProdukController extends Controller
{
    // USER SIDE - View all products with search
    public function index(Request $request)
    {
        $nama = $request->input('nama');
        $harga_min = $request->input('min');
        $harga_max = $request->input('max');

        $query = Produk::query();

        if (!empty($nama)) {
            $query->where('nama', 'like', '%' . $nama . '%');
        }
        if (!empty($harga_min)) {
            $query->where('harga', '>=', $harga_min);
        }
        if (!empty($harga_max)) {
            $query->where('harga', '<=', $harga_max);
        }
        $produk = $query->orderBy('id_produk', 'desc')->get();
        return view('products.index', compact('produk', 'nama', 'harga_min', 'harga_max'));
    }

    // ADMIN SIDE - View all products
    public function adminIndex()
    {
        $produk = Produk::orderBy('id_produk', 'desc')->get();
        return view('admin.products.index', compact('produk'));
    }

    // ADMIN SIDE - Show create form
    public function create()
    {
        return view('admin.products.create');
    }

    // ADMIN SIDE - Store new product
    public function store(Request $request)
    {
        // VALIDASI MANUAL DENGAN Validator::make()
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:100',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // max 5MB
            'harga' => 'required|numeric|gt:0',
            'stock' => 'required|integer|min:0',
            'diskon' => 'nullable|numeric|min:0|max:100',
        ], [
            'nama.required' => 'Nama produk wajib diisi',
            'nama.max' => 'Nama produk maksimal 100 karakter',
            'gambar.required' => 'Gambar produk wajib diupload',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.max' => 'Ukuran gambar maksimal 5MB',
            'harga.required' => 'Harga wajib diisi',
            'harga.gt' => 'Harga harus lebih besar dari 0',
            'stock.required' => 'Stock wajib diisi',
            'stock.integer' => 'Stock harus berupa angka bulat',
            'stock.min' => 'Stock minimal 0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validasi gagal! Periksa form Anda.');
        }

        try {
            // Handle image upload
            $imageName = null;
            if ($request->hasFile('gambar')) {
                $image = $request->file('gambar');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('img'), $imageName);
            }

            Produk::create([
                'nama' => $request->nama,
                'harga' => $request->harga,
                'stock' => $request->stock,
                'diskon' => $request->diskon ?? 0,
                'gambar' => $imageName,
            ]);

            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ADMIN SIDE - Show edit form
    public function edit($id)
    {
        $produk = Produk::findOrFail($id);
        return view('admin.products.edit', compact('produk'));
    }

    // ADMIN SIDE - Update product
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|max:100',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // max 5MB
            'harga' => 'required|numeric|gt:0',
            'stock' => 'required|integer|min:0',
            'diskon' => 'nullable|numeric|min:0|max:100',
        ], [
            'nama.required' => 'Nama produk wajib diisi',
            'nama.max' => 'Nama produk maksimal 100 karakter',
            'gambar.image' => 'File harus berupa gambar',
            'gambar.max' => 'Ukuran gambar maksimal 5MB',
            'harga.required' => 'Harga wajib diisi',
            'harga.gt' => 'Harga harus lebih besar dari 0',
            'stock.required' => 'Stock wajib diisi',
            'stock.integer' => 'Stock harus berupa angka bulat',
            'stock.min' => 'Stock minimal 0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validasi gagal! Periksa form Anda.');
        }

        try {
            $produk = Produk::findOrFail($id);

            // Handle image upload
            if ($request->hasFile('gambar')) {
                // Delete old image if exists
                if ($produk->gambar && file_exists(public_path('img/' . $produk->gambar))) {
                    unlink(public_path('img/' . $produk->gambar));
                }

                $image = $request->file('gambar');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('img'), $imageName);
                $produk->gambar = $imageName;
            }

            $produk->update([
                'nama' => $request->nama,
                'harga' => $request->harga,
                'stock' => $request->stock,
                'diskon' => $request->diskon ?? 0,
                'gambar' => $produk->gambar,
            ]);

            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ADMIN SIDE - Delete product
    public function destroy($id)
    {
        try {
            $produk = Produk::findOrFail($id);
            
            // Delete image if exists
            if ($produk->gambar && file_exists(public_path('img/' . $produk->gambar))) {
                unlink(public_path('img/' . $produk->gambar));
            }

            $produk->delete();
            return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
