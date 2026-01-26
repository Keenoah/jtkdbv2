<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert alert-success alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert" style="background-color: #ecfdf5; color: #065f46; border-left: 5px solid #10b981 !important;">
    <div class="d-flex align-items-center">
        <i class="bi bi-check-circle-fill fs-4 me-3 text-success"></i>
        <div>
            <h6 class="fw-bold mb-0">Success</h6>
            <div class="small"><?= $message ?></div>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>