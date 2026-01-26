<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Officer> $officers
 */
?>

<div class="container-fluid px-4 py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0" style="color: var(--jtk-navy);">Officer Management</h4>
            <p class="text-muted small mt-1 mb-0">Manage staff assignments and units</p>
        </div>
        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary btn-sm fw-bold px-4 rounded-3 shadow-sm" style="background-color: var(--jtk-navy); border:none;">
            <i class="bi bi-plus-lg me-2"></i> Add Officer
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-2">
            <form method="get" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0 ps-3"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control border-start-0 border-end-0 ps-0" placeholder="Search officer name..." value="<?= h($search) ?>">
                    </div>
                </div>
                <div class="col-md-4 border-start">
                    <select name="department" class="form-select form-select-sm border-0">
                        <option value="">All Departments</option>
                        <?php foreach($departments as $d): ?>
                            <?php if(!empty($d->department)): ?>
                            <option value="<?= h($d->department) ?>" <?= $dept == $d->department ? 'selected' : '' ?>>
                                <?= h($d->department) ?>
                            </option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-sm w-100 fw-bold rounded-2 shadow-sm" style="background-color: var(--jtk-navy); border:none;">
                        Filter List
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php 
        $currentDept = null;
        if (count($officers) > 0):
    ?>
    <div class="card border-0 shadow-sm rounded-3 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light text-secondary small text-uppercase" style="letter-spacing: 0.5px;">
                    <tr>
                        <th class="ps-4 py-3 border-0">Officer Name</th>
                        <th class="py-3 border-0">Email</th>
                        <th class="py-3 border-0 text-center" style="width: 100px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($officers as $officer): ?>
                        
                        <?php 
                            // Header Row Logic
                            $thisDept = $officer->department ?: 'Unassigned';
                            if ($currentDept !== $thisDept): 
                                $currentDept = $thisDept;
                        ?>
                            <tr style="background-color: #e3f2fd; border-top: 1px solid #dee2e6;">
                                <td colspan="3" class="px-4 py-2">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="bi bi-diagram-3-fill text-primary small"></i>
                                        <span class="fw-bold text-uppercase small" style="color: #003366; letter-spacing: 0.5px;">
                                            <?= h($currentDept) ?>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        <?php endif; ?>

                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 35px; height: 35px;">
                                        <i class="bi bi-person-fill fs-5"></i>
                                    </div>
                                    <span class="fw-bold text-dark fs-6"><?= h($officer->name) ?></span>
                                </div>
                            </td>
                            <td class="text-muted small"><?= h($officer->email) ?></td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="<?= $this->Url->build(['action' => 'edit', $officer->id]) ?>" class="btn btn-sm btn-light border" title="Edit">
                                        <i class="bi bi-pencil-fill text-primary small"></i>
                                    </a>
                                    
                                    <button type="button" 
                                            class="btn btn-sm btn-light border text-danger" 
                                            title="Delete"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteOfficerModal"
                                            data-officer-name="<?= h($officer->name) ?>"
                                            data-delete-target="#delete-post-<?= $officer->id ?>">
                                        <i class="bi bi-trash-fill small"></i>
                                    </button>

                                    <div class="d-none">
                                        <?= $this->Form->postLink(
                                            'Delete',
                                            ['action' => 'delete', $officer->id],
                                            [
                                                'confirm' => false, // Disable browser alert
                                                'id' => 'delete-post-' . $officer->id // Unique ID to find it later
                                            ]
                                        ) ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="mt-3 d-flex justify-content-end">
        <nav>
            <ul class="pagination pagination-sm">
                <?= $this->Paginator->prev('«') ?>
                <?= $this->Paginator->numbers() ?>
                <?= $this->Paginator->next('»') ?>
            </ul>
        </nav>
    </div>

    <?php else: ?>
        <div class="text-center py-5 text-muted">
            <i class="bi bi-people display-4 mb-3 d-block opacity-25"></i>
            No officers found matching your search.
        </div>
    <?php endif; ?>
</div>

<div class="modal fade" id="deleteOfficerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header text-white border-0 rounded-top-4" style="background-color: var(--jtk-navy);">
                <h5 class="modal-title fw-bold">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> Confirm Deletion
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4 text-center">
                <div class="mb-3">
                    <i class="bi bi-trash-fill display-4 text-danger"></i>
                </div>
                <p class="mb-0 fs-6">
                    Are you sure you want to delete officer <br>
                    <strong id="modalOfficerName" class="fs-5"></strong>?
                </p>
                <p class="text-muted small mt-2">This action cannot be undone.</p>
            </div>
            <div class="modal-footer border-0 p-4 justify-content-center gap-2">
                <button type="button" class="btn btn-light border fw-bold px-4 rounded-3" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="confirmDeleteBtn" class="btn btn-danger fw-bold px-4 rounded-3" style="background-color: #dc3545; border: none;">
                    Delete Officer
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const deleteModal = document.getElementById('deleteOfficerModal');
        const modalOfficerName = document.getElementById('modalOfficerName');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        let targetSelector = null;

        deleteModal.addEventListener('show.bs.modal', function (event) {
            // Button that triggered the modal
            const button = event.relatedTarget;
            
            // Get info
            const name = button.getAttribute('data-officer-name');
            targetSelector = button.getAttribute('data-delete-target');

            // Update modal text
            modalOfficerName.textContent = name;
        });

        confirmDeleteBtn.addEventListener('click', function() {
            if (targetSelector) {
                // Find the HIDDEN postLink and click it
                // This triggers the real form submission safely
                const hiddenLink = document.querySelector(targetSelector);
                if(hiddenLink) {
                    hiddenLink.click();
                }
            }
        });
    });
</script>