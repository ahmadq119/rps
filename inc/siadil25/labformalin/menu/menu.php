<?php
// Menentukan halaman aktif berdasarkan nama file yang sedang diakses
//$current_page = basename($_SERVER['PHP_SELF'], ".php");

// Menentukan halaman aktif berdasarkan direktori dan nama file yang sedang diakses
$current_page = basename(dirname($_SERVER['PHP_SELF'])) . '/' . basename($_SERVER['PHP_SELF'], ".php");
?>

<nav class="navbar navbar-expand-lg warna-nav fixed-top" data-bs-theme="dark">
    <!--nav class="navbar bg-dark border-bottom border-body" data-bs-theme="dark"-->
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><i class="fas fa-home text-light"></i> SIADIL VERSI 25</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 nav justify-content-center">
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == '../labmikro/index' ? 'active' : '' ?>" aria-current="page" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'penerimaan/index' ? 'active' : '' ?>" href="../penerimaan/"><i class="fas fa-fish"></i> Penerimaan Sample</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'hasil/index' ? 'active' : '' ?>" href="../hasil/"><i class="fas fa-list"></i> Hasil Pengujian</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'bahan/index' ? 'active' : '' ?>" href="../bahan/"><i class="fas fa-flask"></i> Permintaan Bahan</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-list"></i> Rekaman
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item <?= $current_page == 'rekaman_rh_temperatur/index' ? 'active' : '' ?>" href="../rekaman_rh_temperatur/">RH & Temp Ruang Pengujian</a></li>
                        <li><a class="dropdown-item <?= $current_page == 'rekaman_uv_ruangan/index' ? 'active' : '' ?>" href="../rekaman_uv_ruangan/">Rekaman UV Ruang Pengujian</a></li>
                        <li><a class="dropdown-item <?= $current_page == 'rekaman_uv_alat/index' ? 'active' : '' ?>" href="../rekaman_uv_alat/">Rekaman UV Alat Pengujian</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item <?= $current_page == 'persiapan_tempat_kerja/index' ? 'active' : '' ?>" href="../persiapan_tempat_kerja/">Persiapan Tempat Kerja</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'report/index' ? 'active' : '' ?>" href="../report/"><i class="fas fa-print"></i> Laporan</a>
                </li>
            </ul>
            <!-- Tambahkan item menu logout di posisi kanan -->
            <ul class="navbar-nav ms-auto">
                <div id="app_logout">
                    <li class="nav-item">
                        <button class="btn logout-btn" @click="logout"><i class="fas fa-sign-out-alt"></i> Logout</button>
                    </li>
                </div>
            </ul>
        </div>
    </div>
</nav>