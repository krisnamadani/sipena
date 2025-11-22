<?php

namespace App\Imports;

use App\Models\AkunBelanja;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class AkunBelanjaImport implements
    ToModel,
    WithHeadingRow,
    SkipsOnError,
    SkipsOnFailure,
    WithBatchInserts,
    WithChunkReading
{
    use Importable, SkipsErrors, SkipsFailures;

    private $successCount = 0;
    private $skippedCount = 0;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Normalize keys to handle different header formats
        $row = array_change_key_case($row, CASE_LOWER);

        // Get kode - try different possible column names and convert to string
        $kode = $row['kode'] ?? $row['code'] ?? $row['kode_akun'] ?? null;

        // Get nama - try different possible column names  
        $nama = $row['nama'] ?? $row['name'] ?? $row['nama_akun'] ?? null;

        // Get deskripsi
        $deskripsi = $row['deskripsi'] ?? $row['description'] ?? $row['keterangan'] ?? null;

        // Convert kode to string (Excel often reads numbers as numeric)
        if ($kode !== null) {
            // Remove any decimals (.0) that Excel might add
            if (is_numeric($kode)) {
                $kode = strval((int) $kode);
            } else {
                $kode = strval($kode);
            }
        }

        // Convert nama to string
        if ($nama !== null) {
            $nama = strval($nama);
        }

        // Convert deskripsi to string
        if ($deskripsi !== null) {
            $deskripsi = strval($deskripsi);
        }

        // Skip if kode or nama is empty
        if (empty($kode) || empty($nama)) {
            $this->skippedCount++;
            return null;
        }

        // Clean the data
        $kode = trim($kode);
        $nama = trim($nama);
        $deskripsi = $deskripsi ? trim($deskripsi) : null;

        // Validate length
        if (strlen($kode) > 20) {
            $this->skippedCount++;
            return null;
        }

        if (strlen($nama) > 255) {
            $this->skippedCount++;
            return null;
        }

        // Check if kode already exists
        $exists = AkunBelanja::where('kode', $kode)->exists();

        if ($exists) {
            $this->skippedCount++;
            return null;
        }

        $this->successCount++;

        return new AkunBelanja([
            'kode' => $kode,
            'nama' => $nama,
            'deskripsi' => $deskripsi,
        ]);
    }

    /**
     * Batch insert size
     */
    public function batchSize(): int
    {
        return 100;
    }

    /**
     * Chunk reading size
     */
    public function chunkSize(): int
    {
        return 100;
    }

    /**
     * Get success count
     */
    public function getSuccessCount(): int
    {
        return $this->successCount;
    }

    /**
     * Get skipped count
     */
    public function getSkippedCount(): int
    {
        return $this->skippedCount;
    }
}