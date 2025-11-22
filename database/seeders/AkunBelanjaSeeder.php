<?php

namespace Database\Seeders;

use App\Models\AkunBelanja;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AkunBelanjaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $akunBelanjas = [
            // [
            //     'kode' => '511111',
            //     'nama' => 'Belanja Gaji Pokok',
            //     'deskripsi' => 'Belanja gaji pokok pegawai'
            // ],
            // [
            //     'kode' => '511121',
            //     'nama' => 'Belanja Tunjangan Keluarga',
            //     'deskripsi' => 'Tunjangan keluarga pegawai'
            // ],
            // [
            //     'kode' => '511122',
            //     'nama' => 'Belanja Tunjangan Jabatan',
            //     'deskripsi' => 'Tunjangan jabatan struktural dan fungsional'
            // ],
            // [
            //     'kode' => '511123',
            //     'nama' => 'Belanja Tunjangan Fungsional',
            //     'deskripsi' => 'Tunjangan fungsional pegawai'
            // ],
            // [
            //     'kode' => '511124',
            //     'nama' => 'Belanja Tunjangan PPh',
            //     'deskripsi' => 'Tunjangan PPh Pasal 21'
            // ],
            // [
            //     'kode' => '511129',
            //     'nama' => 'Belanja Uang Lembur',
            //     'deskripsi' => 'Belanja uang lembur pegawai'
            // ],
            // [
            //     'kode' => '521111',
            //     'nama' => 'Belanja Keperluan Perkantoran',
            //     'deskripsi' => 'Belanja alat tulis kantor dan keperluan perkantoran'
            // ],
            // [
            //     'kode' => '521211',
            //     'nama' => 'Belanja Bahan',
            //     'deskripsi' => 'Belanja bahan habis pakai'
            // ],
            // [
            //     'kode' => '522111',
            //     'nama' => 'Belanja Langganan Listrik',
            //     'deskripsi' => 'Pembayaran langganan listrik'
            // ],
            // [
            //     'kode' => '522112',
            //     'nama' => 'Belanja Langganan Telepon',
            //     'deskripsi' => 'Pembayaran langganan telepon dan internet'
            // ],
            // [
            //     'kode' => '522113',
            //     'nama' => 'Belanja Langganan Air',
            //     'deskripsi' => 'Pembayaran langganan air'
            // ],
            // [
            //     'kode' => '523111',
            //     'nama' => 'Belanja Perjalanan Dinas Dalam Daerah',
            //     'deskripsi' => 'Biaya perjalanan dinas dalam daerah'
            // ],
            // [
            //     'kode' => '523112',
            //     'nama' => 'Belanja Perjalanan Dinas Luar Daerah',
            //     'deskripsi' => 'Biaya perjalanan dinas luar daerah'
            // ],
            // [
            //     'kode' => '524111',
            //     'nama' => 'Belanja Pemeliharaan Gedung',
            //     'deskripsi' => 'Pemeliharaan gedung dan bangunan'
            // ],
            // [
            //     'kode' => '532111',
            //     'nama' => 'Belanja Modal Peralatan Komputer',
            //     'deskripsi' => 'Pengadaan peralatan komputer'
            // ]
        ];

        foreach ($akunBelanjas as $akun) {
            AkunBelanja::create($akun);
        }
    }
}
