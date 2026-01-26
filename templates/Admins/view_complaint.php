<?php
/**
 * View Complaint Details
 * Fix: Restored "Group Complainants" in PDF View
 * Fix: Uses safe webroot() for images
 */

// 1. Get Admin Info
$currentAdmin = $this->request->getAttribute('identity');
$adminName = $currentAdmin ? $currentAdmin->username : 'System Admin';

// 2. EVIDENCE LOGIC
$hasEvidence = !empty($complaint->file_path);

if ($hasEvidence) {
    // Safe webroot link generation
    $fileUrl = $this->Url->webroot('files/' . $complaint->file_path);
    $ext = strtolower(pathinfo($complaint->file_path, PATHINFO_EXTENSION));
    $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);
}
?>

<style>
    /* --- SCREEN STYLES --- */
    .screen-only { display: block; }
    .print-only { display: none; }
    
    .main-card {
        background: #ffffff; border: 1px solid #e2e8f0; border-top: 5px solid #003366;
        border-radius: 12px; padding: 40px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
    }
    
    .label-text { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; color: #64748b; margin-bottom: 5px; }
    .value-text { font-size: 1rem; font-weight: 600; color: #1e293b; }
    .section-title { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #94a3b8; margin-bottom: 15px; }
    .gray-box { background-color: #f8fafc; border: 1px solid #f1f5f9; border-radius: 8px; padding: 25px; }
    
    .status-pill { display: inline-block; padding: 8px 20px; border-radius: 50px; font-weight: 700; font-size: 0.85rem; text-transform: uppercase; }
    .status-settled { background: #dcfce7; color: #15803d; }
    .status-progress { background: #dbeafe; color: #1e40af; }
    .status-pending { background: #fef3c7; color: #b45309; }
    
    .btn-back { background: white; border: 1px solid #e2e8f0; color: #1e293b; font-weight: 600; padding: 8px 20px; border-radius: 50px; text-decoration: none; }
    .btn-back:hover { background: #f8fafc; color: #003366; }

    .btn-evidence { 
        display: inline-flex; align-items: center; gap: 8px;
        background: white; border: 1px solid #e2e8f0; color: #dc2626; 
        font-weight: 600; padding: 12px 24px; border-radius: 8px; 
        text-decoration: none; transition: 0.2s; cursor: pointer;
    }
    .btn-evidence:hover { background: #fef2f2; border-color: #dc2626; color: #991b1b; }

    .btn-update { background: #003366; color: white; border: none; font-weight: 600; padding: 12px; border-radius: 8px; }
    .btn-print { background: white; border: 1px solid #cbd5e1; color: #334155; padding: 12px; border-radius: 8px; }
    .btn-delete-float { background: #fef2f2; color: #dc2626; border: 1px solid #fecaca; padding: 10px 25px; border-radius: 8px; font-weight: 600; }

    /* --- PRINT STYLES --- */
    @media print {
        @page { size: A4; margin: 15mm; }
        body { background: white; font-family: 'Arial', sans-serif !important; color: #000; -webkit-print-color-adjust: exact; }
        .screen-only, .sidebar-wrapper, .mobile-nav, .action-bar, .btn, .modal-backdrop, .modal { display: none !important; }
        .print-only { display: block !important; }
        main { margin: 0 !important; padding: 0 !important; width: 100% !important; }
        
        .doc-header-row { display: flex; align-items: center; gap: 15px; border-bottom: 2px solid #000; padding-bottom: 15px; margin-bottom: 25px; }
        .doc-title { font-size: 16pt; font-weight: bold; text-transform: uppercase; margin: 0; color: #003366; }
        .doc-section { background-color: #f3f4f6 !important; color: #374151 !important; font-size: 9pt; font-weight: bold; text-transform: uppercase; padding: 8px 10px; margin-top: 25px; margin-bottom: 15px; border-left: 4px solid #003366; }
        .doc-grid { display: grid; grid-template-columns: 1fr 1fr; column-gap: 40px; row-gap: 8px; font-size: 10pt; }
        .doc-row { display: flex; }
        .doc-label { width: 130px; font-weight: bold; color: #4b5563; }
        .doc-val { flex: 1; color: #111827; }
        .evidence-print-img { max-width: 100%; max-height: 400px; border: 1px solid #ccc; margin-top: 10px; }
        
        .doc-table { width: 100%; border-collapse: collapse; font-size: 10pt; margin-top: 5px; }
        .doc-table th { border: 1px solid #000; background: white; padding: 6px; text-align: left; font-weight: bold; }
        .doc-table td { border: 1px solid #000; padding: 6px; }
    }
</style>

<div class="screen-only">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <div class="d-flex align-items-center gap-3">
                <h1 class="fw-bold h2 mb-0" style="color: #003366;">Case #<?= $complaint->id ?></h1>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3">
                    <?= strtoupper($complaint->category) ?>
                </span>
            </div>
            <p class="text-muted small mt-1 mb-0 fw-bold" style="letter-spacing: 1px;">COMPLAINT REVIEW</p>
        </div>
        <?= $this->Html->link('<i class="bi bi-arrow-left me-2"></i> Back to List', ['action' => 'allCases'], ['class' => 'btn-back', 'escape' => false]) ?>
    </div>

    <div class="main-card">
        
        <div class="d-flex justify-content-between align-items-start mb-5">
            <div>
                <div class="section-title">MAIN COMPLAINANT</div>
                <h2 class="fw-bold mb-1" style="font-size: 1.75rem; color: #0f172a;"><?= h($complaint->user->name ?? 'Unknown') ?></h2>
                <div class="text-muted"><i class="bi bi-envelope me-2"></i> <?= h($complaint->user->email ?? 'No Email') ?></div>
            </div>
            <div class="text-end">
                <?php 
                    $statClass = match($complaint->status) {
                        'In Progress' => 'status-progress',
                        'Settled' => 'status-settled',
                        default => 'status-pending'
                    };
                ?>
                <div class="status-pill <?= $statClass ?> mb-2">
                    <i class="bi bi-circle-fill me-1 small" style="font-size: 6px; vertical-align: middle;"></i> <?= strtoupper($complaint->status) ?>
                </div>
                <div class="text-muted small">Processed by: <span class="fw-semibold text-dark"><?= h($adminName) ?></span></div>
            </div>
        </div>

        <div class="gray-box mb-5">
            <div class="d-flex align-items-center gap-2 mb-4 text-primary fw-bold" style="font-size: 0.8rem;">
                <i class="bi bi-person-lines-fill"></i> PROFILE DETAILS
            </div>
            <div class="row g-4">
                <div class="col-md-3"><div class="label-text">IC NUMBER</div><div class="value-text"><?= h($complaint->user->ic_number ?? 'N/A') ?></div></div>
                <div class="col-md-3"><div class="label-text">AGE / GENDER</div><div class="value-text"><?= h($complaint->user->age ?? 'N/A') ?> / <?= h($complaint->user->gender ?? 'N/A') ?></div></div>
                <div class="col-md-3"><div class="label-text">PHONE NO.</div><div class="value-text"><?= h($complaint->user->phone ?? 'N/A') ?></div></div>
                <div class="col-md-3"><div class="label-text">NATIONALITY</div><div class="value-text"><?= h($complaint->user->nationality ?? 'Malaysian') ?></div></div>
                <div class="col-12 border-top pt-3 mt-2"><div class="label-text">HOME ADDRESS</div><div class="value-text"><?= h($complaint->user->address ?? '-') ?></div></div>
            </div>
        </div>
        
        <?php if (!empty($complaint->comp_name_1)): ?>
        <div class="mb-5">
            <div class="section-title">GROUP COMPLAINANTS</div>
            <table class="table table-borderless bg-light rounded mb-0">
                <thead><tr><th class="ps-4 text-muted small">#</th><th class="text-muted small">Full Name</th><th class="text-muted small">IC / Passport No.</th></tr></thead>
                <tbody>
                    <?php for ($i = 1; $i <= 3; $i++): $n="comp_name_$i"; $ic="comp_ic_$i"; if(!empty($complaint->$n)): ?>
                    <tr><td class="ps-4 fw-bold"><?= $i ?></td><td><?= h($complaint->$n) ?></td><td class="font-monospace text-muted"><?= h($complaint->$ic ?? '-') ?></td></tr>
                    <?php endif; endfor; ?>
                </tbody>
            </table>
        </div>
        <?php endif; ?>

        <div class="row mb-5">
            <div class="col-12">
                <div class="section-title">INCIDENT DESCRIPTION</div>
                <div class="mb-4"><p class="fs-6" style="line-height: 1.6;"><?= nl2br(h($complaint->complaint_text)) ?></p></div>
            </div>
            
            <div class="col-12">
                <div class="section-title">EVIDENCE ATTACHED</div>
                <?php if ($hasEvidence): ?>
                    <button type="button" class="btn-evidence" data-bs-toggle="modal" data-bs-target="#evidenceModal">
                        <i class="bi bi-file-earmark-pdf-fill fs-5"></i> View Case Evidence
                    </button>
                <?php else: ?>
                    <div class="text-muted fst-italic small">No evidence files attached.</div>
                <?php endif; ?>
            </div>
        </div>
        
        <hr class="my-5 opacity-25">

        <div class="mb-5">
            <div class="section-title"><i class="bi bi-building me-2"></i> EMPLOYER DETAILS</div>
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="label-text">COMPANY NAME</div><div class="value-text mb-3 fs-5"><?= h($complaint->employer_name) ?></div>
                    <div class="label-text">CONTACT</div>
                    <div class="small fw-semibold"><i class="bi bi-telephone text-primary me-2"></i> <?= h($complaint->employer_tel ?? '-') ?></div>
                    <div class="small fw-semibold"><i class="bi bi-envelope text-primary me-2"></i> <?= h($complaint->employer_email ?? '-') ?></div>
                </div>
                <div class="col-md-6">
                    <div class="label-text">PERSON IN CHARGE</div><div class="value-text mb-3"><?= h($complaint->person_in_charge ?? '-') ?></div>
                    <div class="label-text">ADDRESS</div><div class="value-text small text-secondary"><?= h($complaint->employer_address) ?></div>
                </div>
            </div>
        </div>

        <div class="gray-box mt-4">
            <?= $this->Form->create($complaint) ?>
            <div class="row g-3 align-items-end">
                <div class="col-md-5">
                    <div class="label-text mb-2">ASSIGN OFFICER</div>
                    <?= $this->Form->control('officer_id', ['options' => $officers, 'empty' => 'Select...', 'class' => 'form-select', 'label' => false]) ?>
                </div>
                <div class="col-md-4">
                    <div class="label-text mb-2">STATUS</div>
                    <?= $this->Form->control('status', ['options' => ['Pending'=>'Pending', 'In Progress'=>'In Progress', 'Settled'=>'Settled'], 'class' => 'form-select', 'label' => false]) ?>
                </div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn-update w-100">Update Case</button>
                    <button type="button" class="btn-print" onclick="window.print()"><i class="bi bi-printer-fill fs-5"></i></button>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
        
    </div>

    <div class="text-center mt-5 mb-5">
        <button type="button" class="btn-delete-float" data-bs-toggle="modal" data-bs-target="#deleteModal">
            <i class="bi bi-trash3 me-2"></i> Delete Complaint
        </button>
    </div>
</div>

<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-body text-center p-5">
                <div class="mb-4"><div class="bg-danger bg-opacity-10 text-danger rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;"><i class="bi bi-trash3-fill fs-1"></i></div></div>
                <h4 class="fw-bold mb-2">Delete Case #<?= $complaint->id ?>?</h4>
                <p class="text-muted mb-4">This action is permanent.</p>
                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-light border px-4 fw-bold" data-bs-dismiss="modal">Cancel</button>
                    <?= $this->Form->postLink('Confirm Delete', ['action' => 'delete', $complaint->id], ['class' => 'btn btn-danger px-4 fw-bold']) ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if ($hasEvidence): ?>
<div class="modal fade" id="evidenceModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 12px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Case Evidence</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4 bg-light">
                <?php if ($isImage): ?>
                    <img src="<?= $fileUrl ?>" class="img-fluid rounded shadow-sm mb-3" style="max-height: 80vh;" alt="Evidence Image">
                    <div class="text-center mt-2">
                        <a href="<?= $fileUrl ?>" target="_blank" class="text-primary fw-bold text-decoration-none small">
                            Open Original File
                        </a>
                    </div>
                <?php else: ?>
                    <div class="py-5">
                        <i class="bi bi-file-earmark-text fs-1 text-primary"></i>
                        <h5 class="mt-3">Document Attached</h5>
                        <a href="<?= $fileUrl ?>" target="_blank" class="btn btn-primary">Download / Open File</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


<div class="print-only">
    <div class="doc-header-row">
        <?= $this->Html->image('jatanegara.png', ['style' => 'height: 60px; filter: none !important;']) ?>
        <div>
            <h1 class="doc-title">JABATAN TENAGA KERJA (JTK)</h1>
            <p class="doc-subtitle">Official Complaint Management System | Case Record</p>
        </div>
    </div>

    <div style="display: flex; justify-content: space-between; border-bottom: 2px solid #eee; padding-bottom: 10px; margin-bottom: 20px;">
        <div><strong>CASE ID: #<?= $complaint->id ?></strong></div>
        <div>Category: <?= h($complaint->category) ?> | Status: <?= h($complaint->status) ?></div>
    </div>

    <div class="doc-section">MAIN COMPLAINANT PROFILE</div>
    <div class="doc-grid">
        <div>
            <div class="doc-row"><span class="doc-label">Name:</span> <span class="doc-val"><?= h($complaint->user->name) ?></span></div>
            <div class="doc-row"><span class="doc-label">Phone:</span> <span class="doc-val"><?= h($complaint->user->phone) ?></span></div>
        </div>
        <div>
            <div class="doc-row"><span class="doc-label">IC No:</span> <span class="doc-val"><?= h($complaint->user->ic_number) ?></span></div>
            <div class="doc-row"><span class="doc-label">Nationality:</span> <span class="doc-val"><?= h($complaint->user->nationality) ?></span></div>
        </div>
    </div>
    <div class="doc-row mt-2"><span class="doc-label">Address:</span> <span class="doc-val"><?= h($complaint->user->address) ?></span></div>

    <?php if (!empty($complaint->comp_name_1)): ?>
    <div class="doc-section">ADDITIONAL REPRESENTED PERSONS</div>
    <table class="doc-table">
        <thead>
            <tr><th width="30">#</th><th>Full Name</th><th width="150">IC / Passport No.</th></tr>
        </thead>
        <tbody>
            <?php for ($i = 1; $i <= 3; $i++): $n="comp_name_$i"; $ic="comp_ic_$i"; if(!empty($complaint->$n)): ?>
            <tr><td><?= $i ?></td><td><?= h($complaint->$n) ?></td><td><?= h($complaint->$ic ?? '-') ?></td></tr>
            <?php endif; endfor; ?>
        </tbody>
    </table>
    <?php endif; ?>

    <div class="doc-section">EMPLOYER INFORMATION</div>
    <div class="doc-grid">
        <div>
            <div class="doc-row"><span class="doc-label">Company:</span> <span class="doc-val"><?= h($complaint->employer_name) ?></span></div>
            <div class="doc-row"><span class="doc-label">Tel:</span> <span class="doc-val"><?= h($complaint->employer_tel) ?></span></div>
        </div>
        <div>
            <div class="doc-row"><span class="doc-label">PIC:</span> <span class="doc-val"><?= h($complaint->person_in_charge) ?></span></div>
            <div class="doc-row"><span class="doc-label">Email:</span> <span class="doc-val"><?= h($complaint->employer_email) ?></span></div>
        </div>
    </div>
    <div class="doc-row mt-2"><span class="doc-label">Address:</span> <span class="doc-val"><?= h($complaint->employer_address) ?></span></div>

    <div class="doc-section">CASE DESCRIPTION</div>
    <div style="font-size: 10pt; line-height: 1.5; padding: 10px; border: 1px solid #eee;">
        <?= h($complaint->complaint_text) ?>
    </div>

    <?php if ($hasEvidence): ?>
        <div class="doc-section">EVIDENCE ATTACHED</div>
        <div style="text-align: center; padding: 10px; border: 1px solid #eee;">
            <?php if ($isImage): ?>
                <img src="<?= $fileUrl ?>" class="evidence-print-img">
                <div style="font-size: 9pt; color: #555; margin-top: 5px;">Figure 1: Attached Evidence Image</div>
            <?php else: ?>
                <div style="padding: 20px;">[ File attached: <?= h($complaint->file_path) ?> - Cannot print non-image formats ]</div>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <div class="doc-section">INTERNAL ASSIGNMENT & ACTION</div>
    <div class="doc-grid">
        <div>
            <div class="doc-row"><span class="doc-label">Officer Assigned:</span> <span class="doc-val"><?= h($complaint->officer->name ?? 'Unassigned') ?></span></div>
            
            <?php if (!empty($complaint->officer->email)): ?>
            <div class="doc-row"><span class="doc-label">Officer Email:</span> <span class="doc-val"><?= h($complaint->officer->email) ?></span></div>
            <?php endif; ?>

            <div class="doc-row"><span class="doc-label">Submitted On:</span> <span class="doc-val"><?= h($complaint->created->format('d M Y, H:i')) ?></span></div>
        </div>
        <div>
            <div class="doc-row"><span class="doc-label">Processed By:</span> <span class="doc-val"><?= h($adminName) ?></span></div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>