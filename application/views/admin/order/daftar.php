<div class="clearfix"></div>
<div id="home" class="home">
    <div class="container mt-5 py-5">
        <div class="row">
            <div class="col-lg-6">
                <form method="get" action="">
                    <div class="input-group">
                        <div class="input-group-append">
                            <span class="btn btn-default btn-md">Data Per Tanggal</span>
                        </div>
                        <?php if(!empty((int)$this->input->get('jenis'))){?>
                        <input type="hidden" name="jenis" value="<?= (int)$this->input->get('jenis');?>">
                        <?php }?>
                        <input type="date" value="<?= $date;?>" class="form-control" id="date" required name="tgl"
                            aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button type="sumbit" id="basic-addon2" class="btn btn-green btn-md">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- <div class="col-sm-6">
                <a href="<?= base_url('kasir');?>" class="btn btn-success float-right">
                    <i class="fa fa-plus"> </i> Tambah Transaksi</a>
            </div> -->
        </div>
        <div class="clearfix"></div>
        <br>
        <?php 
            if(!empty($this->session->flashdata('success'))){  
                echo alert_success($this->session->flashdata('success')); 
            }
            if(!empty($this->session->flashdata('failed'))){ 
                echo alert_failed($this->session->flashdata('failed'));
            }
        ?>
        <div class="card card-rounded">
            <div class="card-header bg-success text-white">
                <?= $title_web;?>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-sm table-striped table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>No Bon</th>
                                <th>Atas Nama</th>
                                <th>Customer</th>
                                <th>Kasir</th>
                                <th>Grand Total</th>
                                <th>Tanggal</th>
                                <th>Jenis Pesanan</th>
                                <th>Metode</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
    if(!empty((int)$this->input->get('jenis'))){
        $jn = (int)$this->input->get('jenis');
        if($jn == 1){
            if(!empty($this->input->get('tgl'))){
                $url = base_url('order/data_order?jenis=1&tgl='.$this->input->get('tgl'));
            }else{
                $url = base_url('order/data_order?jenis=1');
            }
        }else if($jn == 2){
            if(!empty($this->input->get('tgl'))){
                $url = base_url('order/data_order?jenis=2&tgl='.$this->input->get('tgl'));
            }else{
                $url = base_url('order/data_order?jenis=2');
            }
        }else if($jn == 3){
            if(!empty($this->input->get('tgl'))){
                $url = base_url('order/data_order?jenis=3&tgl='.$this->input->get('tgl'));
            }else{
                $url = base_url('order/data_order?jenis=3');
            }
        }else{
            if(!empty($this->input->get('tgl'))){
                $url = base_url('order/data_order?jenis=4&tgl='.$this->input->get('tgl'));
            }else{
                $url = base_url('order/data_order?jenis=4');
            }
        }
    }else{
        if(!empty($this->input->get('tgl'))){
            $url = base_url('order/data_order?tgl='.$this->input->get('tgl'));
        }else{
            $url = base_url('order/data_order');
        }
    }
?>
<script>
var tabel = null;
var base_url = "<?= base_url('');?>";
$(document).ready(function() {
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
            "url": "<?= $url;?>", // URL file untuk proses select datanya
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
                render: function(data, type, row, meta) {
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
                "data": "nama",
                "render": function(data, type, row, meta) {
                    if (row.customer_id == 0) {
                        return '-';
                    } else {
                        return row.nama;
                    }
                }
            },
            {
                'data': 'nama_user'
            },
            {
                data: 'grandtotal',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                'data': 'created_at'
            },
            {
                "data": "pesanan",
                "render": function(data, type, row, meta) {

                    if (row.pesanan == 'Dine In') {
                        return '<span class="badge badge-primary"><i class="fa fa-cutlery"></i> Dine In</span>';
                    }

                    if (row.pesanan == 'Take Away') {
                        return '<span class="badge badge-warning"><i class="fa fa-shopping-bag"></i> Take Away</span>';
                    }

                    if (row.pesanan == 'Delivery') {
                        return '<span class="badge badge-info"><i class="fa fa-motorcycle"></i> Delivery</span>';
                    }

                    if (row.pesanan == 'Bayar Nanti') {
                        return '<span class="badge badge-danger"><i class="fa fa-clock-o"></i> Bayar Nanti</span>';
                    }

                    return row.pesanan || '-';
                }
            },  

            {
                "data": "metode",
                "render": function(data, type, row, meta) {
                    if (row.metode == 'Bayar Nanti') {
                        return '<span class="badge badge-danger"><i class="fa fa-info-circle"> </i> ' +
                            row.metode + '</span>';
                    } else {
                        return '<span class="badge badge-success"><i class="fa fa-check"> </i> ' +
                            row.metode + '</span>';
                    }
                }
            },
            {
                "data": "id",
                "render": function(data, type, row, meta) {
                    <?php if($this->session->userdata('ses_level') == 'Admin'){?>
                    return `<center>
                                    <a href="${base_url}order/edit/${row.id}" 
                                        class="btn btn-green btn-sm" title="Detail Order" role="button">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                    <a href="${base_url}order/hapus/${row.id}" 
                                        onclick="javascript:return confirm('Apakah data ingin dihapus ?')" 
                                        class="btn btn-danger btn-sm" title="Hapus Order" role="button">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </center>`;

                    <?php }else{?>
                    return `<center>
                                <a href="${base_url}order/edit/${row.id}" 
                                    class="btn btn-green btn-sm" title="Detail Order" role="button">
                                    <i class="fa fa-eye"></i> Detail
                                </a>
                            </center>`;
                    <?php }?>
                }
            },
        ],
        "fnDrawCallback": function() {
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
                    opener: function(openerElement) {
                        return openerElement.is('img') ? openerElement : openerElement
                            .find('img');
                    }
                }
            });
        }
    });
});
</script>