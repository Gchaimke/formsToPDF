<footer class="footer">
  <p>
    <center><div>גרעין מערכות&copy; <?php echo date('Y'); ?> |  נוצר על ידי חיים גורבוב</div>
    <?=$this->input->ip_address()?>
    </center>
  </p>
</footer>

<!-- Bootstrap core JavaScript
    ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/js/all.js?' . filemtime('assets/js/all.js')); ?>"></script>

<script src="<?php echo base_url('assets/js/jquery.jqscribble.js'); ?>" type="text/javascript"></script>
<?php
if (isset($js_to_load)) {
  if (is_array($js_to_load)) {
    foreach ($js_to_load as $row) {
      echo  "<script type='text/javascript' src='" . base_url("assets/js/$row") . "'></script>";
    }
  } else {
    echo  "<script type='text/javascript' src='" . base_url("assets/js/$js_to_load") . "'></script>";
  }
}
?>

</body>

</html>