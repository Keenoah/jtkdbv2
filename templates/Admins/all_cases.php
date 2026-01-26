<?php
/**
 * All Cases View - Matched to specific design
 * @var \App\View\AppView $this
 * @var \Cake\ORM\ResultSet $complaints
 */
$currentCat = $this->request->getQuery('category');
$currentStatus = $this->request->getQuery('status');
?>

<style>
    /* Custom Pill Navigation */
    .nav-pills .nav-link {
        color: #64748b;
        background-color: white;
        border: 1px solid #e2e8f0;
        border-radius: 50px;
        padding: 8px 20px;
        font-weight: 500;
        font-size: 0.9rem;
        margin-right: 10px;
        transition: all 0.2s;
    }
    .nav-pills .nav-link:hover { background-color: #f1f5f9; }
    .nav-pills .nav-link.active { background-color: #003366; color: white; border-color: #003366; }

    /* Search Bar */
    .search-input {
        border-radius: 8px 0 0 8px;
        border: 1px solid #e2e8f0;
        padding: 12px 20px;
        font-size: 1rem;
    }
    .search-btn {
        border-radius: 0 8px 8px 0;
        background-color: #003366;
        border: 1px solid #003366;
        padding: 0 25px;
        font-weight: 600;
    }

    /* Table Styling */
    .table thead th {
        font-weight: 700; color: #1e293b; border-bottom: 2px solid #f1f5f9;
        font-size: 0.85rem; text-transform: uppercase; padding-top: 15px; padding-bottom: 15px;
    }
    .table tbody td {
        vertical-align: middle; padding: 15px 10px; font-size: 0.95rem; border-bottom: 1px solid #f8fafc;
    }

    /* Badges */
    .badge-pill { padding: 6px 12px; border-radius: 6px; font-weight: 600; font-size: 0.75rem; letter-spacing: 0.5px; }
    
    .cat-termination { background: #fee2e2; color: #991b1b; }
    .cat-general { background: #f1f5f9; color: #475569; }
    .cat-salary { background: #fef3c7; color: #92400e; }
    .cat-foreign { background: #e0e7ff; color: #3730a3; }

    .status-settled { color: #10b981; background: #d1fae5; }
    .status-progress { color: #3b82f6; background: #dbeafe; }
    .status-pending { color: #f59e0b; background: #fef3c7; }

    /* Action Button */
    .btn-manage {
        background: white; border: 1px solid #e2e8f0; color: #003366;
        font-weight: 600; font-size: 0.85rem; padding: 6px 15px; border-radius: 6px;
        text-decoration: none; transition: 0.2s;
    }
    .btn-manage:hover { background: #003366; color: white; border-color: #003366; }
</style>

<div class="mb-4">
    <h1 class="h3 fw-bold mb-1" style="color: #003366;">All Complaints</h1>
    <p class="text-muted">Review and oversee legal submissions.</p>
</div>

<div class="card border-0 shadow-sm" style="border-radius: 12px; padding: 20px;">
    <div class="card-body p-0">
        
        <div class="d-flex flex-wrap mb-4">
            <ul class="nav nav-pills">
                <li class="nav-item">
                    <?= $this->Html->link('All Departments', 
                        ['action' => 'allCases', '?' => ($currentStatus ? ['status' => $currentStatus] : [])], 
                        ['class' => 'nav-link ' . (empty($currentCat) ? 'active' : '')]
                    ) ?>
                </li>
                
                <?php 
                $cats = ['General', 'Salary', 'Termination', 'Foreign Worker'];
                foreach($cats as $c): 
                    $isActive = ($currentCat == $c);
                    // Add Status to Category Link if it exists
                    $query = ['category' => $c];
                    if ($currentStatus) { $query['status'] = $currentStatus; }
                ?>
                <li class="nav-item">
                    <?= $this->Html->link($c, 
                        ['action' => 'allCases', '?' => $query], 
                        ['class' => 'nav-link ' . ($isActive ? 'active' : '')]
                    ) ?>
                </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="mb-4">
            <?= $this->Form->create(null, ['type' => 'get', 'class' => 'd-flex']) ?>
                
                <?php 
                if ($currentCat) {
                    echo $this->Form->hidden('category', ['value' => $currentCat]);
                }
                if ($currentStatus) {
                    echo $this->Form->hidden('status', ['value' => $currentStatus]);
                }
                ?>

                <input type="text" name="search" class="form-control search-input" placeholder="Search by ID or Complainant Name..." value="<?= $this->request->getQuery('search') ?>">
                <button type="submit" class="btn btn-primary search-btn">Search</button>
            <?= $this->Form->end() ?>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th class="ps-3">ID</th>
                        <th>COMPLAINANT</th>
                        <th>CATEGORY</th>
                        <th>STATUS</th>
                        <th>ASSIGNED TO</th>
                        <th class="text-end pe-3">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($complaints->isEmpty()): ?>
                        <tr><td colspan="6" class="text-center py-5 text-muted">No records found matching your criteria.</td></tr>
                    <?php else: ?>
                        <?php foreach ($complaints as $c): ?>
                        <tr>
                            <td class="ps-3 fw-bold text-secondary">#<?= $c->id ?></td>
                            
                            <td>
                                <div class="fw-bold text-dark"><?= h($c->user->name ?? 'Unknown') ?></div>
                                <div class="text-muted small"><?= $c->created->format('d M Y') ?></div>
                            </td>
                            
                            <?php 
                                $catClass = 'cat-general';
                                if (stripos($c->category, 'Termination') !== false) $catClass = 'cat-termination';
                                if (stripos($c->category, 'Salary') !== false) $catClass = 'cat-salary';
                                if (stripos($c->category, 'Foreign') !== false) $catClass = 'cat-foreign';
                            ?>
                            <td><span class="badge-pill <?= $catClass ?>"><?= h($c->category) ?></span></td>
                            
                            <?php 
                                $statClass = 'status-pending';
                                $dot = '●';
                                if ($c->status == 'In Progress') $statClass = 'status-progress';
                                if ($c->status == 'Settled') $statClass = 'status-settled';
                            ?>
                            <td><span class="badge-pill <?= $statClass ?>"><?= $dot ?> <?= strtoupper($c->status) ?></span></td>
                            
                            <td>
                                <?php if ($c->officer): ?>
                                    <div class="d-flex align-items-center gap-2 text-dark fw-semibold" style="font-size: 0.9rem;">
                                        <i class="bi bi-person text-secondary"></i> <?= h($c->officer->name) ?>
                                    </div>
                                <?php else: ?>
                                    <div class="text-danger fw-bold" style="font-size: 0.8rem;">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i> UNASSIGNED
                                    </div>
                                <?php endif; ?>
                            </td>

                            <td class="text-end pe-3">
                                <?= $this->Html->link('Manage', ['action' => 'viewComplaint', $c->id], ['class' => 'btn-manage']) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
    </div>
</div>