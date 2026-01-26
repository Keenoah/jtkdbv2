<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-11">
            <div class="mb-4 text-center">
                <h2 class="fw-bold" style="color: var(--jtk-navy);">Account Settings</h2>
                <p class="text-muted">Manage your personal information and verified identity.</p>
            </div>

            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="bi bi-person-badge fs-2" style="color: var(--jtk-navy);"></i>
                        </div>
                    </div>

                    <?= $this->Form->create($user, ['id' => 'profileForm']) ?>
                    
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="small fw-bold text-muted text-uppercase mb-2">
                                Full Name <i class="bi bi-patch-check-fill text-primary ms-1" title="Verified Identity"></i> (Verified)
                            </label>
                            <div class="p-3 bg-light rounded-3 border fw-bold text-dark">
                                <?= h($user->name) ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="small fw-bold text-muted text-uppercase mb-2">
                                IC Number <i class="bi bi-patch-check-fill text-primary ms-1" title="Verified Identity"></i> (Verified)
                            </label>
                            <div class="p-3 bg-light rounded-3 border fw-bold text-dark">
                                <?= h($user->ic_number ?? 'Not provided') ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <?= $this->Form->control('email', [
                                'label' => ['class' => 'small fw-bold text-muted text-uppercase mb-2', 'text' => 'Email Address'],
                                'class' => 'form-control p-3 rounded-3',
                                'readonly' => true 
                            ]) ?>
                        </div>

                        <div class="col-md-6">
                            <?= $this->Form->control('phone', [
                                'label' => ['class' => 'small fw-bold text-muted text-uppercase mb-2', 'text' => 'Phone Number'],
                                'class' => 'form-control p-3 rounded-3'
                            ]) ?>
                        </div>

                        <div class="col-12">
                            <?= $this->Form->control('address', [
                                'label' => ['class' => 'small fw-bold text-muted text-uppercase mb-2', 'text' => 'Home Address'],
                                'class' => 'form-control p-3 rounded-3',
                                'rows' => 3
                            ]) ?>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-primary px-4 py-2 fw-bold rounded-3 shadow-sm" 
                                style="background-color: var(--jtk-navy); border: none;"
                                data-bs-toggle="modal" data-bs-target="#saveModal">
                            <i class="bi bi-check-lg me-2"></i> Save Changes
                        </button>
                    </div>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="saveModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content rounded-4 border-0 p-4 text-center shadow-lg">
            
            <div class="mb-3 d-flex justify-content-center">
                <div class="rounded-circle d-flex align-items-center justify-content-center" 
                     style="width: 70px; height: 70px; background-color: #d1fae5; color: #059669;">
                    <i class="bi bi-pencil-square display-5"></i>
                </div>
            </div>

            <h4 class="fw-bold mb-2 text-dark">Confirm Updates?</h4>
            <p class="text-muted small mb-4">Are you sure you want to save these changes to your profile?</p>

            <div class="d-flex justify-content-center gap-2">
                <button type="button" class="btn btn-light fw-bold px-4 rounded-3" data-bs-dismiss="modal">
                    Cancel
                </button>
                
                <button type="button" onclick="document.getElementById('profileForm').submit();" 
                        class="btn btn-success fw-bold px-4 rounded-3 text-white">
                    Yes, Save Updates
                </button>
            </div>

        </div>
    </div>
</div>