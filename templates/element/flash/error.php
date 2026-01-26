<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert alert-danger alert-dismissible fade show shadow-sm border-0 rounded-3 mb-4" role="alert" style="background-color: #fef2f2; color: #991b1b; border-left: 5px solid #ef4444 !important;">
    <div class="d-flex align-items-center">
        <i class="bi bi-x-circle-fill fs-4 me-3 text-danger"></i>
        <div>
            <h6 class="fw-bold mb-0">Action Failed</h6>
            <div class="small"><?= $message ?></div>
        </div>
    </div>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>