<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Models\Dukuh;
use App\Models\Kegiatan;
use App\Models\KegiatanFoto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class AdminKegiatanController extends Controller
{
    // ==========================================
    // INDEX
    // ==========================================

    public function index(Request $request)
    {
        $search = trim($request->input('search', ''));

        $kegiatan = Kegiatan::with(['dukuh', 'agenda'])
            ->when($search !== '', function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('judul', 'like', "%{$search}%")
                        ->orWhere('lokasi', 'like', "%{$search}%")
                        ->orWhereHas('dukuh', function ($dukuhQuery) use ($search) {

                            $dukuhQuery->where(
                                'nama_dukuh',
                                'like',
                                "%{$search}%"
                            );

                        });

                });

            })
            ->orderBy('tanggal', 'desc')
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view(
            'admin.kegiatan.index',
            compact('kegiatan', 'search')
        );
    }


    // ==========================================
    // FORM TAMBAH
    // ==========================================

    public function form()
    {
        $dukuh = Dukuh::orderBy('nama_dukuh')->get();

        $agenda = Agenda::orderBy('tanggal', 'desc')->get();

        return view(
            'admin.kegiatan.form',
            compact('dukuh', 'agenda')
        );
    }


    // ==========================================
    // SIMPAN KEGIATAN
    // ==========================================

    public function store(Request $request)
    {
        $validated = $request->validate(
            $this->validationRules($request)
        );

        // Ubah agenda_id kosong menjadi null.

        $validated['agenda_id'] =
            $validated['agenda_id'] ?: null;


        $paths = [];

        try {

            DB::transaction(function () use (
                $request,
                $validated,
                &$paths
            ) {

                // ==================================
                // 1. SIMPAN KEGIATAN
                // ==================================

                $kegiatan = Kegiatan::create(
                    collect($validated)
                        ->except(['fotos'])
                        ->all()
                );


                // ==================================
                // 2. SIMPAN FOTO
                // ==================================

                foreach ($request->file('fotos', []) as $foto) {

                    $path = $foto->store(
                        'kegiatan',
                        'public'
                    );

                    if (!$path) {

                        throw new \RuntimeException(
                            'Gagal menyimpan foto kegiatan.'
                        );

                    }

                    $paths[] = $path;


                    $kegiatan->fotos()->create([
                        'foto' => $path,
                        'keterangan' => null,
                    ]);

                }


                // ==================================
                // 3. UPDATE STATUS AGENDA
                // ==================================

                if ($validated['agenda_id']) {

                    Agenda::where(
                        'id',
                        $validated['agenda_id']
                    )->update([
                        'status' => 'selesai'
                    ]);

                }

            });

        } catch (\Throwable $e) {

            // Hapus file baru apabila
            // proses database gagal.

            Storage::disk('public')->delete($paths);

            throw $e;

        }


        return redirect()
            ->route('admin.kegiatan')
            ->with(
                'success',
                'Kegiatan berhasil disimpan.'
            );
    }


    // ==========================================
    // DETAIL KEGIATAN
    // ==========================================

    public function show($id)
    {
        $kegiatan = Kegiatan::with([
            'dukuh',
            'agenda',
            'fotos'
        ])->findOrFail($id);

        return view(
            'admin.kegiatan.show',
            compact('kegiatan')
        );
    }


    // ==========================================
    // FORM EDIT
    // ==========================================

    public function edit($id)
    {
        $kegiatan = Kegiatan::with('fotos')
            ->findOrFail($id);

        $dukuh = Dukuh::orderBy('nama_dukuh')->get();

        $agenda = Agenda::orderBy('tanggal', 'desc')->get();

        return view(
            'admin.kegiatan.edit',
            compact('kegiatan', 'dukuh', 'agenda')
        );
    }


    // ==========================================
    // UPDATE KEGIATAN
    // ==========================================

    public function update(Request $request, $id)
    {
        $kegiatan = Kegiatan::findOrFail($id);

        $validated = $request->validate(
            $this->validationRules($request)
        );

        $paths = [];

        try {

            DB::transaction(function () use (
                $kegiatan,
                $request,
                $validated,
                &$paths
            ) {

                $kegiatan->update(
                    collect($validated)
                        ->except(['fotos'])
                        ->all()
                );

                foreach ($request->file('fotos', []) as $foto) {

                    $path = $foto->store('kegiatan', 'public');

                    if (!$path) {
                        throw new \RuntimeException('Gagal menyimpan foto.');
                    }

                    $paths[] = $path;

                    $kegiatan->fotos()->create([
                        'foto' => $path,
                    ]);
                }

            });

        } catch (\Throwable $e) {

            Storage::disk('public')->delete($paths);

            throw $e;
        }

        return redirect()
            ->route('admin.kegiatan.show', $kegiatan->id)
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }


    // ==========================================
    // DELETE KEGIATAN
    // ==========================================

    public function destroy($id)
    {
        $kegiatan = Kegiatan::with('fotos')
            ->findOrFail($id);

        $paths = $kegiatan->fotos
            ->pluck('foto')
            ->filter()
            ->all();

        DB::transaction(function () use ($kegiatan) {

            $kegiatan->fotos()->delete();

            $kegiatan->delete();

        });

        Storage::disk('public')->delete($paths);

        return redirect()
            ->route('admin.kegiatan')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }


    // ==========================================
    // DELETE FOTO SATU PER SATU
    // ==========================================

    public function destroyFoto($kegiatanId, $fotoId)
    {
        $foto = KegiatanFoto::where('kegiatan_id', $kegiatanId)
            ->findOrFail($fotoId);

        $path = $foto->foto;

        $foto->delete();

        if ($path) {
            Storage::disk('public')->delete($path);
        }

        return redirect()
            ->route('admin.kegiatan.show', $kegiatanId)
            ->with('success', 'Foto berhasil dihapus.');
    }


    // ==========================================
    // VALIDASI
    // ==========================================

    private function validationRules(Request $request): array
    {
        return [
            'dukuh_id' => [
                'required',
                'exists:dukuh,id'
            ],

            'agenda_id' => [
                'nullable',
                Rule::exists('agenda', 'id')
                    ->where('dukuh_id', $request->input('dukuh_id'))
            ],

            'judul' => [
                'required',
                'string',
                'max:255'
            ],

            'deskripsi' => [
                'nullable',
                'string'
            ],

            'tanggal' => [
                'required',
                'date'
            ],

            'waktu_mulai' => [
                'nullable',
                'date_format:H:i'
            ],

            'waktu_selesai' => [
                'nullable',
                'date_format:H:i',
                'after_or_equal:waktu_mulai'
            ],

            'lokasi' => [
                'nullable',
                'string',
                'max:255'
            ],

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

            'fotos' => [
                'nullable',
                'array'
            ],

            'fotos.*' => [
                'file',
                'mimes:jpg,jpeg,png',
                'max:5120'
            ]
        ];
    }

    // ==========================================
    // FORM REALISASI AGENDA
    // ==========================================

    public function createFromAgenda($id)
    {
        $sourceAgenda = Agenda::with('dukuh')
            ->findOrFail($id);

        // Hanya agenda yang masih direncanakan
        // yang dapat direalisasikan.

        if ($sourceAgenda->status !== 'direncanakan') {

            return redirect()
                ->route('admin.agenda.show', $sourceAgenda->id)
                ->with(
                    'error',
                    'Agenda ini tidak dapat direalisasikan.'
                );

        }


        // Data dropdown kegiatan.

        $dukuh = Dukuh::orderBy('nama_dukuh')
            ->get();

        $agenda = Agenda::orderBy('tanggal', 'desc')
            ->get();


        return view(
            'admin.kegiatan.form',
            compact(
                'sourceAgenda',
                'dukuh',
                'agenda'
            )
        );
    }

    // ==========================================
    // SIMPAN REALISASI AGENDA
    // ==========================================

    public function storeFromAgenda(Request $request, $id)
    {
        $sourceAgenda = Agenda::findOrFail($id);

        if ($sourceAgenda->status !== 'direncanakan') {

            return redirect()
                ->route('admin.agenda.show', $sourceAgenda->id)
                ->with(
                    'error',
                    'Agenda ini sudah selesai atau dibatalkan.'
                );

        }


        // Agenda ID dan Dukuh ID ditentukan oleh
        // sistem, bukan oleh input pengguna.

        $request->merge([
            'agenda_id' => $sourceAgenda->id,
            'dukuh_id' => $sourceAgenda->dukuh_id,
        ]);


        // Menggunakan proses penyimpanan
        // kegiatan yang sudah ada.

        return $this->store($request);
    }
}