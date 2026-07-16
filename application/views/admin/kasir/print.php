<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Cetak Struk</title>
    <!-- General CSS Files -->
    <style>
    html {
        font-family: 'Roboto', Arial, sans-serif;
        font-size: 8pt !important;
        line-height: 1.5 !important;
    }

    table {
        width: 100%;
        margin: 0;
        font-size: 8pt !important;
    }

    tr td {
        padding: 0 !important;
        font-size: 8pt !important;
    }

    .right {
        text-align: right;
    }

    center {
        margin: 0;
    }

    /* .doted {
        border-bottom: 1px solid #333;
    } */
    p.ridge {
        border-style: ridge;
        border-width: 2px;
    }

    </style>
</head>
<?php $user = $this->db->get_where('login',['id' => $t->kasir_id])->row();?>

<body class="receipt">
    <section>
        <br />
        <div style="text-align:center">
            <!-- <img src="<?= base_url('assets/image/'.$pp->driver);?>" alt="Logo" style="width:50px;"> -->
            <p><span style="font-size:10pt;"><?= $pp->nama_toko;?></span><br>
            <?= $pp->alamat_toko;?> <br>
            <?= $pp->telepon_toko;?></p>
        </div>
        <p class="ridge"></p>
        <table class="width:100%">
        <tr>
            <td>
                Atas Nama
            </td>
            <td>:</td>
            <td>
                <?= $t->atas_nama;?>
            </td>

            <td style="text-align:right">
                Receipt Code
            </td>
            <td style="text-align:right">:</td>
            <td style="text-align:right">
                <?= $t->no_bon;?>
            </td>
            <td> </td>
        </tr>
        <tr>
            <td>
                Kasir
            </td>
            <td>:</td>
            <td>
                <?= $user->nama_user;?>
            </td>

            <td style="text-align:right">
                Order Time
            </td>
            <td style="text-align:right">:</td>
            <td style="text-align:right">
                <?= $t->created_at;?>
            </td>
            <td> </td>
        </tr>
        <tr>
            <td>
                Jenis Pesanan
            </td>
            <td>:</td>
            <td>
                <?= $t->pesanan;?>
            </td>
        </tr>
        </table>
        
        <!-- Kasir : <?= $user->nama_user;?><br>
        Atas Nama : <?= $t->atas_nama;?><br>
        No Order : <?= $t->urut;?><br>
        Receipt Code : <?= $t->no_bon;?><br>
        Order Time : <?= $t->created_at;?> -->

        <p class="ridge"></p>
        <table>
            <?php $hr = 0; foreach($tp as $r){?>
            <tr>
                <td colspan="2">
                    <b><?= $r->nama_menu;?></b>
                </td>
            </tr>
            <tr>
                <td>
                    <?= number_format($r->harga);?> x<?= $r->qty;?>
                </td>
                <td style="text-align:right">
                    <?= number_format($r->qty * $r->harga);?>
                </td>
            </tr>
            <?php $hr += $r->harga * $r->qty; }?>
        </table>
        <p class="ridge"></p>
        <table>
            <tr>
                <td style="text-align:right;"><b>Sub Total     :</b></td>
                <td style="text-align:right">
                    <?= number_format($hr);?>
                </td>
            </tr>
            <!-- <?php if($pp->diskon > 0){
                $RPdiskon = $hr * $t->diskon / 100;
            ?>
            <tr class="diskon">
                <td style="text-align:right;"><b>Diskon     :</b></td>
                <td style="text-align:right">
                    <?= $t->diskon;?> % / <?= $RPdiskon;?>
                </td>
            </tr>
            <?php }?> -->
            <?php 
                if($pp->pajak > 0){
                    $RPpajak = $hr * $t->pajak / 100;
            ?>
            <tr class="pajak">
                <td style="text-align:right;"><b>Pajak <?= $t->pajak;?> %   :</b></td>
                <td style="text-align:right">
                    <?= $RPpajak;?>
                </td>
            </tr>
            <?php }?>
            <?php if($pp->voucher > 0){?>
            <tr class="voucher">
                <td style="text-align:right;"><b>Diskon     :</b></td>
                <td style="text-align:right">
                    <?= number_format($t->voucher);?>
                </td>
            </tr>
            <?php }?>
            <tr>
                <td style="text-align:right"><b>Total       :</b></td>
                <td style="text-align:right">
                    <?php
                        $diskon =  $hr * $t->diskon/100;
                        $pajak =  $hr * $t->pajak/100;
                        $grd = ( $hr - $t->voucher - $diskon) + $pajak;
                    ?>
                    <?= number_format($grd);?>
                </td>
            </tr>
            <tr></tr><tr></tr><tr></tr>
            <tr>
                <td style="text-align:right"><b>Dibayar     :</b></td>
                <td style="text-align:right">
                    <?= number_format($t->dibayar);?>
                </td>
            </tr>
            <tr>
                <td style="text-align:right"><b>Kembali     :</b></td>
                <td style="text-align:right">
                    <?= number_format($t->dibayar-$grd);?>
                </td>
            </tr>
        </table>
        <br>
        <center>
            <?= $t->dibayar > 0 ? '** PAID **<br>' : '';?>
            <?= $pp->footer_struk?>
        </center>
        <br>
    </section>
</body>

</html>