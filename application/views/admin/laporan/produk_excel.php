<?php
if($this->input->get('cetak') == 'print'){
  echo '<script>window.print();</script>';
}else{

  header("Pragma: public");
  header("Expires: 0");
  header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
  header("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
  header("Content-type:application/vnd.ms-excel");
  header("Content-disposition:attachment;filename=laporan_penjualan_".date('Y-m-d').".xls");
  header("Content-transfer-Encoding: binary ");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Excel</title>
    <?php
if($this->input->get('cetak') == 'print'){?>
    <style>
    #customers {
        font-family: Arial, Helvetica, sans-serif;
        font-size: 9pt;
        border-collapse: collapse;
        width: 100%;
    }

    #customers td,
    #customers th {
        border: 1px solid #333;
        padding: 5px;
    }

    #customers tr:nth-child(even) {
        background-color: #f2f2f2;
    }

    #customers tr:hover {
        background-color: #ddd;
    }

    #customers th {
        padding-top: 5px;
        padding-bottom: 5px;
        text-align: left;
        color: #333;
    }
    </style>
    <?php }?>
</head>

<body>
    LAPORAN PENJUALAN RUMAH MAKAN TAMAN AIR<br>
    <?= $periode;?>
    <table id="customers">
        <tr>
            <th>No</th>
            <th>Kode Menu</th>
            <th>Nama Menu</th>
            <th>Kategori</th>
            <th>Qty</th>
            <th>Harga</th>
            <th>Atas Nama</th>
            <th>Customer</th>
            <th>Kasir</th>
            <th>Jenis</th>
            <th>Metode</th>
            <th>Tanggal</th>
        </tr>
        <?php $no =1; $h = 0; $qty = 0; foreach($transaksi as $r){?>
        <tr>
            <td><?= $no;?></td>
            <td><?= $r->kode_menu;?></td>
            <td><?= $r->nama_menu;?></td>
            <td><?= $r->kategori;?></td>
            <td><?= $r->qty;?></td>
            <td><?= $r->harga * $r->qty;?></td>
            <td><?= $r->atas_nama;?></td>
            <td><?= $r->customer_id == 0 ? '-' : $r->nama;?></td>
            <td><?= $r->nama_user;?></td>
            <td><?= $r->pesanan;?></td>
            <td><?= $r->metode;?></td>
            <td><?= $r->date;?></td>
        </tr>
        <?php $no++; $h += $r->harga * $r->qty;; $qty += $r->qty; }?>
        <tr>
            <th colspan="4">Total</th>
            <th><?= $qty;?></th>
            <!-- <th>Rp<?= number_format($h ?? 0);?></th>
            <?php if($this->session->userdata('ses_level') == 'Admin'){?>
            <th>Keuntungan </th> -->
            <th colspan="7"> Rp<?= number_format($h ?? 0);?></th>
            <!-- <?php } else { echo '<th colspan="7"></th>'; }?> -->
<!-- 
            <th colspan="4">Total</th>
            <th><?= $total->qty;?></th>
            <th colspan="7">Rp<?= number_format($h ?? 0);?>,-</th> -->
        </tr>
        <tfoot>
         
    </table>
</body>

</html>