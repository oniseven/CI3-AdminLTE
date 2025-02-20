  <!-- Main Footer -->
  <?php if($show['footer'] === true) { ?>
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Anything you want
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong> All rights reserved.
  </footer>
  <?php } ?>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<script>
  const pageUrl = '<?=current_url()?>'
</script>
<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Vendors App -->
<!-- Sweet Alert 2 -->
<script src="assets/plugins/sweetalert2/sweetalert2.min.js"></script>
<?php
  foreach ($plugin_js as $key => $value) {
    echo sprintf('<script src="%s"></script>', $value);
  }
?>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
<script src="assets/dist/js/cignadlte.js"></script>
<script src="assets/plugins/custom_jquery_ajax.js"></script>
<!-- Current Custom Page JS -->
<?php
  foreach ($page_js as $key => $value) {
    echo sprintf('<script src="%s"></script>', $value);
  }
?>
</body>
</html>
