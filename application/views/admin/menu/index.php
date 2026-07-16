<style>
    
#example1 tbody td{
    vertical-align:middle;
}

#example1 tbody tr{
    height:170px;
}

.menu-img-admin{
    width:150px;
    height:150px;

    object-fit:contain;

    background:#fff;

    border-radius:12px;

    padding:6px;

    border:1px solid #e5e5e5;

    transition:.2s;
}

.menu-img-admin:hover{

    transform:scale(1.05);
}

</style>

<div class="clearfix"></div>
<div id="home" class="home">
    <div class="container mt-5 py-5">
        <!-- <a href="<?= base_url('menu/tambah'); ?>" class="btn btn-primary">
            <i class="fa fa-plus"> </i> Tambah Menu</a> -->
        <!-- <a href="<?= base_url('menu/import'); ?>" class="btn btn-success mr-2">
            <i class="fa fa-plus"> </i> Import Menu Excel</a>
        <div class="clearfix"></div> -->
        <br>
    

        <div class="card card-rounded">
            <div class="card-header bg-success text-white">
                <!-- <i class="fa fa-cubes"></i> -->
                <?= $title_web; ?>
                <a href="<?= base_url('menu/tambah'); ?>" class="btn btn-green ml-2"> Tambah Menu</a>

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table table-bordered table-striped table" width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Gambar</th>
                                <th>Kode Menu</th>
                                <th>Kategori</th>
                                <th>Nama Menu</th>
                                <th>Harga</th>
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
                "url": "<?= base_url('menu/data_menu'); ?>", // URL file untuk proses select datanya
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
                "data": "gambar",
                "render": function (data, type, row, meta) {
                    if (data == '-') {
                        return '<center><i class="fa fa-image fa-3x"></i> <br>' +
                            '<small><b> Tidak Ada Gambar !</b></small></center>';
                    } else {
                        return '<div id="portfolio">' +
                            '<div class="portfolio-item">' +
                            '<a href="' + base_url + 'assets/image/produk/' + data +
                            '" class="portfolio-popup">' +
                            '<img src="' + base_url + 'assets/image/produk/' + data +
                            '" class="menu-img-admin"/>'
                            '<div class="portfolio-overlay">' +
                            '' +
                            '</div>' +
                            '</a>' +
                            '</div>' +
                            '</div>';
                    }
                }
            },
            {
                'data': 'kode_menu'
            },
            {
                'data': 'kategori'
            },
            {
                'data': 'nama'
            },
            {
                data: 'harga',
                render: $.fn.dataTable.render.number(',', '.', 0, 'Rp')
            },
            {
                "data": "id",
                "render": function (data, type, row, meta) {
                    // return `<div class="dropdown open">
                    //         <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="triggerId" data-toggle="dropdown" aria-haspopup="true"
                    //             aria-expanded="false">
                    //                 <i class="fa fa-cog mr-1"></i>
                    //             </button>
                    //         <div class="dropdown-menu" aria-labelledby="triggerId">
                    //             <a href="${base_url}menu/detail/${row.id}" 
                    //                 class="dropdown-item" title="Detail Menu" role="button">
                    //                 <i class="fa fa-eye mr-1"></i> Detail 
                    //             </a>
                    //             <a href="${base_url}menu/edit/${row.id}" 
                    //                 class="dropdown-item" title="Edit Menu" role="button">
                    //                 <i class="fa fa-edit mr-1"></i> Edit 
                    //             </a>
                    //             <?php if ($this->session->userdata('ses_level') == 'Admin') { ?>
                    //                 <a href="${base_url}menu/delete?id=${row.id}" 
                    //                     onclick="javascript:return confirm('Apakah data ini di hapus ?');" 
                    //                     class="dropdown-item" title="Hapus Data Menu" role="button">
                    //                     <i class="fa fa-times mr-1"></i> Hapus 
                    //                 </a>
                    //             <?php } ?>
                    //         </div>
                    //     </div>
                    //     `;
                    return `<a href="${base_url}menu/detail/${row.id}" 
                                class="btn btn-green btn-sm" title="Detail Menu" role="button">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="${base_url}menu/edit/${row.id}" 
                                class="btn btn-success btn-sm" title="Edit Menu" role="button">
                                <i class="fa fa-edit"></i>
                            </a>
                            <?php if ($this->session->userdata('ses_level') == 'Admin') { ?>
                                <a href="${base_url}menu/delete?id=${row.id}" 
                                    onclick="javascript:return confirm('Apakah data ini di hapus ?');" 
                                        class="btn btn-danger btn-sm" title="Hapus Data Menu" role="button">
                                    <i class="fa fa-times"></i>
                                </a>`;
                            <?php } ?>

                }
            },
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