<div class="clearfix"></div>
<div class="footer-second" style="border-radius:0px;clear: both;">
    <div class="container">Copyright © <?= date('Y');?></div>
</div>
<!-- DATATABLES BS 4-->
<script>
$(document).ready(function() {
    $('#table1').DataTable({
        responsive: true
    });
});
</script>
<script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js');?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap4.min.js');?>"></script>
<script src="<?= base_url('assets/plugins/datatables/dataTables.responsive.min.js');?>"></script>
<script src="<?= base_url('assets/plugins/datatables/responsive.bootstrap4.min.js');?>"></script>
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="<?= $this->config->item('client_key'); ?>"></script>
</body>
</html>