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
                    <a class="nav-link <?= $current_page == '../pelayanan/index' ? 'active' : '' ?>" aria-current="page" href="../index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'penerimaan/index' ? 'active' : '' ?>" href="../penerimaan/"><i class="fas fa-tag"></i> Penerimaan Sampel Uji</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'penanganan/index' ? 'active' : '' ?>" href="../penanganan/"><i class="fas fa-slack"></i> Penanganan Sampel Uji</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'lhu/index' ? 'active' : '' ?>" href="../lhu/"><i class="fas fa-file"></i> LHU</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'customer/index' ? 'active' : '' ?>" href="../customer/"><i class="fas fa-person"></i> Customer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'jenis_sample/index' ? 'active' : '' ?>" href="../jenis_sample/"><i class="fas fa-fish"></i> Jenis Sample</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'report/index' ? 'active' : '' ?>" href="../report/"><i class="fas fa-print"></i> Laporan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= $current_page == 'users/index' ? 'active' : '' ?>" href="../users/"><i class="fas fa-user"></i> User</a>
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