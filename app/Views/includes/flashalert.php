<div class="toast-container position-fixed bottom-0 end-0 p-3">

  <?php if (session()->getFlashdata('success')): ?>
  <div id="flashToastSuccess" class="toast align-items-center text-bg-success border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body">
        <?= session()->getFlashdata('success') ?>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
  <script>
    bootstrap.Toast.getOrCreateInstance(document.getElementById('flashToastSuccess'), { delay: 3000 }).show();
  </script>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
  <div id="flashToastError" class="toast align-items-center text-bg-danger border-0" role="alert">
    <div class="d-flex">
      <div class="toast-body">
        <?= session()->getFlashdata('error') ?>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
  <script>
    bootstrap.Toast.getOrCreateInstance(document.getElementById('flashToastError'), { delay: 3000 }).show();
  </script>
  <?php endif; ?>

</div>