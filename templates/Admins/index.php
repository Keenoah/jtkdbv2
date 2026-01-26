<?php
/**
 * @var \App\View\AppView $this
 * @var int $total
 * @var int $submitted
 * @var int $active
 * @var int $resolved
 * @var array $categories
 * @var \Cake\ORM\ResultSet $recent
 */
?>

<style>
    .stat-link { text-decoration: none; color: inherit; display: block; height: 100%; }
    /* Added hover effect for the new card style */
    .stat-link:hover .card { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important; }
    
    .jtk-widget { background: #ffffff; border-radius: 16px; padding: 25px; border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02); height: 100%; }
    .status-badge { padding: 5px 12px; border-radius: 6px; font-size: 0.75rem; font-weight: 700; }
    .btn-jtk-view { background: #f1f5f9; color: #003366; border-radius: 8px; padding: 6px 14px; font-size: 0.8rem; font-weight: 600; text-decoration: none; transition: 0.2s; display: inline-block; }
    .btn-jtk-view:hover { background: #003366; color: white; }
</style>

<div class="d-flex justify-content-between align-items-center mb-5">
    <div>
        <h1 class="fw-bold h3 mb-1" style="color: var(--jtk-navy);">Administrative Overview</h1>
        <p class="text-muted small">Real-time statistics and departmental activity tracking.</p>
    </div>
    <div class="d-none d-md-block">
        <span class="badge bg-white text-dark border p-2 px-3 rounded-pill shadow-sm">
            <i class="bi bi-calendar3 me-2 text-primary"></i> <?= date('d M Y') ?>
        </span>
    </div>
</div>

<div class="row g-3 g-md-4 mb-5">
    
    <div class="col-6 col-md-3">
        <a href="<?= $this->Url->build(['action' => 'allCases']) ?>" class="stat-link">
            <div class="card h-100 p-4 border shadow-sm rounded-4" style="border-color: #212529 !important;">
                <div class="d-flex flex-column h-100">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-4" 
                         style="width: 45px; height: 45px; background-color: #f8f9fa; color: #212529;">
                        <i class="bi bi-file-earmark-text fs-5"></i>
                    </div>
                    
                    <h6 class="text-uppercase text-muted fw-bold small mb-1" style="font-size: 11px; letter-spacing: 1px;">
                        Total Cases
                    </h6>
                    <h2 class="fw-bold mb-0 text-dark display-6"><?= $total ?></h2>
                </div>
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="<?= $this->Url->build(['action' => 'allCases', '?' => ['status' => 'Submitted']]) ?>" class="stat-link">
            <div class="card h-100 p-4 border shadow-sm rounded-4" style="border-color: #ffc107 !important;">
                <div class="d-flex flex-column h-100">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-4" 
                         style="width: 45px; height: 45px; background-color: #fff3cd; color: #ffc107;">
                        <i class="bi bi-hourglass-split fs-5"></i>
                    </div>
                    
                    <h6 class="text-uppercase text-muted fw-bold small mb-1" style="font-size: 11px; letter-spacing: 1px;">
                        Pending
                    </h6>
                    <h2 class="fw-bold mb-0 text-dark display-6"><?= $submitted ?></h2>
                </div>
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="<?= $this->Url->build(['action' => 'allCases', '?' => ['status' => 'In Progress']]) ?>" class="stat-link">
            <div class="card h-100 p-4 border shadow-sm rounded-4" style="border-color: #0d6efd !important;">
                <div class="d-flex flex-column h-100">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-4" 
                         style="width: 45px; height: 45px; background-color: #cfe2ff; color: #0d6efd;">
                        <i class="bi bi-arrow-repeat fs-5"></i>
                    </div>
                    
                    <h6 class="text-uppercase text-muted fw-bold small mb-1" style="font-size: 11px; letter-spacing: 1px;">
                        In Progress
                    </h6>
                    <h2 class="fw-bold mb-0 text-dark display-6"><?= $active ?></h2>
                </div>
            </div>
        </a>
    </div>

    <div class="col-6 col-md-3">
        <a href="<?= $this->Url->build(['action' => 'allCases', '?' => ['status' => 'Settled']]) ?>" class="stat-link">
            <div class="card h-100 p-4 border shadow-sm rounded-4" style="border-color: #198754 !important;">
                <div class="d-flex flex-column h-100">
                    <div class="rounded-circle d-flex align-items-center justify-content-center mb-4" 
                         style="width: 45px; height: 45px; background-color: #d1e7dd; color: #198754;">
                        <i class="bi bi-check-lg fs-5"></i>
                    </div>
                    
                    <h6 class="text-uppercase text-muted fw-bold small mb-1" style="font-size: 11px; letter-spacing: 1px;">
                        Settled
                    </h6>
                    <h2 class="fw-bold mb-0 text-dark display-6"><?= $resolved ?></h2>
                </div>
            </div>
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-12 col-lg-4">
        <div class="jtk-widget h-100">
            <h6 class="fw-bold text-uppercase small text-muted mb-4">Departmental Load</h6>
            <div class="category-list">
                <?php 
                $catData = isset($categories) ? $categories : [];
                $all_cats = ['General', 'Salary', 'Termination', 'Foreign Worker'];
                foreach($all_cats as $c): 
                    $count = $catData[$c] ?? 0;
                    $bar_percent = ($total > 0) ? ($count / $total) * 100 : 0;
                ?>
                <div class="category-item border-bottom py-2">
                    <div class="d-flex justify-content-between mb-1">
                        <div class="fw-bold small"><?= h($c) ?></div>
                        <span class="badge bg-light text-dark border"><?= round($bar_percent) ?>%</span>
                    </div>
                    <div class="text-muted small mb-2" style="font-size: 0.7rem;"><?= $count ?> cases</div>
                    <div class="progress" style="height: 4px;">
                        <div class="progress-bar bg-dark" style="width: <?= $bar_percent ?>%"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <div class="mt-4 pt-3 border-top">
                <?php $res_rate = ($total > 0) ? round(($resolved/$total)*100) : 0; ?>
                <div class="d-flex justify-content-between mb-2">
                    <span class="small fw-bold">Resolution Rate</span>
                    <span class="small text-success fw-bold"><?= $res_rate ?>%</span>
                </div>
                <div class="progress rounded-pill" style="height: 6px;">
                    <div class="progress-bar bg-success" style="width: <?= $res_rate ?>%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-8">
        <div class="jtk-widget h-100">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h6 class="fw-bold text-uppercase small text-muted mb-0">Live Case Feed</h6>
                <a href="<?= $this->Url->build(['action' => 'allCases']) ?>" class="btn btn-sm btn-link text-decoration-none fw-bold p-0">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Category</th>
                            <th>Complainant</th>
                            <th>Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($recent as $c): ?>
                        <tr>
                            <td>
                                <div class="small fw-bold text-secondary">#<?= $c->id ?></div>
                                <div class="text-muted" style="font-size: 0.7rem;"><?= h($c->category) ?></div>
                            </td>
                            <td>
                                <div class="fw-semibold text-dark"><?= h($c->user->name ?? 'Unknown') ?></div>
                                <div class="text-muted d-none d-sm-block" style="font-size: 0.75rem;">
                                    <?= $c->created->format('d M Y') ?>
                                </div>
                            </td>
                            <td>
                                <?php 
                                    $badgeClass = 'bg-secondary-subtle text-secondary';
                                    if($c->status == 'Settled' || $c->status == 'Resolved') $badgeClass = 'bg-success-subtle text-success';
                                    if($c->status == 'In Progress' || $c->status == 'Active') $badgeClass = 'bg-primary-subtle text-primary';
                                    if($c->status == 'Submitted' || $c->status == 'Pending') $badgeClass = 'bg-warning-subtle text-warning-emphasis';
                                ?>
                                <span class="status-badge <?= $badgeClass ?>"><?= h($c->status) ?></span>
                            </td>
                            <td class="text-end">
                                <a href="<?= $this->Url->build(['action' => 'viewComplaint', $c->id]) ?>" class="btn-jtk-view">Review</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>