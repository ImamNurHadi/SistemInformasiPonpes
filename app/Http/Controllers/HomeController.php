<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Pengurus;
use App\Models\DataKoperasi;
use App\Models\Supplier;
use App\Models\SaldoUtama;
use App\Models\SaldoBelanja;
use App\Models\SaldoTabungan;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Menampilkan landing page / home
     */
    public function index()
    {
        // Mendapatkan jumlah data untuk statistik
        $totalSantri = Santri::count();
        $totalPengurus = Pengurus::count();
        $totalKoperasi = DataKoperasi::count();
        
        // Cek apakah user sudah login
        $isLoggedIn = Auth::check();
        $userSaldo = null;
        
        if ($isLoggedIn) {
            $user = Auth::user();
            // Kita cek jenis user dan saldo yang dimiliki
            $userSaldo = $this->getUserSaldo($user);
        }
        
        // Data berita statis (dalam aplikasi real bisa dari database)
        $berita = [
            [
                'judul' => 'Pembukaan Pendaftaran Santri Baru 2024',
                'tanggal' => '1 Mei 2024',
                'image' => 'img/news/santri-baru.jpg',
                'ringkasan' => 'Pendaftaran santri baru telah dibuka untuk tahun ajaran 2024/2025. Segera daftarkan putra-putri Anda untuk mendapatkan pendidikan terbaik.',
            ],
            [
                'judul' => 'Peringatan Hari Santri Nasional',
                'tanggal' => '22 Oktober 2023',
                'image' => 'img/news/hari-santri.jpg',
                'ringkasan' => 'Pondok pesantren mengadakan kegiatan besar untuk memperingati Hari Santri Nasional dengan berbagai lomba dan kajian.',
            ],
            [
                'judul' => 'Peresmian Gedung Koperasi Baru',
                'tanggal' => '15 Januari 2024',
                'image' => 'img/news/koperasi.jpg',
                'ringkasan' => 'Gedung koperasi baru telah diresmikan untuk mendukung kegiatan ekonomi santri dan masyarakat sekitar pondok pesantren.',
            ],
            [
                'judul' => 'Prestasi Hafalan Quran Santri',
                'tanggal' => '3 Maret 2024',
                'image' => 'img/news/hafalan.jpg',
                'ringkasan' => 'Beberapa santri berhasil menyelesaikan hafalan 30 juz Al-Quran dan mendapatkan penghargaan dari Kementerian Agama.',
            ],
            [
                'judul' => 'Workshop Kewirausahaan Santri',
                'tanggal' => '12 Februari 2024',
                'image' => 'img/news/wirausaha.jpg',
                'ringkasan' => 'Workshop kewirausahaan diadakan untuk membekali santri dengan keterampilan bisnis dan ekonomi kreatif.',
            ],
            [
                'judul' => 'Pengembangan Sistem Informasi Pondok Modern',
                'tanggal' => '20 April 2024',
                'image' => 'img/news/teknologi.jpg',
                'ringkasan' => 'Sistem informasi pondok telah diperbarui untuk meningkatkan efisiensi pengelolaan data santri dan keuangan.',
            ],
        ];
        
        // Data keunggulan pondok
        $keunggulan = [
            [
                'icon' => 'bi-book',
                'judul' => 'Kurikulum Terintegrasi',
                'deskripsi' => 'Menggabungkan pendidikan agama dengan kurikulum nasional untuk kompetensi yang lengkap'
            ],
            [
                'icon' => 'bi-people',
                'judul' => 'Pengajar Berkualitas',
                'deskripsi' => 'Diasuh oleh ustadz dan ustadzah lulusan dalam dan luar negeri yang berpengalaman'
            ],
            [
                'icon' => 'bi-building',
                'judul' => 'Fasilitas Modern',
                'deskripsi' => 'Dilengkapi dengan asrama nyaman, perpustakaan, laboratorium, dan ruang belajar modern'
            ],
            [
                'icon' => 'bi-globe',
                'judul' => 'Program Internasional',
                'deskripsi' => 'Memberikan kesempatan pertukaran santri dan kerjasama dengan lembaga pendidikan luar negeri'
            ],
        ];
        
        return view('home', compact('totalSantri', 'totalPengurus', 'totalKoperasi', 'berita', 'keunggulan', 'isLoggedIn', 'userSaldo'));
    }

    /**
     * Mendapatkan saldo user berdasarkan jenis user
     */
    private function getUserSaldo($user)
    {
        $saldo = [];
        
        // Cek berdasarkan role user
        if ($user->hasRole('santri')) {
            $santri = Santri::where('user_id', $user->id)->first();
            if ($santri) {
                // Cek saldo utama
                $saldoUtama = SaldoUtama::where('santri_id', $santri->id)->first();
                if ($saldoUtama) {
                    $saldo['utama'] = $saldoUtama->jumlah_saldo;
                }
                
                // Cek saldo belanja
                $saldoBelanja = SaldoBelanja::where('santri_id', $santri->id)->first();
                if ($saldoBelanja) {
                    $saldo['belanja'] = $saldoBelanja->jumlah_saldo;
                }
                
                // Cek saldo tabungan
                $saldoTabungan = SaldoTabungan::where('santri_id', $santri->id)->first();
                if ($saldoTabungan) {
                    $saldo['tabungan'] = $saldoTabungan->jumlah_saldo;
                }
            }
        } elseif ($user->hasRole('supplier')) {
            $supplier = Supplier::where('user_id', $user->id)->first();
            if ($supplier) {
                $saldo['utama'] = $supplier->saldo;
            }
        } elseif ($user->hasRole('koperasi')) {
            $koperasi = DataKoperasi::where('user_id', $user->id)->first();
            if ($koperasi) {
                $saldo['utama'] = $koperasi->saldo;
            }
        } elseif ($user->hasRole('pengurus')) {
            $pengurus = Pengurus::where('user_id', $user->id)->first();
            if ($pengurus) {
                $saldo['utama'] = $pengurus->saldo;
            }
        }
        
        return $saldo;
    }
} 