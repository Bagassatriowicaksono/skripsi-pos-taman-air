<style>

#kasircontainer .card{
    border:none;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 8px 25px rgba(0,0,0,.08);
}

#kasircontainer .card-header{

    background:#2e9d44 !important;

    color:#fff;

    font-size:18px;

    font-weight:700;

    padding:14px 20px;

    border:none;

}

#kasircontainer .card-body{

    padding:20px;

}

#kasircontainer .card-footer{

    background:#fafafa;

    border:none;

    padding:20px;

}

/* Label */

#kasircontainer label,
#kasircontainer th{

    font-weight:600;

    color:#444;

}

/* Input */

#kasircontainer .form-control{

    border-radius:10px;

    min-height:42px;

    border:1px solid #d9d9d9;

    box-shadow:none;

}

#kasircontainer .form-control:focus{

    border-color:#28a745;

    box-shadow:0 0 0 .15rem rgba(40,167,69,.15);

}

/* Input Group */

#kasircontainer .input-group-text{

    border-radius:10px 0 0 10px;

    background:#f5f5f5;

}

/* Button */

#kasircontainer .btn{

    border-radius:10px;

}

#kasircontainer .btn-success,
#kasircontainer .btn-green{

    font-weight:600;

}

/* Simpan */

#prosesTransaksi{

    height:60px;

    font-size:18px;

    font-weight:700;

    border-radius:14px;

}

/* Table */

.aTable{

    width:100%;

}

.aTable th{

    width:34%;

    padding:10px 8px;

    vertical-align:middle;

}

.aTable td{

    padding:8px;

}

/* Customer Warning */

.text-danger{

    display:block;

    background:#fff6f6;

    border-left:4px solid #dc3545;

    padding:10px;

    border-radius:8px;

    margin-top:8px;

}

#rupiah1{
    font-size:22px;
    font-weight:bold;
}

/* Grand Total */

#GrandTotal{
    background:#e8f8ec;
    border:2px solid #28a745;
    color:#218838;
    font-size:28px;
    font-weight:bold;
    text-align:right;
}

/* Total Bayar */

#totalBayar{

    font-weight:bold;

    font-size:18px;

}

/* Dibayar */

#rupiah1{

    font-weight:bold;

    color:#0d6efd;

}

/* Kembali */

#kembaliBayar{

    background:#d4edda;

    border:2px solid #28a745;

    color:#155724;

    font-size:24px;

    font-weight:bold;

    text-align:right;

}

</style>

/* Label kiri */
#kasircontainer table tr td:first-child{

    font-weight:600;

    color:#444;

}

/* Header tabel keranjang */
#kasircontainer table thead{

    background:#f7f7f7;

}

#kasircontainer table thead th{

    font-size:13px;

    font-weight:700;

}

/* Isi tabel */
#kasircontainer table tbody td{

    vertical-align:middle;

    font-size:14px;

}

/* Tombol Simpan */
#prosesTransaksi:hover{

    transform:translateY(-2px);

    box-shadow:0 10px 25px rgba(40,167,69,.35);

}

<div class="clearfix"></div>
<div id="home" class="home">
    <div class="container mt-5 py-3" id="kasircontainer">
        <?php 
            if(!empty($this->session->flashdata('success'))){  
                echo alert_success($this->session->flashdata('success')); 
            }
            if(!empty($this->session->flashdata('failed'))){ 
                echo alert_failed($this->session->flashdata('failed'));
            }
        ?>
        <div class="row">
            <div class="col-lg-7 mt-4">
                <div class="card card-rounded">
                    <div class="card-header bg-success text-white">Daftar Menu</div>
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="dropdown open mb-3">
                                    <button class="btn btn-green btn-block dropdown-toggle" type="button"
                                        id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                        <?php 
                                            if(!empty($this->input->get('nm'))){
                                                echo $this->input->get('nm');
                                            }else{
                                                echo 'Semua Kategori';
                                            }
                                        ?>
                                    </button>
                                    <div class="dropdown-menu" style="width:100%" aria-labelledby="triggerId">
                                        <?php foreach($kat as $r){?>
                                        <a class="dropdown-item"
                                            href="<?= base_url('kasir?id='.$r->id.'&nm='.$r->kategori);?>">
                                            <?= $r->kategori;?></a>
                                        <div class="dropdown-divider"></div>
                                        <?php }?>
                                        <a class="dropdown-item" href="<?= base_url('kasir');?>">
                                            Semua Kategori</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 mb-3">
                                <form method="get" action="">
                                    <div class="input-group">
                                        <input type="text" class="form-control" value="<?=$this->input->get('cari');?>"
                                            name="cari" id="cari" placeholder="Cari Menu">
                                        <div class="input-group-append">
                                            <!-- Button trigger modal -->
                                            <button type="submit" class="btn btn-green btn-md">
                                                <i class="fa fa-search"></i>
                                            </button>
                                            <a href="<?= base_url('kasir');?>" class="btn btn-success btn-md btn-block">
                                                <i class="fa fa-refresh"></i>
                                            </a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="table-responsive-1 w-100">
                            <?php 
                                if($this->input->get('id')){
                                    $wr   = ' WHERE id_kategori = '.(int)$this->input->get('id').' ';
                                    $url  = base_url('menu/dtmenu?id='.(int)$this->input->get('id'));
                                }else if($this->input->get('cari')){
                                    $wr   = ' WHERE kode_menu LIKE "%'.$this->input->get('cari').'%" OR nama LIKE "%'.$this->input->get('cari').'%" OR kategori.kategori LIKE "%'.$this->input->get('cari').'%"';
                                    $url  = base_url('menu/dtmenu?cari='.$this->input->get('cari'));
                                }else{
                                    $wr   = '';
                                    $url  = base_url('menu/dtmenu');
                                }
                                $query = "SELECT kategori.kategori, menu.* FROM menu LEFT JOIN kategori ON menu.id_kategori = kategori.id";	
                                $total = $this->db->query("$query $wr")->num_rows();  
                                $pages = ceil($total/$halperpage);

                                if($total == '0'){ echo '<br/><h4>" Tidak ada Menu "</h4><br/>';}
                            ?>
                            <div id="load-data" class="row-css"></div>
                            <div style="text-align: center;">
                                <div id="loading"></div>
                            </div>
                            <br />
                            <div class="wrapper">
                                <ul id="pagination-demo" class="pagination"></ul>
                            </div>
                            <script>
                            $(document).ready(function() {
                                $('#pagination-demo').twbsPagination({
                                    totalPages: <?php echo $pages;?>,
                                    visiblePages: 0,
                                    next: 'Next',
                                    prev: 'Prev',
                                    first: '',
                                    last: '',
                                    onPageClick: function(event, page) {
                                        loadData(page);
                                    }
                                });

                                function loadData(pageHome) {
                                    dataString = "pageHome=" + pageHome;
                                    $.ajax({
                                        type: "POST",
                                        url: "<?php echo $url;?>",
                                        data: dataString,
                                        cache: false,
                                        beforeSend: function() {
                                            $("#loading").html(
                                                '<img src="<?php echo base_url('assets/image/spinner-primary.svg');?>"/>'
                                            );
                                        },
                                        success: function(html) {
                                            $("#loading").html('');
                                            $("#load-data").html(html);
                                        }
                                    });
                                }
                                loadData(0);
                            });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-5 mt-4">
                <div class="card card-rounded">

                    <div class="card-header bg-success text-white">
                    <i class="fa fa-shopping-cart mr-2"></i>
                    Keranjang Transaksi
                    </div>

                    <form method="post" id="AddKasir">
                        <div class="card-body p-2">
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">No Transaksi</label>
                                <div class="col-sm-8">
                                    <input type="text" required readonly class="form-control" value="<?= $no_bon;?>"
                                        name="no_bon" id="no_bon" placeholder="No Transaksi">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-4 col-form-label">Customer</label>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="pelanggan" id="pelanggan"
                                            placeholder="Nama Customer">
                                        <div class="input-group-append">
                                            <!-- Button trigger modal -->
                                            <button type="button" class="btn btn-green btn-md" data-toggle="modal"
                                                data-target="#modelId">
                                                <i class="fa fa-search"></i>
                                            </button>
                                            <a href="" class="btn btn-danger btn-md">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>
                                        <input type="hidden" name="customer_id" id="pelanggan_id" value="0">
                                    </div>
                                </div>
                            </div>
                            <small class="text-danger">
                                <b>
                                    * Untuk Customer yang sudah terdaftar pada sistem
                                </b>
                            </small>

                            <div class="form-group mt-3 row">
                                <label for="" class="col-sm-4 col-form-label">Nama Pemesan</label>
                                <div class="col-sm-8">
                                    <input type="text" value="-" required autocomplete="off" class="form-control"
                                        name="atas_nama" id="atas_nama" placeholder="Nama Pemesan">
                                </div>
                            </div>
                            <div class="float-left pt-2">
                                <i class="fa fa-shopping-cart"></i> List Keranjang
                            </div>
                            <!-- <button type="button" class="btn btn-primary btn-sm float-right" data-toggle="modal" data-target="#modelId1">
                                <i class="fa fa-eye"></i> Lihat List Tabel
                            </button> -->
                            <div class="clearfix"></div>
                        </div>
                        <div class="modal-body p-0">
                            <div id="cart_keranjang"></div>
                        </div>
                        <div class="card-footer p-2">
                            <table class="aTable">
                                <tbody>
                                    <tr>
                                        <th>Metode Pembayaran </th>
                                        <td>
                                            <select class="form-control"
        required
        name="metode"
        id="metode">

    <option value="" disabled selected>
        - Metode Pembayaran -
    </option>

    <option value="Tunai">Tunai</option>
    <option value="Non tunai">Non tunai</option>
    <option value="Bayar Nanti">Bayar Nanti</option>

                </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Pesanan</th>
                                        <td>
                                            <select class="form-control" required name="pesanan" id="pesanan">
                                            <option value="" disabled selected>- Jenis Pesanan -</option>
                                             <option value="Dine In">Dine In</option>
                                             <option value="Take Away">Take Away</option>
                                            <option value="Delivery">Delivery</option>
                </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total Bayar</th>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                                </div>
                                                <input type="text" value="0" class="form-control form-lg"
                                                    name="total_bayar" id="totalBayar" readonly>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                                <tr class="diskon">
                                    <th>Diskon</th>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" id="Diskon" value="0" min="0" max="100"
                                                class="form-control" name="diskon">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">%</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="pajak">
                                    <th>Pajak </th>
                                    <td>
                                        <div class="input-group">
                                            <input type="number" id="Pajak" value="0" min="0" max="100"
                                                class="form-control" name="pajak">
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="basic-addon2">%</span>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr class="voucher">
                                    <th>Voucher</th>

                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                            </div>
                                            <input type="number" step="any" id="rupiah" class="form-control" name="voucher">
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Grand Total</th>
                                    <td>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text" id="basic-addon1">Rp</span>
                                            </div>
                                            <input type="text" value="0" class="form-control form-lg" name="grandtotal"
                                                id="GrandTotal" readonly>
                                        </div>
                                    </td>
                                </tr>
                                <tbody class="dibayaraja">
                                    <tr>
                                        <th>Dibayar</th>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                                </div>
                                                <input type="text" id="rupiah1" autocomplete="off" class="form-control"
                                                    name="dibayar">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Kembali</th>
                                        <td>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                                </div>
                                                <input type="text" readonly class="form-control" id="kembaliBayar"
                                                    name="kembaliBayar">
                                            </div>
                                            <div id="LaporanKembali"></div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <button type="submit" id="prosesTransaksi" class="btn btn-success btn-lg btn-block mt-3">
                             <i class="fa fa-check-circle mr-2"></i>
                             Simpan Transaksi
                            </button>

                            <!--
<button type="button"
        class="btn btn-info"
        id="bayarMidtrans">
    Bayar Midtrans
</button>
-->
                            
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="modelId1" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-shopping-cart"></i> Keranjang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-0">
                <div id="cart_modal"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Data Customer</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table id="example2" style="font-size:10pt;" class="table table-bordered table-striped table"
                        width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Customer</th>
                                <th>Nama Customer</th>
                                <th>HP/WA</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
<div id="tampilkan"></div>
<!-- Modal -->
<div class="modal fade" id="cetak-edit" tabindex="-1" role="dialog" data-toggle="modal" data-backdrop="static"
    data-keyboard="false">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" id="edit-content">

        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modelIdWA" style="margin-top:5pc;" tabindex="1" role="dialog" data-toggle="modal"
    data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h5 class="modal-title text-white">Kirim Ke WhatsApp</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="get" action="https://api.whatsapp.com/send" target="_blank">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">No WhatsApp</label>
                        <input type="number" value="628" name="phone" autocomplete="off" id="phone" class="form-control"
                            placeholder="" aria-describedby="helpId">
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" name="text" id="text">
                    <button type="submit" class="btn btn-green">Kirim</button>
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button> -->
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$('#cart_keranjang').load('<?= base_url('kasir/cart');?>');
$('#cart_modal').load('<?= base_url('kasir/cart_table');?>');

// $('.dibayaraja').hide();
// $(document).ready(function() {
//     $('#status').change(function() {
//         var cek = $(this).val();
//         if (cek == 'Lunas') {
//             $('.dibayaraja').show();
//         } else if (cek == 'Debit') {
//             $('.dibayaraja').show();
//         } else if (cek == 'Debit BCA') {
//             $('.dibayaraja').show();
//         } else if (cek == 'Debit Mandiri') {
//             $('.dibayaraja').show();
//         } else if (cek == 'Debit BNI') {
//             $('.dibayaraja').show();
//         } else {
//             $('.dibayaraja').hide();
//             $('#rupiah1').val('0');
//         }
//     });
// });


$('.dibayaraja').hide();
$(document).ready(function() {
    $('#metode').change(function() {
        var cek = $(this).val();
        if (cek == 'Tunai') {
            $('.dibayaraja').show();
        } else if (cek == 'Non tunai') {
            $('.dibayaraja').show();
            $("#rupiah1").val($("#GrandTotal").val());
        } else {
            $('.dibayaraja').hide();
            $('#rupiah1').val('0');
        }
    });
});


</script>
<?php
    if((int)$this->input->get('id'))
    {
        $url = base_url('menu/data_menu?id='.(int)$this->input->get('id'));
    }else{ 
        $url = base_url('menu/data_menu');
    }

    if($pp->diskon == 0){
?>
<script>
$('.diskon').hide();
</script>
<?php } if($pp->voucher == 0){?>
<script>
$('.voucher').hide();
</script>
<?php } if($pp->pajak == 0){?>
<script>
$('.pajak').hide();
$('.pajak').val(0);
</script>
<?php }else{?>
<script>
$(document).ready(function() {
    $('#Pajak').val(<?= $pp->pajak_default ?? 0;?>);
    setInterval(function() {
        hitungDiskonPajakTotal();
    }, 1000);
});
</script>
<?php }?>
<script>
var tabel = null;
var base_url = "<?= base_url('');?>";
$(document).ready(function() {
    $.fn.dataTable.ext.errMode = 'none';
    tabel = $('#example2').DataTable({
        "processing": true,
        "serverSide": true,
        'responsive': true,
        "ordering": true, // Set true agar bisa di sorting
        "order": [
            [0, 'desc']
        ], // Default sortingnya berdasarkan kolom / field ke 0 (paling pertama)
        "ajax": {
            "url": "<?= base_url('customer/data_customer');?>", // URL file untuk proses select datanya
            "type": "POST"
        },
        "deferRender": true,
        "aLengthMenu": [
            [10, 25, 50],
            [10, 25, 50]
        ], // Combobox Limit
        "columns": [{
                "data": 'id',
                "sortable": false,
                render: function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                'data': 'kode_customer'
            },
            {
                'data': 'nama'
            },
            {
                'data': 'hp'
            },
            {
                "data": "id",
                "render": function(data, type, row, meta) {
                    return `<a href="javascript:void(0)" data-id="${row.id}" 
                                    class="btn btn-green btn-sm cek_pilih" title="Pilih Customer" role="button">
                                    <i class="fa fa-user-plus"></i>
                                </a>`;
                }
            },
        ],
    });
});
$('#example2 tbody').on('click', '.cek_pilih', function(e) {
    var id = $(this).attr('data-id');
    $.ajax({
        url: "<?= base_url('customer/cek_customer');?>",
        type: "POST",
        data: {
            "id": id
        },
        timeout: 6000,
        dataType: "json",
        beforeSend: function() {

        },
        success: function(data) {
            $('#pelanggan_id').val(data[0].id);
            $('#pelanggan').val(data[0].nama);
            $('#atas_nama').val(data[0].nama);
            $('#modelId').modal('hide');
        },
        'error': function(xmlhttprequest, textstatus, message) {
            if (textstatus === "timeout") {
                alert("request timeout");
            } else {
                alert("request timeout");
            }
        }
    });
});
</script>
<script>
$(document).ready(function () {

    function simpanTransaksi(form){

        $.ajax({
            url: "<?= base_url('kasir/store');?>",
            type: "POST",
            data: new FormData(form),
            processData: false,
            contentType: false,
            cache: false,
            beforeSend:function(){

                $("#prosesTransaksi").prop("disabled",true);

                $("#prosesTransaksi").html(
                    '<i class="fas fa-circle-notch fa-spin"></i> Loading'
                );

            },
            success:function(result){

                if(result=="Kurang"){

                    Swal.fire({
                        icon:'error',
                        title:'Oops...',
                        text:'Pembayaran Anda Kurang Dari Total Bayar!'
                    });

                    $("#prosesTransaksi").prop("disabled",false);

                    $("#prosesTransaksi").html(
                        '<i class="fa fa-save"></i> Simpan Transaksi'
                    );

                    return;
                }

                $("#prosesTransaksi").prop("disabled",false);

                $("#prosesTransaksi").html(
                    '<i class="fa fa-save"></i> Simpan Transaksi'
                );

                $("#AddKasir")[0].reset();

                $("#example1").DataTable().ajax.reload();

                $("#cart_keranjang").load("<?= base_url('kasir/cart');?>");

                $("#cart_modal").load("<?= base_url('kasir/cart_table');?>");

                var url_add =
                    "<?= base_url('kasir/show?id=');?>"+result;

                $.ajax({

                    url:url_add,

                    success:function(html){

                        $('.modal').css('overflow-y','auto');

                        $("#cetak-edit").modal("show");

                        $("#edit-content").html(html);

                    }

                });

            }

        });

    }


    $("#AddKasir").submit(function(e){

        e.preventDefault();

        var metode=$("#metode").val();

        if(metode=="Non tunai"){

            $.ajax({

                url:"<?= base_url('kasir/snapToken');?>",

                type:"POST",

                data:{
                    order_id:$("#no_bon").val(),
                    grandtotal:$("#GrandTotal").val(),
                    atas_nama:$("#atas_nama").val()
                },

                dataType:"json",

                success:function(res){

                    if(res.status){

                        snap.pay(res.token,{

                            onSuccess:function(result){

                                simpanTransaksi($("#AddKasir")[0]);

                            },

                            onPending:function(result){

                                console.log(result);

                            },

                            onError:function(result){

                                console.log(result);

                            },

                            onClose:function(){

                                console.log("Popup ditutup");

                            }

                        });

                    }else{

                        Swal.fire({

                            icon:"error",

                            title:"Midtrans",

                            text:res.message

                        });

                    }

                }

            });

            return;

        }

        simpanTransaksi(this);

         });

    });

</script>

<script>
$('#rupiah1').trigger('focus');
$(document).ready(function() {
    $('#bayarKasir').click(function() {
        hitungDiskonPajakTotal();
        var totTotG = bayarOrder();
        var HrgTot = totTot.replace(/\D/g, '');
        if (HrgTot >= 0) {
            $("#kembaliBayar").val(totTotG);
            $('#LaporanKembali').html('');
            $('#prosesTransaksi').attr('disabled', false);

        } else {
            $("#kembaliBayar").val(totTotG);
            $('#LaporanKembali').html(
                '<span style="color:red; font-weight:700">*  PEMBAYARAN BELUM CUKUP! </span>');
            $('#prosesTransaksi').attr('disabled', true);
        }
    });
    $('#pelanggan').change(function() {
        var pl = $(this).val();
        if (pl == '') {
            $('#pelanggan_id').val('0');
        }
    });
});
</script>
<script>
$(document).ready(function() {
    $('#rupiah1').bind("keyup change", function() {
        $(this).val(formatRupiah($(this).val(), ''));
        var totTot = bayarOrder();
        var HrgTot = totTot.replace(/\D/g, '');
        if (HrgTot >= 0) {
            $("#kembaliBayar").val(totTot);
            $('#LaporanKembali').html('');
            // $('#prosesTransaksi').attr('disabled',false);
        } else {
            $("#kembaliBayar").val(totTot);
            $('#LaporanKembali').html(
                '<span style="color:red; font-weight:700">*  PEMBAYARAN BELUM CUKUP! </span>');
            // $('#prosesTransaksi').attr('disabled', true);
        }
    });
});
</script>
<script>
$(document).ready(function() {
    $('#Diskon').bind("keyup change", function() {
        hitungDiskonPajakTotal();
    });
});
$(document).ready(function() {
    $('#Pajak').bind("keyup change", function() {
        hitungDiskonPajakTotal();
    });
});
$(document).ready(function() {
    $('#rupiah').bind("keyup change", function() {
        $(this).val(formatRupiah($(this).val(), ''));
        hitungDiskonPajakTotal();
    });
});
    $("#bayarMidtrans").click(function(){

    console.log("Tombol Bayar Midtrans diklik");

    console.log("ORDER :", $("#no_bon").val());
    console.log("TOTAL :", $("#GrandTotal").val());
    console.log("NAMA  :", $("#atas_nama").val());

    $.ajax({

        url:"<?= base_url('kasir/snapToken');?>",

        type:"POST",

        data:{
            order_id:$("#no_bon").val(),
            grandtotal:$("#GrandTotal").val(),
            atas_nama:$("#atas_nama").val()
        },

        dataType:"json",

        success:function(res){

            console.log("TOKEN BARU");

         console.log(res);


            if(res.status){

                console.log("Memanggil snap.pay");

                snap.pay(res.token,{
                    onSuccess:function(result){
                        console.log("SUCCESS",result);
                    },
                    onPending:function(result){
                        console.log("PENDING",result);
                    },
                    onError:function(result){
                        console.log("ERROR",result);
                    },
                    onClose:function(){
                        console.log("POPUP DITUTUP");
                    }
                });

            }else{

                console.log(res.message);

            }

        },

        error:function(xhr){

            console.log(xhr.responseText);

        }

    });

});

function bayarOrder() {
    var hargaTot = $("#GrandTotal").val();
    var dibayar = $('#rupiah1').val();
    var HrgTot = hargaTot.replace(/\D/g, '');
    var Hrgdibayar = dibayar.replace(/\D/g, '');

    var totHvG = parseInt(Hrgdibayar) - parseInt(HrgTot);
    var totTot = formatRupiah(totHvG, '');
    return totTot;
}

function hitungDiskonPajakTotal(){

    var hargaTot = $("#totalBayar").val();
    var diskon = parseFloat($("#Diskon").val()) || 0;
    var pajak = parseFloat($("#Pajak").val()) || 0;

    var voucher = $("#rupiah").val();

    var HrgTot = parseFloat(hargaTot.replace(/\D/g,'')) || 0;
    var HrgVoucher = parseFloat(voucher.replace(/\D/g,'')) || 0;

    // Hitung nominal diskon
    var totalDiskon = HrgTot * (diskon/100);

    // Total setelah diskon
    var subtotal = HrgTot - totalDiskon;

    // Hitung pajak dari subtotal
    var totalPajak = subtotal * (pajak/100);

    // Grand Total
    var grandTotal = subtotal + totalPajak - HrgVoucher;

    if(grandTotal < 0){
        grandTotal = 0;
    }

    $("#GrandTotal").val(formatRupiah(Math.round(grandTotal),''));
    console.log("Function hitungDiskonPajakTotal berhasil dimuat");

}
</script>

<script>
/* Fungsi formatRupiah */
function formatRupiah(angka, prefix) {

    if (typeof angka === 'string') {
        angka = angka.replace(/[^,\d]/g, '');
    } else if (typeof angka === 'number') {
        angka = angka.toString();
    } else {
        return '0';
    }

    var split = angka.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        var separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] !== undefined
        ? rupiah + ',' + split[1]
        : rupiah;

    return prefix === undefined ? rupiah : rupiah;
}
</script>

<script
    type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="<?= $this->config->item('client_key','midtrans'); ?>">
</script>