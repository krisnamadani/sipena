<?php

namespace App\Http\Controllers;

use App\Models\AkunBelanja;
use Illuminate\Http\Request;
use App\Imports\AkunBelanjaImport;
use Maatwebsite\Excel\Facades\Excel;

class AkunBelanjaController extends Controller
{
    public function index()
    {
        $akunBelanjas = AkunBelanja::latest()->paginate(10);
        return view('akun-belanja.index', compact('akunBelanjas'));
    }

    public function create()
    {
        return view('akun-belanja.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:20|unique:akun_belanjas,kode',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ], [
            'kode.required' => 'Kode akun belanja wajib diisi',
            'kode.unique' => 'Kode akun belanja sudah digunakan',
            'nama.required' => 'Nama akun belanja wajib diisi'
        ]);

        AkunBelanja::create($validated);

        return redirect()->route('akun-belanja.index')
            ->with('success', 'Data akun belanja berhasil ditambahkan');
    }

    public function show(AkunBelanja $akunBelanja)
    {
        return view('akun-belanja.show', compact('akunBelanja'));
    }

    public function edit(AkunBelanja $akunBelanja)
    {
        return view('akun-belanja.edit', compact('akunBelanja'));
    }

    public function update(Request $request, AkunBelanja $akunBelanja)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:20|unique:akun_belanjas,kode,' . $akunBelanja->id,
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string'
        ], [
            'kode.required' => 'Kode akun belanja wajib diisi',
            'kode.unique' => 'Kode akun belanja sudah digunakan',
            'nama.required' => 'Nama akun belanja wajib diisi'
        ]);

        $akunBelanja->update($validated);

        return redirect()->route('akun-belanja.index')
            ->with('success', 'Data akun belanja berhasil diperbarui');
    }

    public function destroy(AkunBelanja $akunBelanja)
    {
        $akunBelanja->delete();

        return redirect()->route('akun-belanja.index')
            ->with('success', 'Data akun belanja berhasil dihapus');
    }

    /**
     * Show import form
     */
    public function importForm()
    {
        return view('akun-belanja.import');
    }

    /**
     * Process import Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:2048'
        ], [
            'file.required' => 'File Excel wajib diupload',
            'file.mimes' => 'File harus berformat Excel (xlsx, xls) atau CSV',
            'file.max' => 'Ukuran file maksimal 2MB'
        ]);

        try {
            $import = new AkunBelanjaImport();
            Excel::import($import, $request->file('file'));

            $successCount = $import->getSuccessCount();
            $skippedCount = $import->getSkippedCount();
            $failures = collect($import->failures());
            $errorCount = $failures->count();

            // Jika semua gagal, kemungkinan masalah format
            if ($successCount == 0 && $errorCount > 0) {
                $errorMessages = $failures->take(5)->map(function ($failure) {
                    return "Baris {$failure->row()}: " . implode(', ', $failure->errors());
                })->implode('<br>');

                return redirect()->back()
                    ->with('error', 'Tidak ada data yang berhasil diimport. Periksa format file Excel Anda.')
                    ->with('error_detail', $errorMessages)
                    ->with('failures', $failures);
            }

            $message = "Import selesai! ";
            $message .= "Berhasil: {$successCount}, ";
            $message .= "Dilewati (duplikat/kosong): {$skippedCount}";

            if ($errorCount > 0) {
                $message .= ", Gagal validasi: {$errorCount}";
            }

            if ($failures->isNotEmpty()) {
                return redirect()->route('akun-belanja.index')
                    ->with('warning', $message)
                    ->with('failures', $failures);
            }

            return redirect()->route('akun-belanja.index')
                ->with('success', $message);

        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = collect($e->failures());

            $errorMessages = $failures->take(5)->map(function ($failure) {
                return "Baris {$failure->row()}: " . implode(', ', $failure->errors());
            })->implode('<br>');

            return redirect()->back()
                ->with('error', 'Terdapat kesalahan validasi pada file Excel')
                ->with('error_detail', $errorMessages)
                ->with('failures', $failures);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengimport file: ' . $e->getMessage());
        }
    }
}
