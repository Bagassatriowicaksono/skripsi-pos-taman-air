<style>
    .card-footer a{
    color: #3b9642;
}
</style>
<div class="clearfix"></div>
<div id="home" class="home">
    <div class="container mt-5 py-5">
        <div class="row">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card card-rounded mb-4">
                            <div class="card-header bg-success text-white">
                                Kategori
                            </div>
                            <div class="card-body text-center">
                                <h2 class="card-title"><b><?= $ck;?></b></h2>
                            </div>
                            <div class="card-footer text-center">
                                <a href="<?= base_url('kategori');?>">Lihat Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card card-rounded mb-4">
                            <div class="card-header bg-success text-white">
                                Menu
                            </div>
                            <div class="card-body text-center">
                                <h2 class="card-title"><b><?= $cm;?></b></h2>
                            </div>
                            <div class="card-footer text-center">
                                <a href="<?= base_url('menu');?>">Lihat Selengkapnya </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card card-rounded mb-4">
                            <div class="card-header bg-success text-white">
                                Customer
                            </div>
                            <div class="card-body text-center">
                                <h2 class="card-title"><b><?= $cc;?></b></h2>
                            </div>
                            <div class="card-footer text-center">
                                <a href="<?= base_url('customer');?>">Lihat Selengkapnya </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card card-rounded mb-4">
                            <div class="card-header bg-success text-white">
                                Transaksi Selesai
                            </div>
                            <div class="card-body text-center">
                                <h2 class="card-title"><b><?= $ct;?></b></h2>
                            </div>
                            <div class="card-footer text-center">
                                <a href="<?= base_url('laporan');?>">Lihat Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="col-lg-6">
                <?php
                // Ambil tahun dan bulan dari inputan form
                if (!empty($this->input->post('thn'))) {
                    $thn = $this->input->post('thn');
                } else {
                    $thn = date('Y');
                }
                if (!empty($this->input->post('bln'))) {
                    $bln = $this->input->post('bln');
                } else {
                    $bln = date('m');
                }

                // Query untuk mengambil data menu terlaris berdasarkan tahun dan bulan
                $this->db->select('kode_menu, nama_menu, kategori, SUM(qty) as qty_terjual');
                $this->db->where('YEAR(date)', $thn);
                $this->db->where('MONTH(date)', $bln);
                $this->db->group_by(['kode_menu', 'nama_menu', 'kategori']);
                $this->db->order_by('qty_terjual', 'DESC');
                $query = $this->db->get('transaksi_produk');
                $transaksi = $query->result();

                // Potong array $transaksi hanya untuk 3 data teratas
                $transaksi = array_slice($transaksi, 0, 3);

                // Buat array untuk labels dan data pie chart
                $labels = [];
                $data = [];
                foreach ($transaksi as $menu) {
                    $labels[] = $menu->nama_menu;
                    $data[] = $menu->qty_terjual;
                }
                ?>

                <!-- Tampilkan form untuk memilih tahun dan bulan -->
                <div class="col-sm-12">
                    <div class="card card-rounded">
                        <div class="card-header bg-success text-white">
                            Menu Terlaris <?= $bln . '-' . $thn; ?>
                        </div>
                        <div class="card-body text-center">
                            <div class="row">
                                <div class="col-sm-12">
                                    <form method="post" action="<?= base_url('home') ?>">
                                        <div class="table-responsive">
                                            <table>
                                                <tr>
                                                    <td>
                                                        <select name="thn" class="form-control">
                                                            <option value="">- Pilih Tahun Grafik -</option>
                                                            <?php
                                                            $thn_skr = date('Y');
                                                            for ($x = $thn_skr; $x >= 2021; $x--) {
                                                                ?>
                                                                <option value="<?= $x; ?>" <?php if ($thn == $x) { ?> selected <?php } ?>>
                                                                    <?= $x; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="bln" class="form-control">
                                                            <option value="">- Pilih Bulan Grafik -</option>
                                                            <?php
                                                            $bulan = [
                                                                1 => 'Januari',
                                                                2 => 'Februari',
                                                                3 => 'Maret',
                                                                4 => 'April',
                                                                5 => 'Mei',
                                                                6 => 'Juni',
                                                                7 => 'Juli',
                                                                8 => 'Agustus',
                                                                9 => 'September',
                                                                10 => 'Oktober',
                                                                11 => 'November',
                                                                12 => 'Desember'
                                                            ];
                                                            foreach ($bulan as $key => $value) {
                                                                ?>
                                                                <option value="<?= $key; ?>" <?php if ($bln == $key) { ?> selected <?php } ?>>
                                                                    <?= $value; ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <button type="submit" class="btn btn-green btn-md">
                                                            <i class="fa fa-search"></i></button>
                                                    </td>
                                                    <td>
                                                        <a href="<?= base_url('home') ?>" class="btn btn-success btn-md">
                                                            <i class="fa fa-refresh"></i> </a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- <div class="clearfix"></div> -->
                            <div class="col-md-8 ml-5">
                                <canvas id="pie-chart" width="300" height="300" style="width: 100px; height:100px;"></canvas>
                            </div>
                        </div>
                        <div class="card-footer text-center">
                                <a href="<?= base_url('laporan/laris');?>">Lihat Selengkapnya </a>
                            </div>
                    </div>
                </div>

            </div>
            

            <?php if(!empty($this->input->post('thn'))){ $thn = $this->input->post('thn');  }else{ $thn = date('Y'); }?>
            <div class="col-sm-12">
                <div class="card card-rounded mb-4 mt-3">
                    <div class="card-header bg-success text-white">
                        Grafik Penjualan <?= $thn;?>
                    </div>
                    <div class="card-body text-center">
                        <div class="row">
                            <div class="col-sm-5">
                                <form method="post" action="<?= base_url('home')?>">
                                    <div class="table-responsive">
                                        <table>
                                            <tr>
                                                <td>
                                                    <select name="thn" class="form-control">
                                                        <option value="">- Pilih Tahun Grafik -</option>
                                                        <?php
                                                        $thn_skr = date('Y');
                                                        for ($x = $thn_skr; $x >= 2021; $x--){
                                                    ?>
                                                        <option value="<?= $x;?>" <?php if($thn == $x){?> selected
                                                            <?php }?>><?= $x;?></option>
                                                        <?php }?>
                                                    </select>
                                                </td>
                                                <td>
                                                    <button type="submit" class="btn btn-green btn-md">
                                                        <i class="fa fa-search"></i></button>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url('home')?>" class="btn btn-success btn-md">
                                                        <i class="fa fa-refresh"></i> </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <canvas id="line-chart" height="180" style="height: 300px;"></canvas>
                    </div>
                </div>
            </div>
        
        </div>
    </div>




    <script>
    var linechart = document.getElementById('line-chart');
    var chart = new Chart(linechart, {
        type: 'bar',
        data: {
            labels: [
                'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Okt', 'Nov', 'Des'
            ], // Merubah data tanggal menjadi format JSON
            datasets: [{
                label: "Menu Terjual",
                data: [
                    <?php 
                            // php mencari produk
                            for($n=1; $n<=12; $n++){
                                if($n > 9) {
                                    $period = $thn.'-'.$n;
                                }else{
                                    $period = $thn.'-'.'0'.$n;
                                }
                                if($this->session->userdata('ses_level') == 'Admin'){
                                    $penjualan = $this->db->query('SELECT SUM(qty) as qty FROM transaksi_produk WHERE periode = ?',[$period])->row();
                                }else{
                                    $penjualan = $this->db->query('SELECT SUM(qty) as qty FROM transaksi_produk 
                                        WHERE periode = ? AND kasir_id = ?',[$period, $this->session->userdata('ses_id')])->row();
                                }
                        ?>
                    <?= $penjualan->qty;?>,
                    <?php } ?>
                ],
                borderColor: '#71b865',
                backgroundColor: '#71b865',
                borderWidth: 3,
            }, ],
        },
        options: {
            responsive: true,
        },
    });

    </script>


    <!-- Script untuk menggambar pie chart -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('pie-chart').getContext('2d');

            var chartData = {
                labels: <?= json_encode($labels); ?>,
                datasets: [{
                    label: 'Menu Terlaris',
                    data: <?= json_encode($data); ?>,
                    backgroundColor: [
                        '#5ba84e',
                        '#71b865',
                        '#bbddb6',
                        
                        // Tambahkan warna lain sesuai jumlah data
                    ],
                    borderColor: [
                        'transparent'
                        // Tambahkan warna border sesuai jumlah data
                    ],
                    borderWidth: 1
                }]
            };

            var options = {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'right',
                        // align: 'end'
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' terjual';
                            }
                        }
                    }
                }
            };

            new Chart(ctx, {
                type: 'doughnut',
                data: chartData,
                options: options
            });
        });
    </script>



    <!-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            var ctx = document.getElementById('pie-chart').getContext('2d');
            
            var data = {
                labels: [
                    <?php foreach ($transaksi as $menu): ?>
                        '<?= $menu->nama_menu ?>',
                    <?php endforeach; ?>
                ],
                datasets: [{
                    label: 'Menu Terlaris',
                    data: [
                        <?php foreach ($transaksi as $menu): ?>
                            <?= $menu->qty_terjual ?>,
                        <?php endforeach; ?>
                    ],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        // Tambahkan warna lain sesuai jumlah data
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        // Tambahkan warna border sesuai jumlah data
                    ],
                    borderWidth: 1
                }]
            };
            
            var options = {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function (tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' terjual';
                            }
                        }
                    }
                }
            };
            
            new Chart(ctx, {
                type: 'pie',
                data: data,
                options: options
            });
        });
    </script> -->
