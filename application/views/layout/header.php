<!DOCTYPE html>
<html lang="en">
<head>
<title><?= $title_web;?> &mdash; TAMAN AIR</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link rel="stylesheet" href="<?= base_url('assets/plugins/font-awesome-6.5.2/css/all.css');?>" />
    <!-- <link rel="stylesheet" href="<?= base_url('assets/plugins/font-awesome-4.7.0/css/font-awesome.min.css');?>" /> -->
    <link rel="stylesheet" type="text/css" href="<?= base_url('assets/plugins/magnific/magnific-popup.css');?>">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css?v='.time());?>" />
    <link rel="stylesheet" href="<?= base_url('assets/plugins/sweetalert2/sweetalert2.css');?>">
    <!-- Optional JavaScript -->
    <!-- DATATABLES BS 4-->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap4.min.css');?>" />
    <link rel="stylesheet" href="<?= base_url('assets/plugins/datatables/responsive.bootstrap4.min.css');?>" />
    <!-- jQuery -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="<?= base_url('assets/js/jquery-3.3.1.min.js');?>"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/popper.min.js');?>"></script>
    <script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.min.js');?>"></script>
    <script type="text/javascript" src="<?= base_url('assets/plugins/magnific/jquery.magnific-popup.js');?>"></script>
    <script src="<?= base_url('assets/plugins/chart.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.twbsPagination.min.js');?>"></script>
    <script src="<?= base_url('assets/plugins/sweetalert2/sweetalert2.all.min.js');?>"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }


        .sidebar {
            position: fixed;
            background-color: white;
            min-height: 100vh;
            width: 48px;
            overflow: hidden;
            transition: width 0.3s ease;
            z-index: 1000; /* Tambahkan z-index yang tinggi */
  
        }

        .sidebar:hover {
            width: 250px;
            background-color: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }

        .sidebar-container {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding-top: 0.5rem;
            padding-bottom: 1.5rem;
            height: 100%;
        }

        .nav {
            /* margin-top: 1rem; */
            display: flex;
            flex-direction: column;
            /* gap: 0.5rem; */
            text-align: center;
            font-size: 0.625rem;
            font-weight: 600;
            color: white;
        }

        .nav-item {
            min-width: max-content;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 20px 0px 20px 16px;
            color: black;
            font-size: 15px;
        }

        .sidebar .nav-link:hover, .sidebar .nav-link:focus {
            color: white;
            background-color: #71b865;
        }

        .sidebar:hover .sidebar.nav-link span {
            display: inline;
        }

        .sidebar .nav-item.dropdown {
            position: relative;
        }

        .sidebar .dropdown-menu {
            display: none;
            position: relative;
            left: 0;
            top: 0;
            min-width: 100%;
            z-index: 1001;
        }

        .sidebar .dropdown-menu.show {
            display: block;
        }

        .sidebar .nav-item {
            position: relative;
        }

        .sidebar .dropdown-menu {
            position: relative;
            left: 0;
            top: 0;
            width: 100%;
            padding: 0;
            border: none;
        }

        .sidebar .dropdown-menu .dropdown-item {
            padding-left: 3rem;
            background-color: transparent;
            color: black;
        }

        .dropdown-menu .dropdown-item {
            padding-left: 1rem;
            background-color: transparent;
            color: black;
        }

        .sidebar .nav-link.active {
            color: white;
            background-color: #71b865;
        }

        .sidebar .dropdown-toggle.active {
            color: white;
            background-color: #71b865;
        }

        
    </style>
</head>
<body>
<!-- <div id="header"> -->
        <nav class="navbar fixed-top navbar-expand-lg active py-1">
            <div class="container-fluid">
                <a class="navbar-brand" href="<?= base_url('home');?>">TAMAN <b>AIR</b></a>

                <?php $profil = $this->db->get_where('login', ['id' => $this->session->userdata('ses_id')])->row(); ?>

                    <ul class="navbar-nav ml-4 mr-4">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user-circle"></i> <?= $profil->nama_user;?>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownId">

                                <?php if($this->session->userdata('ses_level') == 'Admin'){?>
                                <a class="dropdown-item" href="<?= base_url('info');?>">
                                    Pengaturan</a>
                                <div class="dropdown-divider"></div>
                                <?php }?>

                                <a class="dropdown-item" href="<?= base_url('user');?>">
                                    Profil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('login/logout');?>">
                                    Keluar</a>
                            </div>
                        </li>
                    </ul>
        </nav>
    <aside class="sidebar">
        <div class="sidebar-container">
            <div>
                <!-- <div class="logo-container">
                    <img src="logo.png" class="logo" alt="Logo" />
                </div> -->
                <div class="nav">

                    <div class="nav-item mt-3">
                        <?php if($this->session->userdata('ses_level') == 'Admin'){?>
                            <div class="nav-item active">
                                <a class="nav-link" href="<?= base_url('home');?>"><i class="fas fa-grip fa-lg "> </i>   HOME <span
                                        class="sr-only">(current)</span></a>
                            </div>
                        <?php }?>
                    </div>
                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false"><i class="fas fa-list fa-lg"></i> DATA MASTER </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownId">

                            <?php if($this->session->userdata('ses_level') == 'Admin'){?>
                            <a class="dropdown-item" href="<?= base_url('users');?>">Pengguna</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('kategori');?>">Kategori</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('menu');?>">Menu</a>
                            <div class="dropdown-divider"></div>
                            <?php }?>

                            <a class="dropdown-item" href="<?= base_url('customer');?>">Customer</a>
                            <div class="dropdown-divider"></div>

                            <!-- <?php if($this->session->userdata('ses_level') == 'Admin'){?>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?= base_url('users');?>">Pengguna</a>
                            <?php }?> -->

                        </div>
                    </div>
                    <div class="nav-item active">
                        <a class="nav-link" href="<?= base_url('kasir');?>"><i class="fas fa-cash-register fa-lg"></i> TRANSAKSI</a>
                    </div>
                    <?php
                            // Hari Ini
                            $day    = $this->db->query('SELECT no_bon FROM transaksi WHERE date = ?', [date('Y-m-d')])->num_rows();
                            // Bayar Nanti
                            $co     = $this->db->query('SELECT no_bon FROM transaksi WHERE metode = ?', ['Bayar Nanti'])->num_rows();
                            // Ditempat
                            $cdo    = $this->db->query('SELECT no_bon FROM transaksi WHERE pesanan = ? AND date = ?', ['Dine In', date('Y-m-d')])->num_rows();
                            // Booking
                            $cbo    = $this->db->query('SELECT no_bon FROM transaksi WHERE pesanan = ? AND date = ?', ['Take Away', date('Y-m-d')])->num_rows();
                            // Delivery
                            $clo    = $this->db->query('SELECT no_bon FROM transaksi WHERE pesanan = ? AND date = ?', ['Delivery', date('Y-m-d')])->num_rows();
                        ?>
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fas fa-receipt fa-lg ml-1"></i> PESANAN
                                <span class="badge badge-danger"><?= $co;?></span></a>
                            <div class="dropdown-menu " aria-labelledby="dropdownId">
                                <!--<a class="dropdown-item" href="#">CEK ORDER</a>
                                <div class="dropdown-divider"></div>-->
                                <a class="dropdown-item" href="<?= base_url('order');?>">Semua Pesanan
                                    <span class="badge badge-secondary float-right"><?= $day;?></span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('order?jenis=1');?>">Dine in
                                    <span class="badge badge-primary float-right"><?= $cdo;?></span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('order?jenis=2');?>">Take away
                                    <span class="badge badge-warning float-right"><?= $cbo;?></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('order?jenis=3');?>">Delivery
                                    <span class="badge badge-info float-right"><?= $clo;?></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('order?jenis=4');?>">Bayar nanti
                                    <span class="badge badge-danger float-right"><?= $co;?></a>
                                <div class="dropdown-divider"></div>

                            </div>
                        </div>
                        <div class="nav-item dropdown">
                            <?php if($this->session->userdata('ses_level') == 'Admin'){?>

                            <a class="nav-link dropdown-toggle" href="#" id="dropdownId" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false"><i class="fas fa-file-invoice-dollar fa-lg ml-1"></i> LAPORAN</a>
                            <?php }?>
 
                            <div class="dropdown-menu" aria-labelledby="dropdownId">

                                <!-- <?php if($this->session->userdata('ses_level') == 'Admin'){?> -->
                                <a class="dropdown-item" href="<?= base_url('laporan');?>">Laporan Penjualan</a>
                                <!-- <?php }?> -->
                                    
                                <!-- <a class="dropdown-item"
                                    href="<?= base_url('laporan?kasir='.$this->session->userdata('ses_id'));?>">Transaksi
                                    Penjualan</a>
                                -->


                                <div class="dropdown-divider"></div>
                                <?php if($this->session->userdata('ses_level') == 'Admin'){?>
                                <a class="dropdown-item" href="<?= base_url('laporan/produk');?>">Laporan Menu</a>
                                <?php }else{?>
                                <a class="dropdown-item" href="<?= base_url('laporan/produk?kasir='.$this->session->userdata('ses_id'));?>">Laporan per Menu</a>
                                <?php }?>
                                <div class="dropdown-divider"></div>

                                <!-- <?php if($this->session->userdata('ses_level') == 'Admin'){?>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="<?= base_url('laporan/cash');?>">Cash Flow</a>
                                <?php }?> -->
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </aside>

</body>


<script>
    $(document).ready(function () {
    var path = window.location.pathname;
    var url = window.location.href;

    // Iterasi semua link pada sidebar dan dropdown
    $('.nav-link, .dropdown-item').each(function () {
        var href = $(this).attr('href');

        // Memeriksa apakah URL halaman saat ini cocok dengan href dari setiap link
        if (url.includes(href)) {
            $(this).addClass('active'); // Menandai link sidebar atau dropdown item yang aktif

            // Menandai sidebar yang aktif jika link atau dropdown item yang aktif berada di dalam sidebar
            $(this).closest('.sidebar').addClass('active-sidebar');

            // Jika link adalah dropdown item, juga menandai dropdown toggle-nya
            var dropdownToggle = $(this).closest('.dropdown').find('.dropdown-toggle');
            if (dropdownToggle.length) {
                dropdownToggle.addClass('active');
            }
        }
    });

    // Saat .dropdown-toggle di-klik
    $('.dropdown-toggle').on('click', function () {
        var $dropdownMenu = $(this).next('.dropdown-menu');

        // Toggle class 'show' pada dropdown-menu yang sesuai
        $dropdownMenu.toggleClass('show');

        // Tutup dropdown-menu lain yang sedang terbuka
        $('.dropdown-menu').not($dropdownMenu).removeClass('show');
    });

    // Tutup dropdown-menu jika klik dilakukan di luar area dropdown
    $(document).on('click', function (event) {
        if (!$(event.target).closest('.dropdown').length) {
            $('.dropdown-menu').removeClass('show');
        }
    });
});

</script>


<!-- <script>
    $(document).ready(function() {
        $('.dropdown-toggle').on('click', function() {
            var $dropdownMenu = $(this).next('.dropdown-menu');
            $dropdownMenu.toggleClass('show');
            $('.dropdown-menu').not($dropdownMenu).removeClass('show');
        });

        $(document).on('click', function(event) {
            if (!$(event.target).closest('.dropdown').length) {
                $('.dropdown-menu').removeClass('show');
            }
        });

        var path = window.location.pathname;
        var url = window.location.href;

        $('.nav-link, .dropdown-item').each(function() {
            var href = $(this).attr('href');
            if (url.includes(href)) {
                $(this).addClass('active');
                $(this).closest('.dropdown-toggle').addClass('active');
            }
        });
    });
</script> -->

<!-- 
<script>
$(document).ready(function() {
    // Saat .dropdown-toggle di-klik
    $('.dropdown-toggle').on('click', function() {
        var $dropdownMenu = $(this).next('.dropdown-menu');
        
        // Toggle class 'show' pada dropdown-menu yang sesuai
        $dropdownMenu.toggleClass('show');
        
        // Tutup dropdown-menu lain yang sedang terbuka
        $('.dropdown-menu').not($dropdownMenu).removeClass('show');
    });

    // Tutup dropdown-menu jika klik dilakukan di luar area dropdown
    $(document).on('click', function(event) {
        if (!$(event.target).closest('.dropdown').length) {
            $('.dropdown-menu').removeClass('show');
        }
    });
});
</script>

<script>
$(document).ready(function() {
    var path = window.location.pathname;
    var url = window.location.href;

    // Iterasi semua link pada sidebar dan dropdown
    $('.nav-link, .dropdown-item').each(function() {
        var href = $(this).attr('href');
        
        // Memeriksa apakah URL halaman saat ini cocok dengan href dari setiap link
        if (url.includes(href)) {
            $(this).addClass('active'); // Menandai link sidebar atau dropdown item yang aktif

            // Menandai sidebar yang aktif jika link atau dropdown item yang aktif berada di dalam sidebar
            $(this).closest('.sidebar').addClass('active-sidebar');
            

            // Jika link adalah dropdown item, juga menandai dropdown toggle-nya
            if ($(this).hasClass('dropdown-item')) {
                $(this).closest('.dropdown').find('.dropdown-toggle').addClass('active');
            }
        }
    });
});
</script> -->


</html>