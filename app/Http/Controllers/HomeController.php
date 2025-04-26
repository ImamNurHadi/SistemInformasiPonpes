<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Santri;
use App\Models\Pengurus;
use App\Models\DataKoperasi;
use App\Models\Berita;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Menampilkan landing page / home
     */
    public function index()
    {
        try {
            // Mendapatkan jumlah data untuk statistik - dengan penanganan error
            $totalSantri = Santri::count() ?? 0;
            $totalPengurus = Pengurus::count() ?? 0;
            $totalKoperasi = DataKoperasi::count() ?? 0;
        } catch (\Exception $e) {
            // Jika ada error (misalnya tabel belum ada), set nilai default
            $totalSantri = 0;
            $totalPengurus = 0;
            $totalKoperasi = 0;
        }
        
        // Cek apakah user sudah login
        $isLoggedIn = Auth::check();
        $userSaldo = null;
        
        if ($isLoggedIn) {
            $user = Auth::user();
            // Kita cek jenis user dan saldo yang dimiliki jika diperlukan
            // $userSaldo = $this->getUserSaldo($user);
        }
        
        // Data berita statis (untuk sementara)
        $berita = collect([
            [
                'judul' => 'Pembukaan Pendaftaran Santri Baru 2024',
                'tanggal' => '1 Mei 2024',
                'image' => 'img/news/santri-baru.jpg',
                'ringkasan' => 'Pendaftaran santri baru telah dibuka untuk tahun ajaran 2024/2025. Segera daftarkan putra-putri Anda untuk mendapatkan pendidikan terbaik.',
                'id' => 1,
                'slug' => 'pembukaan-pendaftaran-santri-baru-2024'
            ],
            [
                'judul' => 'Peringatan Hari Santri Nasional',
                'tanggal' => '22 Oktober 2023',
                'image' => 'img/news/hari-santri.jpg',
                'ringkasan' => 'Pondok pesantren mengadakan kegiatan besar untuk memperingati Hari Santri Nasional dengan berbagai lomba dan kajian.',
                'id' => 2,
                'slug' => 'peringatan-hari-santri-nasional'
            ],
            [
                'judul' => 'Peresmian Gedung Koperasi Baru',
                'tanggal' => '15 Januari 2024',
                'image' => 'img/news/koperasi.jpg',
                'ringkasan' => 'Gedung koperasi baru telah diresmikan untuk mendukung kegiatan ekonomi santri dan masyarakat sekitar pondok pesantren.',
                'id' => 3,
                'slug' => 'peresmian-gedung-koperasi-baru'
            ],
            [
                'judul' => 'Prestasi Hafalan Quran Santri',
                'tanggal' => '3 Maret 2024',
                'image' => 'img/news/hafalan.jpg',
                'ringkasan' => 'Beberapa santri berhasil menyelesaikan hafalan 30 juz Al-Quran dan mendapatkan penghargaan dari Kementerian Agama.',
                'id' => 4,
                'slug' => 'prestasi-hafalan-quran-santri'
            ],
            [
                'judul' => 'Workshop Kewirausahaan Santri',
                'tanggal' => '12 Februari 2024',
                'image' => 'img/news/wirausaha.jpg',
                'ringkasan' => 'Workshop kewirausahaan diadakan untuk membekali santri dengan keterampilan bisnis dan ekonomi kreatif.',
                'id' => 5,
                'slug' => 'workshop-kewirausahaan-santri'
            ],
            [
                'judul' => 'Pengembangan Sistem Informasi Pondok Modern',
                'tanggal' => '20 April 2024',
                'image' => 'img/news/teknologi.jpg',
                'ringkasan' => 'Sistem informasi pondok telah diperbarui untuk meningkatkan efisiensi pengelolaan data santri dan keuangan.',
                'id' => 6,
                'slug' => 'pengembangan-sistem-informasi-pondok-modern'
            ],
        ]);
        
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
        
        return view('welcome', compact('totalSantri', 'totalPengurus', 'totalKoperasi', 'berita', 'keunggulan', 'isLoggedIn', 'userSaldo'));
    }

    /**
     * Mendapatkan saldo user berdasarkan jenis user
     */
    private function getUserSaldo($user)
    {
        // Fungsi ini tidak digunakan untuk sementara
        return [];
    }
} 