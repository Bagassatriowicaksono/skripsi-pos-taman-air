<div class="clearfix"></div>
<div id="home" class="home">
    <div class="container mt-5 py-5">
        <?php 
            if(!empty($this->session->flashdata('success'))){  
                echo alert_success($this->session->flashdata('success')); 
            }
            if(!empty($this->session->flashdata('failed'))){ 
                echo alert_failed($this->session->flashdata('failed'));
            }
        ?>
        <div class="row">
            <div class="col-lg-4">
                <form method="post" action="<?= $url;?>">
                    <div class="card mt-4 card-rounded">
                        <div class="card-header bg-success text-white">
                            <?php if(!empty($this->input->get('id'))){?>
                            Edit Kategori
                            <?php }else{?>
                            Tambah Kategori
                            <?php }?>
                        </div>
                        <div class="card-body">
                            <?php if(!empty($this->input->get('id'))){?>
                            <div class="form-group">
                                <label for="">Nama Kategori</label>
                                <input type="text" required class="form-control" value="<?= $edit->kategori;?>"
                                    name="kategori" id="kategori" placeholder="">
                            </div>
                            <input type="hidden" name="id" value="<?= $edit->id;?>">
                            <?php }else{?>
                            <div class="form-group">
                                <label for="">Nama Kategori</label>
                                <input type="text" required class="form-control" name="kategori" id="kategori"
                                    placeholder="">
                            </div>
                            <?php }?>
                        </div>
                        <div class="card-footer text-muted">
                            <div class="float-right">
                                <!-- <button class="btn btn-success btn-md">Simpan</button> -->
                                <button type="submit" class="btn btn-success" id="proses">
                                    <?php if(!empty($this->input->get('id'))){?>
                                    Edit
                                    <?php }else{?>
                                    Simpan
                                    <?php }?>
                                </button>
                                <?php if(!empty($this->input->get('id'))){?>
                                <a href="<?= base_url('kategori');?>" class="btn btn-danger btn-md">Kembali</a>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-8">
                <div class="card mt-4 card-rounded">
                    <div class="card-header bg-success text-white">
                        Daftar Kategori
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table" id="table1">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Kategori</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $no =1;
                                        foreach($kat as $r){
                                    ?>
                                    <tr>
                                        <td scope="row"><?= $no;?></td>
                                        <td><?= $r->kategori;?></td>
                                        <td>
                                            <a href="<?= base_url('kategori?id='.$r->id);?>"
                                                class="btn btn-success btn-sm">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <?php if($r->id > 1){?>
                                            <a href="<?= base_url('kategori/delete?id='.$r->id);?>"
                                                class="btn btn-danger btn-sm"
                                                onclick="javascript:return confirm('Apakah Kategori ingin dihapus ?')">
                                                <i class="fa fa-times"></i>
                                            </a>
                                            <?php }?>
                                        </td>
                                    </tr>
                                    <?php $no++; }?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>