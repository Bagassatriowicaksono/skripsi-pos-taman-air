<div class="clearfix"></div>
<div id="home" class="home">
    <div class="container mt-5 py-5">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-green btn-md mt-2" data-toggle="modal" data-target="#modelIdFilter">
            <i class="fa fa-search"></i> Pencarian
        </button>
        <a href="<?= $urlexcel; ?>" class="btn btn-info mt-2 btn-md ml-1">
            <i class="fa fa-download"></i> File Excel
        </a>
        <?php
        $urlPrint = $urlexcel;
        if ($this->input->get('a', true)) {
            $urlPrint .= '&cetak=print';
        } else {
            if (!empty($this->input->get('kasir', true))) {
                $urlPrint .= '&cetak=print';
            } else {
                $urlPrint .= '?cetak=print';
            }
        }
        ?>
        <a href="<?= $urlPrint; ?>" target="_blank" class="btn btn-secondary mt-2 btn-md ml-1">
            <i class="fa fa-print"></i> Cetak
        </a>
        <?php if ($this->input->get('kasir')) { ?>
            <a href="<?= base_url('laporan?kasir=' . $this->input->get('kasir', true)); ?>"
                class="btn btn-warning mt-2 btn-md ml-1">
                <i class="fa fa-refresh"></i> Refresh
            </a>
        <?php } else { ?>
            <a href="<?= base_url('laporan'); ?>" class="btn btn-warning mt-2 btn-md ml-1">
                <i class="fa fa-refresh"></i> Refresh
            </a>
        <?php } ?>
        <div class="clearfix"></div>
        <br>
        <?php
        if (!empty($this->session->flashdata('success'))) {
            echo alert_success($this->session->flashdata('success'));
        }
        if (!empty($this->session->flashdata('failed'))) {
            echo alert_failed($this->session->flashdata('failed'));
        }
        ?>
        <div class="card card-rounded">
            <div class="card-header bg-success text-white">
                <?= $title_web; ?>
                <?= $periode; ?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered  table-sm table-striped table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Bon</th>
                                <th>Atas Nama</th>
                                <th>Customer</th>
                                <th>Kasir</th>
                                <th>Tanggal</th>
                                <th>Jenis Pesanan</th>
                                <th>Metode</th>
                                <th>Status</th>
                                <th>Qty</th>
                                <th>Grand Total</th>
                                
                                <!-- <th>Aksi</th> -->
                            </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                        <tr>
                            <th colspan="9">Total</th>
                            <th><?= $total->qty; ?></th>
                            <th>Rp <?= number_format($total->gr ?? 0); ?>,-</th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modelIdFilter" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title"><b>Pencarian Data</b></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="GET" action="<?= base_url('laporan'); ?>">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Nama Kasir <small class="text-danger mr-2">( opsional )</small></label>
                        <select class="form-control" name="kasir">
                            <option value="" selected>- pilih -</option>
                            <?php
                            if ($this->session->userdata('ses_level') == 'Admin') {
                                $kasir = $this->db->get('login')->result();
                            } else {
                                $kasir = $this->db->get_where('login', ['id' => $this->session->userdata('ses_id')])->result();
                            }
                            foreach ($kasir as $r) {
                                ?>
                                <option value="<?= $r->id; ?>" <?php if ($this->session->userdata('ses_level') != 'Admin') {
                                     echo 'selected';
                                 } ?>>
                                    <?= $r->nama_user; ?>
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal Start</label>
                        <input type="date" class="form-control" required value="<?= $this->input->get('a') ?>" name="a"
                            placeholder="">
                    </div>
                    <div class="form-group">
                        <label for="">Tanggal End</label>
                        <input type="date" class="form-control" required value="<?= $this->input->get('b') ?>" name="b"
                            placeholder="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-green">Cari</button>
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button> -->
                </div>
            </form>
        </div>
    </div>
</div>
<?php
if ($this->session->userdata('ses_level') == 'Admin') {
    $ks = $this->input->get('kasir');
} else {
    $ks = $this->session->userdata('ses_id');
}
if (!empty($this->input->get('a'))) {
    if ($this->input->get('kasir')) {
        $url = base_url('laporan/data_order?kasir=' . $ks . '&a=' . $this->input->get('a') . '&b=' . $this->input->get('b'));
    } else {
        $url = base_url('laporan/data_order?a=' . $this->input->get('a') . '&b=' . $this->input->get('b'));
    }
} else {
    if ($this->input->get('kasir')) {
        $url = base_url('laporan/data_order?kasir=' . $ks);
    } else {
        if ($this->session->userdata('ses_level') == 'Admin') {
            $url = base_url('laporan/data_order');
        } else {
            $url = base_url('laporan/data_order?kasir=' . $ks);
        }
    }
}
?>
<script>
    var tabel = null;
    var base_url = "<?= base_url(''); ?>";
    $(document).ready(function () {
        $.fn.dataTable.ext.errMode = 'none';
        tabel = $('#example1').DataTable({
            "processing": true,
            "serverSide": true,
            'responsive': true,
            "ordering": true, // Set true agar bisa di sorting
            "order": [
                [0, 'desc']
            ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
            "ajax": {
                "url": "<?= $url; ?>", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "aLengthMenu": [
                [10, 25, 50, 100, 150],
                [10, 25, 50, 100, 150]
            ], // Combobox Limit
            "columns": [{
        "data": 'id',
        "sortable": false,
        render: function (data, type, row, meta) {
            return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                'data': 'no_bon'
            },
            {
                'data': 'atas_nama'
            },
            {
                'data': 'nama' // Customer
            },
            {
                'data': 'nama_user' // Kasir
            },
            {
                'data': 'created_at'
            },
            {
                "data": "pesanan",
                "render": function (data, type, row, meta) {

                    if (row.pesanan == 'Dine in') {
                        return '<span class="badge badge-primary"><i class="fa fa-cutlery"></i> ' +
                            row.pesanan +
                            '</span>';
                    }

                    if (row.pesanan == 'Take away') {
                        return '<span class="badge badge-warning"><i class="fa fa-home"></i> ' +
                            row.pesanan +
                            '</span>';
                    }

                    if (row.pesanan == 'Delivery') {
                        return '<span class="badge badge-info"><i class="fa fa-motorcycle"></i> ' +
                            row.pesanan +
                            '</span>';
                    }

                }
            },
            {
                "data": "metode",
                "render": function (data, type, row, meta) {

                    if (row.metode == 'Bayar Nanti') {

                        return '<span class="badge badge-danger"><i class="fa fa-info-circle"></i> ' +
                            row.metode +
                            '</span>';

                    } else {

                        return '<span class="badge badge-success"><i class="fa fa-check"></i> ' +
                            row.metode +
                            '</span>';

                    }

                }
            },
            {
                "data": "status_pembayaran",
                "render": function (data, type, row, meta) {

                    if (data == "Lunas") {

                        return '<span class="badge badge-success"><i class="fa fa-check"></i> Lunas</span>';

                    } else {

                        return '<span class="badge badge-danger"><i class="fa fa-times"></i> Belum Lunas</span>';

                    }

                }
            },
            {
                'data': 'total_qty'
            },
            {
                'data': 'grandtotal',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            }
        ],
            "fnDrawCallback": function () {
                $('.portfolio-popup').magnificPopup({
                    type: 'image',
                    removalDelay: 300,
                    mainClass: 'mfp-fade',
                    gallery: {
                        enabled: true
                    },
                    zoom: {
                        enabled: true,
                        duration: 300,
                        easing: 'ease-in-out',
                        opener: function (openerElement) {
                            return openerElement.is('img') ? openerElement : openerElement
                                .find('img');
                        }
                    }
                });
            }
        });
    });
</script>