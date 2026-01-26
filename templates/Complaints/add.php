<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complaint $complaint
 */
?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10">
            
            <div class="d-flex align-items-center justify-content-between mb-4">
                <div>
                    <h2 class="fw-bold" style="color: var(--jtk-navy);">Submit a Complaint</h2>
                    <p class="text-muted">Please provide accurate details to help us resolve your case.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">
                    
                    <?= $this->Form->create($complaint, ['type' => 'file', 'id' => 'complaintForm']) ?>

                    <h6 class="text-primary fw-bold text-uppercase mb-3">
                        <i class="bi bi-info-circle-fill me-2"></i> Case Details
                    </h6>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Complaint Category <span class="text-danger">*</span></label>
                        <?= $this->Form->select('category', 
                            [
                                'General' => 'General', 
                                'Salary' => 'Salary', 
                                'Termination' => 'Termination', 
                                'Foreign Worker' => 'Foreign Worker'
                            ], 
                            ['empty' => 'Select a category', 'class' => 'form-select p-3 rounded-3 bg-light border-0', 'required' => true]
                        ) ?>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold small text-muted text-uppercase">Description of Complaint <span class="text-danger">*</span></label>
                        <?= $this->Form->textarea('complaint_text', [
                            'class' => 'form-control p-3 rounded-3 bg-light border-0', 
                            'placeholder' => 'Describe the issue in detail...', 
                            'rows' => 5,
                            'required' => true
                        ]) ?>
                    </div>

                    <hr class="my-5 opacity-25">
                    
                    <div class="d-flex align-items-center mb-3">
                        <h6 class="text-primary fw-bold text-uppercase mb-0 me-3">
                            <i class="bi bi-people-fill me-2"></i> Group Complainants
                        </h6>
                        
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="toggleGroup" style="cursor: pointer;">
                            <label class="form-check-label small fw-bold text-muted pt-1" for="toggleGroup" style="cursor: pointer;">
                                (Tick to add others)
                            </label>
                        </div>
                    </div>

                    <div id="groupSection" style="display: none;" class="bg-light p-4 rounded-4 border mb-4">
                        <div class="row g-3">
                            <?php for ($i = 1; $i <= 3; $i++): ?>
                            <div class="col-md-6">
                                <?= $this->Form->control("comp_name_$i", [
                                    'label' => ['text' => "Person $i Name", 'class' => 'small fw-bold text-muted'], 
                                    'class' => 'form-control rounded-3',
                                    'required' => false
                                ]) ?>
                            </div>
                            <div class="col-md-6">
                                <?= $this->Form->control("comp_ic_$i", [
                                    'label' => ['text' => "Person $i IC", 'class' => 'small fw-bold text-muted'], 
                                    'class' => 'form-control rounded-3',
                                    'required' => false
                                ]) ?>
                            </div>
                            <?php endfor; ?>
                        </div>
                    </div>

                    <hr class="my-5 opacity-25">
                    <h6 class="text-primary fw-bold text-uppercase mb-3">
                        <i class="bi bi-building me-2"></i> Employer Details
                    </h6>

                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Company Name <span class="text-danger">*</span></label>
                            <?= $this->Form->text('employer_name', ['class' => 'form-control p-3 rounded-3', 'required' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Person In Charge <span class="text-danger">*</span></label>
                            <?= $this->Form->text('person_in_charge', ['class' => 'form-control p-3 rounded-3', 'required' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Employer Contact (Tel) <span class="text-danger">*</span></label>
                            <?= $this->Form->text('employer_tel', ['class' => 'form-control p-3 rounded-3', 'required' => true]) ?>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted text-uppercase">Employer Email <span class="text-danger">*</span></label>
                            <?= $this->Form->email('employer_email', ['class' => 'form-control p-3 rounded-3', 'required' => true]) ?>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted text-uppercase">Employer Address <span class="text-danger">*</span></label>
                            <?= $this->Form->textarea('employer_address', ['class' => 'form-control p-3 rounded-3', 'rows' => 2, 'required' => true]) ?>
                        </div>
                    </div>

                    <hr class="my-5 opacity-25">
                    <h6 class="text-primary fw-bold text-uppercase mb-3">
                        <i class="bi bi-paperclip me-2"></i> Evidence (Optional)
                    </h6>
                    
                    <div class="p-4 bg-light rounded-3 border border-dashed text-center">
                        <i class="bi bi-cloud-arrow-up fs-1 text-muted mb-3"></i>
                        <div class="mb-3">
                            <label for="file-path" class="form-label fw-bold">Upload Supporting Document</label>
                            <input type="file" name="file_path" id="file-path" class="form-control w-50 mx-auto">
                        </div>
                        <small class="text-muted d-block">Supported: JPG, PNG, JPEG (Max 5MB)</small>
                    </div>

                    <div class="d-flex justify-content-end gap-3 mt-5">
                        <?= $this->Html->link('Cancel', ['action' => 'index'], ['class' => 'btn btn-light border px-4 py-2 fw-bold rounded-3']) ?>
                        
                        <button type="button" class="btn btn-primary px-5 py-2 fw-bold rounded-3 shadow-sm" 
                                style="background-color: var(--jtk-navy); border: none;"
                                onclick="confirmSubmission()">
                            Submit Complaint <i class="bi bi-send-fill ms-2"></i>
                        </button>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="submitModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 p-4 text-center shadow-lg">
            
            <div class="mb-3 d-flex justify-content-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                     style="width: 70px; height: 70px; background-color: #e0f2fe; color: #0284c7;">
                    <i class="bi bi-question-circle-fill display-5"></i>
                </div>
            </div>

            <h4 class="fw-bold mb-2 text-dark">Confirm Submission?</h4>
            <p class="text-muted small mb-4">
                Are you sure you want to officially submit this complaint? <br>
                Please ensure all details and evidence are accurate before proceeding.
            </p>

            <div class="d-flex justify-content-center gap-2">
                <button type="button" class="btn btn-light fw-bold px-4 rounded-3" data-bs-dismiss="modal">
                    Review Again
                </button>
                
                <button type="button" onclick="submitFinalForm()" 
                        class="btn btn-primary fw-bold px-4 rounded-3" 
                        style="background-color: var(--jtk-navy); border: none;">
                    Yes, Submit Now
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    // 1. Toggle Group Section
    document.getElementById('toggleGroup').addEventListener('change', function() {
        document.getElementById('groupSection').style.display = this.checked ? 'block' : 'none';
    });

    // 2. Validation Check before showing Modal
    function confirmSubmission() {
        var form = document.getElementById('complaintForm');
        
        // Check if the HTML5 required fields are filled
        if (form.checkValidity()) {
            var myModal = new bootstrap.Modal(document.getElementById('submitModal'));
            myModal.show();
        } else {
            // If fields are empty, show the browser's default validation messages
            form.reportValidity();
        }
    }

    // 3. Actual Form Submit
    function submitFinalForm() {
        document.getElementById('complaintForm').submit();
    }
</script>

<script>
    document.getElementById('toggleGroup').addEventListener('change', function() {
        document.getElementById('groupSection').style.display = this.checked ? 'block' : 'none';
    });

    function validateAndShowModal() {
        var form = document.getElementById('complaintForm');
        if (form.checkValidity()) {
            new bootstrap.Modal(document.getElementById('submitModal')).show();
        } else {
            form.reportValidity();
        }
    }
</script>