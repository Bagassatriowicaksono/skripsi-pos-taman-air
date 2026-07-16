<div class="clearfix"></div>
<div id="home" class="home">
    <div class="container mt-5 py-5">
        <div class="row">
            <div class="col-sm-7 mx-auto">
                <?php 
                    if(!empty($this->session->flashdata('success'))){  
                       echo alert_success($this->session->flashdata('success')); 
                    }
                    if(!empty($this->session->flashdata('failed'))){ 
                       echo alert_failed($this->session->flashdata('failed'));
                    }
                ?>
                <form method="POST" action="<?= base_url('customer/store');?>">
                    <div class="card card-rounded">
                        <div class="card-header bg-success text-white">
                            <?= $title_web;?>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Kode Customer</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" value="<?= $kode;?>" name="kode_customer"
                                        id="kode_customer" placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Nama Customer</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" required name="nama" id="nama"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="alamat" id="alamat" placeholder=""></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">No HP / WA</label>
                                <div class="col-sm-9">
                                    <input type="number" value="628" class="form-control" name="hp" id="hp"
                                        placeholder="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-sm-3 col-form-label">Keterangan</label>
                                <div class="col-sm-9">
                                    <textarea class="form-control" name="keterangan" id="keterangan"
                                        placeholder=""></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-muted">
                            <div class="float-right">
                                <button type="submit" class="btn btn-success btn-md">
                                    Simpan</button>
                                <a href="<?= base_url('customer');?>" class="btn btn-danger btn-md">
                                    Kembali</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>