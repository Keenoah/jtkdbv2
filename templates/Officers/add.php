<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Officer $officer
 * @var array $departments
 */
?>
<div class="container-fluid py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1" style="color: var(--jtk-navy);">
                        <?= $this->request->getParam('action') === 'add' ? 'Register New Officer' : 'Edit Officer Record' ?>
                    </h4>
                    <p class="text-muted small mb-0">Enter the staff details and assign a unit.</p>
                </div>
                <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-outline-secondary px-4 fw-bold rounded-2">
                    Cancel
                </a>
            </div>

            <div class="card border shadow-sm rounded-3 bg-white">
                <div class="card-header bg-light border-bottom py-3 px-4">
                    <h6 class="text-uppercase fw-bold text-muted mb-0 small" style="letter-spacing: 1px;">Officer Information</h6>
                </div>
                <div class="card-body p-4">
                    <?= $this->Form->create($officer) ?>
                    
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small">FULL NAME</label>
                            <?= $this->Form->control('name', [
                                'label' => false, 
                                'class' => 'form-control rounded-2 border-secondary-subtle py-2',
                                'placeholder' => 'Enter officer\'s full name'
                            ]) ?>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small">EMAIL ADDRESS</label>
                            <?= $this->Form->control('email', [
                                'label' => false, 
                                'class' => 'form-control rounded-2 border-secondary-subtle py-2',
                                'placeholder' => 'officer@jtk.gov.my'
                            ]) ?>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold text-dark small">ASSIGNED DEPARTMENT</label>
                            
                            <div class="input-group">
                                <span class="input-group-text bg-light border-secondary-subtle"><i class="bi bi-building"></i></span>
                                <?= $this->Form->control('department', [
                                    'label' => false, 
                                    'type' => 'text', 
                                    'class' => 'form-control border-secondary-subtle py-2',
                                    'placeholder' => 'Enter department',
                                    'list' => 'departmentOptions',
                                    'autocomplete' => 'off'
                                ]) ?>
                            </div>
                           
                        </div>

                        <div class="col-12 mt-3">
                            <hr class="text-muted opacity-25 mb-4">
                            <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-2 shadow-sm" style="background-color: var(--jtk-navy); border:none;">
                                <i class="bi bi-save me-2"></i> 
                                <?= $this->request->getParam('action') === 'add' ? 'Add Officer' : 'Save Changes' ?>
                            </button>
                        </div>
                    </div>

                    <?= $this->Form->end() ?>
                </div>
            </div>

        </div>
    </div>
</div>