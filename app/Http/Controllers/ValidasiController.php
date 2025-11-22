<?php

namespace App\Http\Controllers;

use App\Models\AkunBelanja;
use Illuminate\Http\Request;
use Smalot\PdfParser\Parser;

class ValidasiController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Tampilkan halaman upload PDF
     */
    public function index()
    {
        return view('validasi.index');
    }

    /**
     * Proses validasi PDF
     */
    public function proses(Request $request)
    {
        // Validasi input file
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:10240'
        ], [
            'pdf_file.required' => 'File PDF wajib diupload',
            'pdf_file.mimes' => 'File harus berformat PDF',
            'pdf_file.max' => 'Ukuran file maksimal 10MB'
        ]);

        try {
            // Inisialisasi PDF Parser
            $parser = new Parser();
            $pdf = $parser->parseFile($request->file('pdf_file')->path());

            // Ambil semua halaman
            $pages = $pdf->getPages();

            // Ambil halaman terakhir
            $lastPage = end($pages);
            $lastPageText = $lastPage->getText();

            // Extract data dari tabel di halaman terakhir
            $extractedData = $this->extractTableData($lastPageText);

            // Validasi dengan database
            $results = $this->validateData($extractedData);

            // Tampilkan hasil validasi
            return view('validasi.hasil', compact('results', 'extractedData'));

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal memproses PDF: ' . $e->getMessage());
        }
    }

    /**
     * Extract data tabel dari teks PDF
     * 
     * @param string $text
     * @return array
     */
    private function extractTableData($text)
    {
        $data = [];

        // Pattern untuk menangkap kode (6 digit) dan nama
        // Format: 511111 Belanja Gaji Pokok
        preg_match_all('/(\d{6})\s+(.+?)(?=\d{6}|\n\n|$)/s', $text, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            if (isset($match[1]) && isset($match[2])) {
                $kode = trim($match[1]);
                $namaRaw = trim($match[2]);

                // Ambil baris pertama saja dari nama
                $namaLines = preg_split('/[\r\n]+/', $namaRaw);
                $nama = trim($namaLines[0]);

                // Hapus angka/jumlah di akhir nama (biasanya jumlah gaji)
                // Menghapus angka yang dipisah dengan 2+ spasi atau tab dari akhir string
                $nama = preg_replace('/\s{2,}[\d\.,]+\s*$/', '', $nama);

                // Hapus juga angka yang langsung di akhir dengan format seperti: 1.000.000 atau 1,000,000
                $nama = preg_replace('/\s+[\d]{1,3}([.,]\d{3})*([.,]\d+)?\s*$/', '', $nama);

                // Bersihkan whitespace berlebih
                $nama = preg_replace('/\s+/', ' ', $nama);
                $nama = trim($nama);

                // Filter nama yang terlalu panjang atau tidak valid
                if (strlen($nama) > 0 && strlen($nama) < 200) {
                    $data[] = [
                        'kode' => $kode,
                        'nama' => $nama
                    ];
                }
            }
        }

        // Jika pattern di atas tidak berhasil, coba pattern alternatif
        if (empty($data)) {
            // Pattern alternatif untuk format yang berbeda
            $lines = explode("\n", $text);
            foreach ($lines as $line) {
                // Cari baris yang dimulai dengan 6 digit
                if (preg_match('/^(\d{6})\s+(.+)$/', trim($line), $match)) {
                    $kode = trim($match[1]);
                    $nama = trim($match[2]);

                    // Hapus angka/jumlah di akhir nama
                    $nama = preg_replace('/\s{2,}[\d\.,]+\s*$/', '', $nama);
                    $nama = preg_replace('/\s+[\d]{1,3}([.,]\d{3})*([.,]\d+)?\s*$/', '', $nama);

                    // Bersihkan whitespace berlebih
                    $nama = preg_replace('/\s+/', ' ', $nama);
                    $nama = trim($nama);

                    if (strlen($nama) > 0 && strlen($nama) < 200) {
                        $data[] = [
                            'kode' => $kode,
                            'nama' => $nama
                        ];
                    }
                }
            }
        }

        return $data;
    }

    /**
     * Validasi data extracted dengan database
     * 
     * @param array $extractedData
     * @return array
     */
    private function validateData($extractedData)
    {
        $results = [];

        foreach ($extractedData as $item) {
            // Cari akun belanja berdasarkan kode
            $akun = AkunBelanja::where('kode', $item['kode'])->first();

            // Inisialisasi result
            $result = [
                'kode' => $item['kode'],
                'nama_pdf' => $item['nama'],
                'nama_db' => $akun ? $akun->nama : null,
                'status_kode' => $akun ? 'Ditemukan' : 'Tidak Ditemukan',
                'status_nama' => null,
                'keterangan' => null
            ];

            // Jika kode ditemukan, cek kesesuaian nama
            if ($akun) {
                // Normalisasi nama untuk perbandingan
                $namaPdfClean = $this->normalizeText($item['nama']);
                $namaDbClean = $this->normalizeText($akun->nama);

                // Cek apakah nama sama persis
                if ($namaPdfClean === $namaDbClean) {
                    $result['status_nama'] = 'Sesuai';
                    $result['keterangan'] = 'Valid';
                } else {
                    // Cek similarity menggunakan similar_text
                    similar_text($namaPdfClean, $namaDbClean, $percent);

                    if ($percent > 80) {
                        $result['status_nama'] = 'Mirip (' . round($percent) . '%)';
                        $result['keterangan'] = 'Perlu Dicek';
                    } else {
                        $result['status_nama'] = 'Tidak Sesuai';
                        $result['keterangan'] = 'Tidak Valid';
                    }
                }
            } else {
                // Kode tidak ditemukan di database
                $result['status_nama'] = '-';
                $result['keterangan'] = 'Kode Tidak Terdaftar';
            }

            $results[] = $result;
        }

        return $results;
    }

    /**
     * Normalisasi teks untuk perbandingan
     * 
     * @param string $text
     * @return string
     */
    private function normalizeText($text)
    {
        // Convert ke lowercase
        $text = strtolower($text);

        // Hapus whitespace berlebih
        $text = preg_replace('/\s+/', ' ', $text);

        // Trim
        $text = trim($text);

        return $text;
    }
}