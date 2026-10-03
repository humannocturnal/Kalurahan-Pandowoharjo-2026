<?php

namespace App\Http\Controllers;

use App\Models\AgendaFoto;
use Illuminate\Support\Facades\Storage;
use App\Models\Agenda;
use App\Models\Dukuh;
use Illuminate\Http\Request;

class AdminAgendaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');

        $agenda = Agenda::with('dukuh')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {

                    $q->where('judul', 'like', '%' . $search . '%')
                      ->orWhere('lokasi', 'like', '%' . $search . '%')
                      ->orWhereHas('dukuh', function ($dukuhQuery) use ($search) {
                          $dukuhQuery->where(
                              'nama_dukuh',
                              'like',
                              '%' . $search . '%'
                          );
                      });

                });
            })
            ->orderBy('tanggal', 'desc')
            ->paginate(5)
            ->withQueryString();

        return view(
            'admin.agenda.index',
            compact('agenda', 'search')
        );
    }

    public function form()
    {
        $dukuh = Dukuh::orderBy('nama_dukuh', 'asc')->get();

        return view(
            'admin.agenda.form',
            compact('dukuh')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'dukuh_id' => 'required|exists:dukuh,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'lokasi' => 'required|string|max:255',
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
            'status' => 'required|in:direncanakan,selesai,dibatalkan',

            'fotos' => 'nullable|array',
            'fotos.*' => 'file|mimes:jpg,jpeg,png|max:5120',
        ]);

        $agenda = Agenda::create([
            'dukuh_id' => $request->dukuh_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'lokasi' => $request->lokasi,
            'status' => $request->status,
        ]);

        if ($request->hasFile('fotos')) {

            foreach ($request->file('fotos') as $foto) {

                $path = $foto->store('agenda', 'public');

                AgendaFoto::create([
                    'agenda_id' => $agenda->id,
                    'foto' => $path,
                    'keterangan' => null,
                ]);
            }
        }

        return redirect()
            ->route('admin.agenda')
            ->with('success', 'Data agenda berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $agenda = Agenda::findOrFail($id);

        $dukuh = Dukuh::orderBy('nama_dukuh', 'asc')->get();

        return view(
            'admin.agenda.edit',
            compact('agenda', 'dukuh')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'dukuh_id' => 'required|exists:dukuh,id',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
            'lokasi' => 'required|string|max:255',
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
            'status' => 'required|in:direncanakan,selesai,dibatalkan',

            'fotos' => 'nullable|array',
            'fotos.*' => 'file|mimes:jpg,jpeg,png|max:10240',
        ]);

        $agenda = Agenda::findOrFail($id);

        $agenda->update([
            'dukuh_id' => $request->dukuh_id,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'tanggal' => $request->tanggal,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'lokasi' => $request->lokasi,
            'status' => $request->status,
        ]);

        if ($request->hasFile('fotos')) {

            foreach ($request->file('fotos') as $foto) {

                $path = $foto->store('agenda', 'public');

                AgendaFoto::create([
                    'agenda_id' => $agenda->id,
                    'foto' => $path,
                    'keterangan' => null,
                ]);
            }
        }

        return redirect()
            ->route('admin.agenda')
            ->with('success', 'Data agenda berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $agenda = Agenda::findOrFail($id);

        $agenda->delete();

        return redirect()
            ->route('admin.agenda')
            ->with('success', 'Data agenda berhasil dihapus.');
    }

    public function destroyFoto($agendaId, $fotoId)
    {
        $foto = AgendaFoto::where('agenda_id', $agendaId)
            ->where('id', $fotoId)
            ->firstOrFail();

        // Hapus file dari storage
        if ($foto->foto && Storage::disk('public')->exists($foto->foto)) {
            Storage::disk('public')->delete($foto->foto);
        }

        // Hapus data dari database
        $foto->delete();

        return redirect()
            ->route('admin.agenda.show', $agendaId)
            ->with('success', 'Foto agenda berhasil dihapus.');
    }

    public function show($id)
    {
        $agenda = Agenda::with(['dukuh', 'fotos'])
            ->findOrFail($id);

        return view('admin.agenda.show', compact('agenda'));
    }
}