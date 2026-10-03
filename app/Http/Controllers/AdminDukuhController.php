<?php

namespace App\Http\Controllers;

use App\Models\Dukuh;
use Illuminate\Http\Request;

class AdminDukuhController extends Controller
{
    /**
     * Menampilkan halaman daftar dukuh.
     */
    public function index(Request $request)
{
    $search = $request->get('search');

    $dukuh = Dukuh::query()
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_dukuh', 'like', '%' . $search . '%')
                  ->orWhere('nama_kepala_dukuh', 'like', '%' . $search . '%');
            });
        })
        ->orderBy('nama_dukuh', 'asc')
        ->paginate(10)
        ->withQueryString();

    return view('admin.dukuh.index', compact('dukuh', 'search'));
}

    /**
     * Menampilkan halaman form tambah dukuh.
     */
    public function form()
    {
        return view('admin.dukuh.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_dukuh' => 'required|string|max:255',
            'nama_kepala_dukuh' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',

            'latitude' => [
                'nullable',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'nullable',
                'numeric',
                'between:-180,180',
            ],
        ]);

        Dukuh::create([
            'nama_dukuh' => $request->nama_dukuh,
            'nama_kepala_dukuh' => $request->nama_kepala_dukuh,
            'alamat' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()
            ->route('admin.dukuh')
            ->with('success', 'Data dukuh berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $dukuh = Dukuh::findOrFail($id);

        return view('admin.dukuh.edit', compact('dukuh'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_dukuh' => 'required|string|max:255',
            'nama_kepala_dukuh' => 'nullable|string|max:255',
            'alamat' => 'nullable|string',

            'latitude' => [
                'nullable',
                'numeric',
                'between:-90,90',
            ],

            'longitude' => [
                'nullable',
                'numeric',
                'between:-180,180',
            ],
        ]);

        $dukuh = Dukuh::findOrFail($id);

        $dukuh->update([
            'nama_dukuh' => $request->nama_dukuh,
            'nama_kepala_dukuh' => $request->nama_kepala_dukuh,
            'alamat' => $request->alamat,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()
            ->route('admin.dukuh')
            ->with('success', 'Data dukuh berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $dukuh = Dukuh::findOrFail($id);

        $dukuh->delete();

        return redirect()
            ->route('admin.dukuh')
            ->with('success', 'Data dukuh berhasil dihapus.');
    }
}