<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        //proses ambil data
        $medicine = Medicine::orderBy('name', 'ASC')->simplePaginate(5);
        //memanggil html yang ada di folder resources/views/medicine/index.blade.php
        //compact: mengirim data ke blade
        return view('medicine.index' , compact('medicine'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('medicine.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|min:3',
            'type' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        Medicine::create([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->back()->with('success', 'Berhasil menambahkan data obat!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $medicine = Medicine::find($id);
        return response()->json($medicine, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $medicine = Medicine::find($id);

        return view('medicine.edit', compact('medicine'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate
        ([
            'name' => 'required|min:3',
            'type' => 'required',
            'price' => 'required|numeric',
        ]);

        Medicine::where('id', $id)->update
        ([
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            
        ]);

        return redirect()->route('medicine.data')->with('success', 'Berhasil mengubah data obat!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //cari dan hapus data
        Medicine::where('id', $id)->delete();
        return redirect()->back()->with('deleted', 'Berhasil menghapus data!');
    }

    public function stockData()
    {
        $medicines = Medicine::orderBy('stock', 'ASC')->simplePaginate(5);
        return view('medicine.stock', compact('medicines'));
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|numeric',
        ],[
            'stock.required' => 'Input stock harus diisi!',
        ]);

        $medicineBefore = Medicine::where('id', $id)->first();
        if ($request->stock <= $medicineBefore['stock']){
            return response()->json(['message' => 'Stock tidak boleh lebih/sama dengan stock sebelumnya!'], 400);
        }
        $medicineBefore->update(['stock'=> $request->stock]);
        return response()->json('berhasil',200);
    }
}
