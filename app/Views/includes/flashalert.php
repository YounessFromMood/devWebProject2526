<!-- Conteneur fixe en bas à droite -->
<div class="toast-container position-fixed bottom-0 end-0 p-3">

  <?php if (session()->getFlashdata('success')): ?>
  <div class="toast align-items-center text-bg-success border-0 show" role="alert">
    <div class="d-flex">
      <div class="toast-body">
        <?= session()->getFlashdata('success') ?>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')): ?>
  <div class="toast align-items-center text-bg-danger border-0 show" role="alert">
    <div class="d-flex">
      <div class="toast-body">
        <?= session()->getFlashdata('error') ?>
      </div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
    </div>
  </div>
  <?php endif; ?>
  
</div>