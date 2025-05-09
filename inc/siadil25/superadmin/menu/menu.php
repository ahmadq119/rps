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
                    <a class="nav-link <?= $current_page == '../superadmin/index' ? 'active' : '' ?>" aria-current="page" href="../index.php">Home</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Referensi
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item <?= $current_page == 'pegawai/index' ? 'active' : '' ?>" href="../pegawai/">Pegawai</a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= $current_page == 'customer/index' ? 'active' : '' ?>" href="../customer/">Customer</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item <?= $current_page == 'kondisi_sample/index' ? 'active' : '' ?>" href="../kondisi_sample/">Kondisi Sample</a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= $current_page == 'target_pengujian/index' ? 'active' : '' ?>" href="../target_pengujian/">Target Pengujian</a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= $current_page == 'satuan/index' ? 'active' : '' ?>" href="../satuan/">Satuan Sample</a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= $current_page == 'kelompok/index' ? 'active' : '' ?>" href="../kelompok/">Kelompok Sample</a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= $current_page == 'jenis_sample/index' ? 'active' : '' ?>" href="../jenis_sample/">Jenis Sample</a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= $current_page == 'organ_target/index' ? 'active' : '' ?>" href="../organ_target/">Organ Target</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item <?= $current_page == 'users/index' ? 'active' : '' ?>" href="../users/">Users</a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <!-- Tambahkan item menu logout di posisi kanan -->
            <ul class="navbar-nav ms-auto">
                <div id="app_logout">
                    <li class="nav-item">
                        <a class="nav-link text-light" href="#" @click="logout"><i class="fa fa-gear"></i> Logout</a>
                    </li>
                </div>
            </ul>
        </div>
    </div>
</nav>