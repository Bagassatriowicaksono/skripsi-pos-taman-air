
        <div class="clearfix"></div>
            <div id="home" class="home">
                <div class="container mt-5 py-5">
                    <button type="button" class="btn btn-green btn-md mt-2" data-toggle="modal" data-target="#modelIdFilter">
                        <i class="fa fa-search"></i> Pencarian
                    </button>
                    
                    <div class="row">
                        <div class="col-sm-12">
                            <br>
                            <div class="card card-rounded">
                                <div class="card-header bg-success text-white">
                                    <?= $title_web; ?>
                                    <?= $periode; ?>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="example1" class="table table-bordered table-striped table" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Kode Menu</th>
                                                    <th>Nama Menu</th>
                                                    <th>Kategori</th>
                                                    <th>Jumlah Terjual</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (!empty($transaksi)) : ?>
                                                    <?php $no = 1; ?>
                                                    <?php foreach ($transaksi as $r) : ?>
                                                        <tr>
                                                            <td><?= $no++; ?></td>
                                                            <td><?= $r->kode_menu; ?></td>
                                                            <td><?= $r->nama_menu; ?></td>
                                                            <td><?= $r->kategori; ?></td>
                                                            <td><?= $r->qty_terjual; ?></td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <tr>
                                                        <td colspan="5">Tidak ada data transaksi.</td>
                                                    </tr>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    <!-- Modal Pencarian Periode Waktu -->
    <div class="modal fade" id="modelIdFilter" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title"><b>Pencarian Data</b></h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="GET" action="<?= base_url('laporan/laris'); ?>">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Tanggal Start</label>
                            <input type="date" class="form-control" required value="<?= $this->input->get('a') ?>" name="a">
                        </div>
                        <div class="form-group">
                            <label for="">Tanggal End</label>
                            <input type="date" class="form-control" required value="<?= $this->input->get('b') ?>" name="b">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-green">Cari</button>
                        <!-- Optional: Tombol untuk menutup modal -->
                        <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Tutup</button> -->
                    </div>
                </form>
            </div>
        </div>
    </div>



        <!-- Include jQuery and DataTables JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <script>
            var tabel = null;
            var base_url = "<?= base_url('');?>";
            $(document).ready(function() {
                $.fn.dataTable.ext.errMode = 'none';
                tabel = $('#example1').DataTable({
                    "processing": true,
                    "serverSide": false, // Jika menggunakan serverSide false, maka DataTables akan mengambil semua data di client side
                    'responsive': true,
                    "ordering": true,
                    "order": [[0, 'asc']],
                    "deferRender": true,
                    "aLengthMenu": [
                        [10, 25, 50, 100, 150],
                        [10, 25, 50, 100, 150]
                    ],
                    "columns": [
                        { "data": null, "sortable": false, render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }},
                        { 'data': 'kode_menu' },
                        { 'data': 'nama_menu' },
                        { 'data': 'kategori' },
                        { 'data': 'qty_terjual' }
                    ]
                });
            });
        </script>
</body>
</html>
