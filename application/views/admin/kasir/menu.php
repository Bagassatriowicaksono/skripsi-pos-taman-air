<style>

.menu-container{
    display:flex;
    flex-wrap:wrap;
    justify-content:flex-start;
    align-items:flex-start;
    gap:15px;
}

/* 4 menu per baris */
.menu-item{
    flex:0 0 calc(25% - 12px);
    max-width:calc(25% - 12px);
}

/* CARD */
.btn-menu{

    width:100%;
    height:340px;

    display:flex;
    flex-direction:column;
    align-items:center;

    background:#fff;

    border:1px solid #dcdcdc;
    border-radius:12px;

    padding:10px;

    transition:.25s;
}

.btn-menu:hover{

    transform:translateY(-3px);

    box-shadow:0 6px 18px rgba(0,0,0,.15);

    border-color:#28a745;
}

/* GAMBAR */
.menu-img{

    width:100%;
    height:165px;

    object-fit:contain;

    background:#fff;

    border-radius:10px;

    margin-bottom:10px;
}

/* TIDAK ADA GAMBAR */

.menu-kosong{

    width:100%;
    height:165px;

    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;

    margin-bottom:10px;

    color:#999;
}

.menu-kosong i{

    font-size:60px;

    margin-bottom:8px;
}

/* KATEGORI */

.menu-kategori{

    font-size:13px;

    color:#6c757d;

    margin-bottom:6px;
}

/* NAMA MENU */

.menu-nama{

    font-size:15px;

    font-weight:bold;

    line-height:22px;

    color:#222;

    height:44px;

    overflow:hidden;

    display:-webkit-box;

    -webkit-line-clamp:2;

    -webkit-box-orient:vertical;

    margin-bottom:8px;
}

/* HARGA */

.menu-harga{

    margin-top:auto;

    font-size:18px;

    font-weight:bold;

    color:#28a745;
}

</style>


<div class="menu-container">

<?php foreach($hasil as $r){ ?>

<div class="menu-item">

<button
class="btn-menu pilih"
data-id="<?= $r->id;?>">

<?php

if($r->gambar != '-'){

    if(file_exists(FCPATH.'assets/image/produk/'.$r->gambar)){

?>

<img
src="<?= base_url('assets/image/produk/'.$r->gambar);?>"
class="menu-img">

<?php

    }

}else{

?>

<div class="menu-kosong">

<i class="fa fa-image"></i>

<b>Tidak Ada Gambar</b>

</div>

<?php } ?>

<div class="menu-kategori">

( <?= $r->kategori;?> )

</div>

<div class="menu-nama">

<?= $r->nama;?>

</div>

<div class="menu-harga">

Rp<?= number_format($r->harga);?>,-

</div>

</button>

</div>

<?php } ?>

</div>


<script>

$('.pilih').click(function(){

var id=$(this).data('id');

$.ajax({

url:"<?= base_url('kasir/add_cart');?>",

type:"POST",

data:{id:id},

dataType:"json",

timeout:6000,

success:function(data){

if(data.status=='gagal'){

Swal.fire({

icon:'error',

title:'Gagal',

text:'Menu telah mencapai stok limit!'

});

}else{

$('#cart_keranjang').load('<?= base_url('kasir/cart');?>');

$('#cart_modal').load('<?= base_url('kasir/cart_table');?>');

Swal.fire({

icon:'success',

title:'Berhasil',

text:'Menu berhasil ditambahkan ke keranjang!'

});

}

},

error:function(){

Swal.fire({

icon:'error',

title:'Error',

text:'Request Timeout'

});

}

});

});

</script>