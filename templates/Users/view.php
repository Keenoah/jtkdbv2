<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complaint $complaint
 */
?>

<div class="container-fluid py-4"> <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <div class="d-flex align-items-center gap-3">
                <h2 class="fw-bold mb-0" style="color: var(--jtk-navy);">Case Details #<?= h($complaint->id) ?></h2>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-3 rounded-pill">
                    <?= h(strtoupper($complaint->category)) ?>
                </span>
            </div>
            <p class="text-muted mt-1 mb-0">USER SUBMISSION RECORD</p>
        </div>
        
        <div class="d-flex gap-2">
            <a href="<?= $this->Url->build(['action' => 'pdf', $complaint->id]) ?>" target="_blank" class="btn btn-primary px-4 fw-bold rounded-3 shadow-sm" style="background-color: var(--jtk-navy); border:none;">
                <i class="bi bi-printer-fill me-2"></i> Print PDF
            </a>

            <?= $this->Html->link('<i class="bi bi-arrow-left me-2"></i> Back', ['action' => 'index'], ['escape' => false, 'class' => 'btn btn-light border px-4 fw-bold rounded-3']) ?>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="row text-center text-md-start">
                
                <div class="col-md-3 mb-3 mb-md-0 border-end">
                    <small class="text-muted fw-bold text-uppercase d-block mb-2">Current Status</small>
                    <?php 
                        $statusClass = 'bg-warning-subtle text-warning';
                        if($complaint->status == 'Resolved' || $complaint->status == 'Settled') $statusClass = 'bg-success-subtle text-success';
                        if($complaint->status == 'In Progress') $statusClass = 'bg-primary-subtle text-primary';
                    ?>
                    <span class="badge <?= $statusClass ?> px-4 py-2 rounded-pill">
                        <i class="bi bi-circle-fill me-2 small"></i> <?= h($complaint->status) ?>
                    </span>
                </div>
                
                <div class="col-md-3 mb-3 mb-md-0 border-end ps-md-4">
                    <small class="text-muted fw-bold text-uppercase d-block mb-2">Officer In Charge</small>
                    <div class="fw-bold text-dark fs-5">
                        <?php if (!empty($complaint->officer)): ?>
                            <i class="bi bi-person-badge-fill text-primary me-2"></i> 
                            <?= h($complaint->officer->name) ?>
                        <?php else: ?>
                            <span class="text-muted fs-6 fst-italic">Pending Assignment</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-3 mb-3 mb-md-0 border-end ps-md-4">
                    <small class="text-muted fw-bold text-uppercase d-block mb-2">Processed By</small>
                    <div class="fw-bold text-dark fs-5">
                        <?php if (!empty($complaint->admin)): ?>
                            <i class="bi bi-pc-display-horizontal text-secondary me-2"></i>
                            <span class="text-uppercase"><?= h($complaint->admin->username) ?></span>
                        <?php else: ?>
                            <span class="text-muted fs-6 fst-italic">System / Pending</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-md-3 ps-md-4">
                    <small class="text-muted fw-bold text-uppercase d-block mb-2">Submission Date</small>
                    <div class="fw-bold text-dark fs-5">
                        <i class="bi bi-calendar-event text-success me-2"></i>
                        <?= h($complaint->created->format('d M Y')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($complaint->comp_name_1)): ?>
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <small class="text-primary fw-bold text-uppercase mb-3 d-block">Group Complainants (Represented)</small>
            <div class="table-responsive border rounded-3">
                <table class="table table-borderless mb-0">
                    <thead class="bg-light border-bottom">
                        <tr>
                            <th class="ps-4 py-3 text-muted small fw-bold">#</th>
                            <th class="py-3 text-muted small fw-bold">FULL NAME</th>
                            <th class="py-3 text-muted small fw-bold">IC / PASSPORT NO.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="ps-4 fw-bold text-muted">1</td>
                            <td class="fw-bold"><?= h($complaint->comp_name_1) ?></td>
                            <td class="text-muted"><?= h($complaint->comp_ic_1) ?></td>
                        </tr>
                        <?php if (!empty($complaint->comp_name_2)): ?>
                        <tr class="border-top">
                            <td class="ps-4 fw-bold text-muted">2</td>
                            <td class="fw-bold"><?= h($complaint->comp_name_2) ?></td>
                            <td class="text-muted"><?= h($complaint->comp_ic_2) ?></td>
                        </tr>
                        <?php endif; ?>
                        <?php if (!empty($complaint->comp_name_3)): ?>
                        <tr class="border-top">
                            <td class="ps-4 fw-bold text-muted">3</td>
                            <td class="fw-bold"><?= h($complaint->comp_name_3) ?></td>
                            <td class="text-muted"><?= h($complaint->comp_ic_3) ?></td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <small class="text-primary fw-bold text-uppercase mb-3 d-block">Incident Description</small>
            <div class="p-4 bg-light rounded-3 border">
                <?= $this->Text->autoParagraph(h($complaint->complaint_text)); ?>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <small class="text-primary fw-bold text-uppercase mb-3 d-block"><i class="bi bi-building me-2"></i> Employer Details</small>
            <div class="p-4 bg-light rounded-3 border">
                <div class="row g-4">
                    <div class="col-md-6">
                        <small class="text-muted fw-bold text-uppercase d-block mb-1">Company Name</small>
                        <div class="fw-bold fs-5 text-dark"><?= h($complaint->employer_name) ?></div>
                    </div>
                    <div class="col-md-6">
                        <small class="text-muted fw-bold text-uppercase d-block mb-1">Person In Charge</small>
                        <div class="fw-bold fs-5 text-dark"><?= h($complaint->person_in_charge ?? '-') ?></div>
                    </div>
                    
                    <div class="col-md-6">
                        <small class="text-muted fw-bold text-uppercase d-block mb-2">Contact Details</small>
                        <div class="d-flex flex-column gap-2">
                            <span class="text-dark"><i class="bi bi-telephone-fill text-primary me-2"></i> <?= h($complaint->employer_tel) ?></span>
                            <?php if(!empty($complaint->employer_email)): ?>
                                <span class="text-dark"><i class="bi bi-envelope-fill text-primary me-2"></i> <?= h($complaint->employer_email) ?></span>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <small class="text-muted fw-bold text-uppercase d-block mb-2">Employer Address</small>
                        <div class="text-dark"><?= h($complaint->employer_address) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php if (!empty($complaint->file_path)): ?>
    <div class="card border-0 shadow-sm rounded-4 mb-5">
        <div class="card-body p-4">
            <small class="text-muted fw-bold text-uppercase mb-3 d-block">Your Attachment</small>
            
            <?php 
                // Build path correctly for subfolder setup
                $fileUrl = $this->Url->webroot('files/' . $complaint->file_path);
            ?>

            <a href="<?= $fileUrl ?>" target="_blank" class="text-decoration-none">
                <div class="d-inline-flex align-items-center bg-light border rounded-3 px-4 py-3 hover-shadow transition">
                    <i class="bi bi-file-earmark-pdf-fill text-danger fs-3 me-3"></i>
                    <div>
                        <div class="fw-bold text-dark">Preview Document</div>
                        <small class="text-muted">Click to view evidence file</small>
                    </div>
                </div>
            </a>
            
            <?php 
                $ext = strtolower(pathinfo($complaint->file_path, PATHINFO_EXTENSION));
                if (in_array($ext, ['jpg', 'jpeg', 'png'])): 
            ?>
                <div class="mt-3">
                    <img src="<?= $fileUrl ?>" class="img-fluid rounded border shadow-sm" style="max-height: 300px;">
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php endif; ?>

</div>

<style>
    .hover-shadow:hover { box-shadow: 0 .5rem 1rem rgba(0,0,0,.05); background: white !important; }
    .transition { transition: all 0.2s; }
</style>