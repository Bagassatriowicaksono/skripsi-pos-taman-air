<style>

#keranjang\@{

    border-radius:12px;

    overflow:hidden;

    border:1px solid #e9ecef;

}

#keranjang\@ thead{

    background:#28a745;

    color:#fff;

}

#keranjang\@ thead th{

    border:none;

    padding:12px 8px;

    text-align:center;

    font-size:13px;

    font-weight:700;

}

#keranjang\@ tbody td{

    vertical-align:middle;

    padding:12px 8px;

    font-size:14px;

}

#keranjang\@ tbody tr{

    transition:.2s;

}

#keranjang\@ tbody tr:hover{

    background:#f5fff7;

}

.nama-menu{

    font-size:15px;

    font-weight:bold;

    color:#222;

}

.kode-menu{

    font-size:12px;

    color:#888;

}

.qty-box{

    display:flex;

    align-items:center;

    justify-content:center;

    gap:6px;

}

.qty-box input{

    width:45px;

    text-align:center;

    border-radius:8px;

    border:1px solid #ddd;

    height:34px;

}

.qty-btn{

    width:30px;

    height:30px;

    border-radius:50%;

    display:flex;

    justify-content:center;

    align-items:center;

    font-weight:bold;

    cursor:pointer;

}

.subtotal{

    color:#28a745;

    font-weight:bold;

    white-space:nowrap;

}

.btn-delete{

    width:34px;

    height:34px;

    border-radius:50%;

    display:flex;

    align-items:center;

    justify-content:center;

}

</style>

<div class="table-responsive">

<table class="table table-hover mb-0" id="keranjang@">

<thead>

<tr>

<th width="6%">No</th>

<th width="42%">Menu</th>

<th width="28%">Qty</th>

<th width="18%">Subtotal</th>

<th width="6%">Hapus</th>

</tr>

</thead>

<tbody>

<?php

$no=1;

foreach($items as $item){

if($item['kode_menu']==""){

}else{

?>

<tr>

<td class="text-center">

<?= $no;?>

</td>

<td>

<div class="kode-menu">

<?= $item['kode_menu'];?>

</div>

<div class="nama-menu">

<?= $item['nama'];?>

</div>

</td>

<td>

<div class="qty-box">

<a

href="javascript:void(0)"

data-minus1="<?= $item['id_menu'];?>"

class="badge badge-primary qty-btn minus1">

-

</a>

<input

type="number"

class="kr_sub1"

data-sub1="<?= $item['id_menu'];?>"

value="<?= $item['qty'];?>">

<a

href="javascript:void(0)"

data-plus1="<?= $item['id_menu'];?>"

class="badge badge-primary qty-btn plus1">

+

</a>

</div>

</td>

<td class="subtotal">

Rp<?= number_format($item['harga']*$item['qty']);?>

</td>

<td class="text-center">

<a

href="javascript:void(0)"

data-id="<?= $item['id_menu'];?>"

class="badge badge-danger btn-delete del_cart1">

<i class="fa fa-trash"></i>

</a>

</td>

</tr>

<?php

$no++;

}}

?>

</tbody>

</table>

</div>

<script>

$(document).ready(function(){

$('.del_cart1').on('click',function(){

var id=$(this).attr('data-id');

$.ajax({

url:"<?= base_url('kasir/del_cart');?>",

type:"POST",

data:{id_menu:id},

timeout:6000,

success:function(){

$('#cart_keranjang').load('<?= base_url('kasir/cart');?>');

$('#cart_modal').load('<?= base_url('kasir/cart_table');?>');

}

});

});

});

$('.minus1').on('click',function(){

var id=$(this).attr('data-minus1');

var qt=$('.kr_sub1').val()-1;

$.ajax({

url:'<?= base_url('kasir/update_cart?id=');?>'+id,

type:"POST",

data:{type:"minus",qt:qt},

success:function(html){

$('#cart_keranjang').load('<?= base_url('kasir/cart');?>');

$('#cart_modal').load('<?= base_url('kasir/cart_table');?>');

$('#tampilkan').html(html);

}

});

});

$('.kr_sub1').on('keyup',function(){

var id=$(this).attr('data-sub1');

var qt1=$(this).val();

$.ajax({

url:'<?= base_url('kasir/update_cart?id=');?>'+id,

type:"POST",

data:{type:"keyup",qt:qt1},

success:function(html){

$('#cart_keranjang').load('<?= base_url('kasir/cart');?>');

$('#cart_modal').load('<?= base_url('kasir/cart_table');?>');

$('#tampilkan').html(html);

}

});

});

$('.plus1').on('click',function(){

var id=$(this).attr('data-plus1');

var qt=$('.kr_sub1').val();

$.ajax({

url:'<?= base_url('kasir/update_cart?id=');?>'+id,

type:"POST",

data:{type:"plus",qt:qt},

success:function(html){

$('#cart_keranjang').load('<?= base_url('kasir/cart');?>');

$('#cart_modal').load('<?= base_url('kasir/cart_table');?>');

$('#tampilkan').html(html);

}

});

});

</script>