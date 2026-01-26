<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - JTK System</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root { --jtk-navy: #003366; }
        
        body { 
            background: url('<?= $this->Url->webroot("img/compbg.png") ?>') no-repeat center center fixed; 
            background-size: cover;
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
        }

        .page-overlay {
            min-height: 100vh;
            display: flex;
            align-items: center; /* Centers card vertically */
            justify-content: center; /* Centers card horizontally */
            background: rgba(255, 255, 255, 0.2); /* Slight overlay to make image pop */
            padding: 20px;
        }

        .auth-card {
            background: #ffffff;
            width: 100%;
            max-width: 600px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 40px;
            border-top: 5px solid var(--jtk-navy); /* Design accent */
        }

        .form-label { 
            font-size: 0.7rem; 
            font-weight: 700; 
            text-transform: uppercase; 
            color: #64748b; 
            margin-bottom: 5px; 
        }
        
        .form-control, .form-select {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 10px 15px;
            border-radius: 8px;
            font-size: 0.9rem;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--jtk-navy);
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
        }

        .btn-submit {
            background-color: var(--jtk-navy);
            color: white;
            padding: 14px;
            border-radius: 8px;
            font-weight: 700;
            border: none;
            width: 100%;
            margin-top: 20px;
            text-transform: uppercase;
        }
        
        .btn-submit:hover { background-color: #002244; }
    </style>
</head>
<body>

    <div class="page-overlay">
        <div class="auth-card">
            
            <div class="text-center mb-4">
                <div class="mb-2">
                    <i class="bi bi-person-plus-fill text-muted fs-1"></i>
                </div>
                <h2 class="fw-bold" style="color: var(--jtk-navy);">Create Account</h2>
                <p class="text-muted small">Join the JTK System to manage your complaints.</p>
            </div>

            <?= $this->Flash->render() ?>

            <?= $this->Form->create($user) ?>
            
            <div class="row g-3">
                <div class="col-12">
                    <label class="form-label">Full Name</label>
                    <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control', 'required' => true, 'placeholder' => 'Enter full name']) ?>
                </div>

                 <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">IC Number / Passport </label>
                    <?= $this->Form->control('ic_number', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'e.g. 990101015555 (Without dashes)',
                        'required' => true,
                        // STRICT RULES:
                        'pattern' => '\d{12}',       // Must be exactly 12 numbers
                        'maxlength' => '12',         // Cannot type more than 12
                        'oninput' => "this.value = this.value.replace(/[^0-9]/g, '')", // Auto-delete letters
                        'title' => 'Please enter exactly 12 digits without dashes'
                    ]) ?>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Age</label>
                    <?= $this->Form->control('age', ['label' => false, 'class' => 'form-control', 'required' => true, 'type' => 'number', 'placeholder' => '25']) ?>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Gender</label>
                    <?= $this->Form->select('gender', ['Male' => 'Male', 'Female' => 'Female'], ['empty' => 'Select Gender', 'class' => 'form-select', 'required' => true]) ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Nationality</label>
                    <?= $this->Form->control('nationality', ['label' => false, 'class' => 'form-control', 'required' => true, 'value' => 'Malaysian']) ?>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold small text-muted">Phone Number</label>
                    <?= $this->Form->control('phone', [
                        'label' => false,
                        'class' => 'form-control',
                        'placeholder' => 'e.g. 0123456789',
                        'required' => true,
                        // STRICT RULES:
                        'pattern' => '^01[0-9]{8,9}$', // Must start with '01' + 8 or 9 digits
                        'maxlength' => '11',
                        'oninput' => "this.value = this.value.replace(/[^0-9]/g, '')",
                        'title' => 'Please enter a valid Malaysian mobile number (e.g. 012...)'
                    ]) ?>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email Address</label>
                    <?= $this->Form->control('email', ['label' => false, 'class' => 'form-control', 'required' => true, 'placeholder' => 'name@example.com']) ?>
                </div>

                <div class="mb-3">
    <label class="form-label fw-bold small text-muted">Address</label>
    
    <?= $this->Form->control('addr_line', [
        'label' => false, 
        'class' => 'form-control mb-2', 
        'placeholder' => 'No. 123, Jalan Example, Taman Demo',
        'required' => true
    ]) ?>

    <div class="row g-2">
        <div class="col-md-4">
            <?= $this->Form->control('addr_postcode', [
                'label' => false, 
                'class' => 'form-control', 
                'placeholder' => 'Postcode',
                'pattern' => '\d{5}',         // Must be exactly 5 digits
                'maxlength' => '5',           // Cannot type more than 5
                'minlength' => '5',           // Cannot type less than 5
                'oninput' => "this.value = this.value.replace(/[^0-9]/g, '')", // Auto-remove letters
                'title' => 'Please enter a valid 5-digit postcode', // Error message
                'required' => true
            ]) ?>
        </div>
        
        <div class="col-md-4">
            <?= $this->Form->control('addr_city', [
                'label' => false, 
                'class' => 'form-control', 
                'placeholder' => 'City',
                'required' => true
            ]) ?>
        </div>
        
        <div class="col-md-4">
            <?= $this->Form->select('addr_state', 
                ['Johor'=>'Johor', 'Kedah'=>'Kedah', 'Kelantan'=>'Kelantan', 'Melaka'=>'Melaka', 'Negeri Sembilan'=>'Negeri Sembilan', 'Pahang'=>'Pahang', 'Perak'=>'Perak', 'Perlis'=>'Perlis', 'Pulau Pinang'=>'Pulau Pinang', 'Sabah'=>'Sabah', 'Sarawak'=>'Sarawak', 'Selangor'=>'Selangor', 'Terengganu'=>'Terengganu', 'W.P. Kuala Lumpur'=>'W.P. Kuala Lumpur'], 
                ['empty' => 'State', 'class' => 'form-select', 'required' => true]
            ) ?>
        </div>
    </div>
</div>

                <div class="col-12">
                    <label class="form-label">Create Password</label>
                    <?= $this->Form->control('password', ['label' => false, 'class' => 'form-control', 'required' => true, 'type' => 'password', 'placeholder' => 'Min. 8 characters']) ?>
                </div>
            </div>

            <button type="submit" class="btn-submit">Sign Up</button>
            
            <?= $this->Form->end() ?>

            <div class="text-center mt-3">
                <small class="text-muted">Already have an account? <a href="<?= $this->Url->build(['action' => 'login']) ?>" class="fw-bold" style="color: var(--jtk-navy);">Login</a></small>
            </div>
        </div>
    </div>

</body>
</html>