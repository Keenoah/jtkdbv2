<?php
/** @var \App\Model\Entity\Complaint[]|\Cake\Collection\CollectionInterface $complaints */
$identity = $this->request->getAttribute('identity');
$isStaff = $identity && $identity->get('role') === 'staff';
?>

<div class="complaints-dashboard">
    <div class="mb-5">
        <h2 class="fw-bold mb-2" style="color: var(--jtk-navy);">
            Hello, <?= h(strtoupper($identity->get('name'))) ?>
        </h2>
        <p class="text-muted">Here's what's happening with your cases.</p>
        
        <div class="d-flex justify-content-end" style="margin-top: -40px;">
            <?= $this->Html->link(__('<i class="bi bi-plus-lg me-2"></i> New Complaint'), ['action' => 'add'], ['escape' => false, 'class' => 'btn btn-dark rounded-pill px-4 py-2 shadow-sm', 'style' => 'background-color: var(--jtk-navy); border:none;']) ?>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-2 shadow-sm h-100 rounded-4" style="border-color: #212529;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-light rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-journal-text text-dark"></i>
                        </div>
                    </div>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Total</small>
                    <h2 class="fw-bold mb-0 mt-1"><?= $stats['total'] ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-2 shadow-sm h-100 rounded-4" style="border-color: #ffc107;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-warning-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-hourglass-split text-warning"></i>
                        </div>
                    </div>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Submitted</small>
                    <h2 class="fw-bold mb-0 mt-1"><?= $stats['pending'] ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-2 shadow-sm h-100 rounded-4" style="border-color: #0d6efd;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-primary-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-arrow-repeat text-primary"></i>
                        </div>
                    </div>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">In Progress</small>
                    <h2 class="fw-bold mb-0 mt-1"><?= $stats['progress'] ?></h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-2 shadow-sm h-100 rounded-4" style="border-color: #198754;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box bg-success-subtle rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                            <i class="bi bi-check-lg text-success"></i>
                        </div>
                    </div>
                    <small class="text-muted fw-bold text-uppercase" style="font-size: 0.7rem;">Settled</small>
                    <h2 class="fw-bold mb-0 mt-1"><?= $stats['settled'] ?></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-header bg-white p-4 border-bottom d-flex justify-content-between align-items-center">
            <h5 class="fw-bold mb-0" style="color: var(--jtk-navy);">Recent Complaints</h5>
            
            <form method="get" action="" class="d-none d-md-block">
                <div class="input-group input-group-sm">
                    <input type="text" name="search" class="form-control rounded-pill px-3" placeholder="Search ID" value="<?= h($this->request->getQuery('search')) ?>">
                </div>
            </form>
        </div>
        
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted small fw-bold text-uppercase" style="width: 10%;">Case ID</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase" style="width: 30%;">Description / Category</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase" style="width: 15%;">Status</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase" style="width: 25%;">Officer Assigned</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase text-center" style="width: 20%; min-width: 120px;">Date Submitted</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($complaints) > 0): ?>
                        <?php foreach ($complaints as $complaint): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#<?= $this->Number->format($complaint->id) ?></td>
                            
                            <td>
                                <div class="fw-bold text-dark"><?= h($complaint->category) ?></div>
                                <div class="text-muted small text-truncate" style="max-width: 250px;">
                                    <?= h($complaint->complaint_text) ?>
                                </div>
                            </td>
                            
                            <td>
                                <?php 
                                    $statusClass = 'bg-warning-subtle text-warning'; 
                                    $icon = '<i class="bi bi-hourglass me-1"></i>';
                                    if($complaint->status == 'Resolved' || $complaint->status == 'Settled') {
                                        $statusClass = 'bg-success-subtle text-success';
                                        $icon = '<i class="bi bi-check-circle me-1"></i>';
                                    }
                                    if($complaint->status == 'In Progress') {
                                        $statusClass = 'bg-primary-subtle text-primary';
                                        $icon = '<i class="bi bi-arrow-repeat me-1"></i>';
                                    }
                                ?>
                                <span class="badge <?= $statusClass ?> border px-3 py-2 rounded-pill">
                                    <?= $icon . h($complaint->status) ?>
                                </span>
                            </td>

                            <td class="text-muted small">
                                <?php if (!empty($complaint->officer)): ?>
                                    <i class="bi bi-person-fill text-primary"></i> <?= h($complaint->officer->name) ?>
                                <?php else: ?>
                                    <span class="badge bg-secondary-subtle text-secondary border">
                                        <i class="bi bi-hourglass me-1"></i> Pending Assignment
                                    </span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center text-muted small">
                                <?= !empty($complaint->created) ? h($complaint->created->format('d M Y')) : '<span class="text-muted">-</span>' ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-1 d-block mb-2 opacity-50"></i>
                                No complaints found.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <?php if ($this->Paginator->hasPage(2)): ?>
        <div class="card-footer bg-white border-0 py-3">
             <div class="d-flex justify-content-center">
                <nav aria-label="Page navigation">
                    <ul class="pagination mb-0">
                        <?= $this->Paginator->prev('< Previous', ['class' => 'page-item', 'linkClass' => 'page-link']) ?>
                        <?= $this->Paginator->numbers(['class' => 'page-item', 'linkClass' => 'page-link']) ?>
                        <?= $this->Paginator->next('Next >', ['class' => 'page-item', 'linkClass' => 'page-link']) ?>
                    </ul>
                </nav>
            </div>
        </div>
        <?php endif; ?>

    </div>
</div>