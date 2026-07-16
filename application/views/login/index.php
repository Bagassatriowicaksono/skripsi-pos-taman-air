<!doctype html>
<html lang="en">

<head>
    <title>Login</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?= base_url('assets/plugins/bootstrap/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/login.css?v='.time());?>" />
</head>
<style>

body{
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    font-family:'Segoe UI',sans-serif;
}

.container.card{

    width:1100px;

    height:620px;

    border:none;

    border-radius:24px;

    overflow:hidden;

    box-shadow:0 20px 45px rgba(0,0,0,.25);

    padding:0;

}

.login-image{

    width:100%;

    height:620px;

    object-fit:cover;

    object-position:center center;

    display:block;

}

.login-left{

    display:flex;

    justify-content:center;

    align-items:center;

    padding:0;

    overflow:hidden;

    border-radius:22px 0 0 22px;

    background:#fff;

}

.card-body{

    height:620px;

    padding:55px 55px;

    display:flex;

    flex-direction:column;

    justify-content:center;

}

.row.no-gutters{

    height:620px;

}

.col-lg-4{

    overflow:hidden;

}

.col-lg-8{

    display:flex;

    align-items:center;

}

.card-header{

    border:none;

    background:transparent;

    margin-bottom:35px;

    text-align:center;

}

.card-header img{

    width:125px;

    height:auto;

    display:block;

    margin:0 auto 22px auto;

    transition:.3s;

}

.card-header h6{

    font-size:15px;

    letter-spacing:5px;

    color:#777;

    margin-bottom:10px;

}

.card-header h4{

    font-size:46px;

    font-weight:700;

    letter-spacing:5px;

    color:#173B63;

    margin:0;

}

.form-control{

    height:50px;

    border-radius:12px;

}

.btn-success{

    width:100%;

    height:50px;

    border-radius:12px;

    font-size:17px;

    font-weight:bold;

}

.btn-success:hover{

    transform:translateY(-2px);

    transition:.25s;

    box-shadow:0 8px 20px rgba(40,167,69,.25);

}

</style>
<body style="background:linear-gradient(135deg,#2E7D32,#43A047);">

<div class="container-fluid d-flex align-items-center justify-content-center" style="min-height:100vh;">

    <div class="container card">

        <?php if(!empty($this->session->flashdata('failed'))){?>
        <div class="alert alert-danger alert-dismissible fade show mb-0" role="alert">
            <?= $this->session->flashdata('failed');?>
        </div>
        <?php }?>

        <div class="row no-gutters h-100">

            <!-- FOTO -->
            <div class="col-lg-5 p-0">

                <img
                    src="<?= base_url('assets/image/taman.png');?>"
                    class="login-image"
                    alt="Taman Air">

            </div>

            <!-- FORM LOGIN -->
            <div class="col-lg-7 d-flex align-items-center">

                <div class="card-body w-100">

                    <div class="card-header text-center">

                        <img
                            src="<?= base_url('assets/image/taman_air_logo.png');?>"
                            alt="Logo">

                        <h6>EATERY &amp; REFLEXOLOGY</h6>

                        <h4>TAMAN AIR</h4>

                    </div>

                    <form method="POST" action="<?= base_url('login/proses');?>">

                        <div class="form-group">

                            <label>Username</label>

                            <input
                                type="text"
                                class="form-control"
                                autocomplete="off"
                                required
                                name="user"
                                placeholder="Masukkan Username">

                        </div>

                        <div class="form-group">

                            <label>Password</label>

                            <input
                                type="password"
                                class="form-control"
                                autocomplete="off"
                                required
                                name="pass"
                                placeholder="Masukkan Password">

                        </div>

                        <button type="submit" class="btn btn-success">

                            Masuk ke Sistem

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

var alertElement=document.querySelector('.alert');

if(alertElement){

setTimeout(function(){

alertElement.remove();

},2000);

}

</script>

<script src="<?= base_url('assets/js/jquery-3.3.1.min.js');?>"></script>
<script src="<?= base_url('assets/plugins/bootstrap/popper.min.js');?>"></script>
<script src="<?= base_url('assets/plugins/bootstrap/js/bootstrap.min.js');?>"></script>

</body>
</html>