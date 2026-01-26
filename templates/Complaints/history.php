<div class="container-fluid py-2">
    <div class="mb-4">
        <h2 class="fw-bold" style="color: var(--jtk-navy);">Complaint History</h2>
        <p class="text-muted">Track and search through your submitted cases.</p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-2">
            <form method="get" action="">
                <div class="input-group">
                    <span class="input-group-text bg-white border-0 ps-3"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-0 py-3" placeholder="Search by Case ID, Category, or Status..." value="<?= h($search) ?>">
                    <button class="btn btn-primary px-4 rounded-3 m-1 fw-bold" style="background-color: var(--jtk-navy); border:none;">Search</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-muted small fw-bold text-uppercase">Case ID</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Category</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Description</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Status</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Officer</th>
                        <th class="py-3 text-muted small fw-bold text-uppercase">Date</th>
                        <th class="text-end pe-4 py-3 text-muted small fw-bold text-uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($complaints) > 0): ?>
                        <?php foreach ($complaints as $complaint): ?>
                        <tr>
                            <td class="ps-4 fw-bold text-muted">#<?= $complaint->id ?></td>
                            <td>
                                <span class="badge bg-light text-dark border px-3 py-1 rounded-pill fw-normal">
                                    <?= h($complaint->category) ?>
                                </span>
                            </td>
                            <td>
                                <div class="text-truncate fw-bold text-dark" style="max-width: 200px;">
                                    <?= h($complaint->complaint_text) ?>
                                </div>
                            </td>
                            <td>
                                <?php 
                                    $statusClass = 'bg-warning-subtle text-warning';
                                    if($complaint->status == 'Resolved' || $complaint->status == 'Settled') $statusClass = 'bg-success-subtle text-success';
                                    if($complaint->status == 'In Progress') $statusClass = 'bg-primary-subtle text-primary';
                                ?>
                                <span class="badge <?= $statusClass ?> border px-3 py-1 rounded-pill">
                                    <i class="bi bi-circle-fill me-1 small" style="font-size: 6px; vertical-align: middle;"></i> 
                                    <?= h($complaint->status) ?>
                                </span>
                            </td>
                            <td class="text-muted small">
                                <?php if (!empty($complaint->officer)): ?>
                                    <i class="bi bi-person-fill text-primary"></i> <?= h($complaint->officer->name) ?>
                                <?php else: ?>
                                    <span class="text-muted opacity-50">Pending...</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-muted small">
                                <?= h($complaint->created->format('d M Y')) ?>
                            </td>
                            <td class="text-end pe-4">
                                <?= $this->Html->link('<i class="bi bi-eye-fill"></i>', 
                                    ['action' => 'view', $complaint->id], 
                                    ['escape' => false, 'class' => 'btn btn-light btn-sm rounded-3 text-primary me-1', 'title' => 'View Details']
                                ) ?>
                                
                                <a href="<?= $this->Url->build(['action' => 'pdf', $complaint->id]) ?>" 
                                   target="_blank" 
                                   class="btn btn-light btn-sm rounded-3 text-dark" 
                                   title="Print PDF">
                                    <i class="bi bi-printer-fill"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
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