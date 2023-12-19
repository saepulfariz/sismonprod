<script src="<?= base_url(); ?>public/assets/static/js/components/dark.js"></script>
<script src="<?= base_url(); ?>public/assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>

<script src="<?= base_url(); ?>public/assets/compiled/js/app.js"></script>

<script src="<?= base_url(); ?>public/assets/extensions/jquery/jquery.min.js"></script>
<script src="<?= base_url(); ?>public/assets/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url(); ?>public/assets/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>

<script src="<?= base_url(); ?>public/assets/static/js/pages/datatables.js"></script>

<script src="<?= base_url(); ?>public/assets/extensions/sweetalert2/sweetalert2.min.js"></script>

<script src="<?= base_url(); ?>public/assets/extensions/summernote/summernote-bs5.min.js"></script>

<?= initAlert(); ?>
<script>
  document.querySelector('.burger-btn').addEventListener('click', function() {
    var activeSide = document.querySelector('#sidebar.active');
    if (activeSide) {
      document.querySelector('#sidebar').classList.remove('inactive');
    } else {
      document.querySelector('#sidebar').classList.add('inactive');
    }
  })

  function previewImage(input, previewDom) {

    if (input.files && input.files[0]) {

      $(previewDom).show();

      var reader = new FileReader();

      reader.onload = function(e) {
        $(previewDom).find('img').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    } else {
      $(previewDom).hide();
    }

  }

  $("#table-roles").DataTable({
    responsive: true,
    "pageLength": -1,
    "lengthMenu": [
      [5, 100, 1000, -1],
      [5, 100, 1000, "ALL"],
    ],
  })
</script>
<?= $this->renderSection('script'); ?>
</body>

</html>