<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - JTK System</title>
    
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

        .login-overlay {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
        }

        .auth-card {
            background: #ffffff;
            width: 100%;
            max-width: 450px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
            padding: 40px;
            border-top: 5px solid var(--jtk-navy);
        }

        .form-label { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: #64748b; margin-bottom: 8px; }
        
        .form-control {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px 15px;
            border-radius: 8px;
            font-size: 0.95rem;
        }
        
        .form-control:focus {
            border-color: var(--jtk-navy);
            background-color: #fff;
            box-shadow: 0 0 0 3px rgba(0, 51, 102, 0.1);
        }

        .btn-signin {
            background: var(--jtk-navy);
            color: white;
            padding: 12px;
            border-radius: 50px;
            font-weight: 700;
            border: none;
            width: 100%;
            margin-top: 15px;
        }
        
        .btn-signin:hover { background-color: #002244; }
        a { text-decoration: none; color: var(--jtk-navy); font-weight: 700; }
    </style>
</head>
<body>

<?php
$role = $this->request->getQuery('role');
$title = ($role === 'staff') ? 'Staff Access' : 'Welcome Back';
$subtitle = ($role === 'staff') ? 'Authorized JTK Personnel Only' : 'Log in to manage your submissions';
?>

<div class="login-overlay">
    <div class="auth-card">
        <div class="text-center mb-4">
            <?= $this->Html->image('jatanegara.png', ['style' => 'width: 70px; height: auto;', 'class' => 'mb-3']) ?>
            <h2 class="fw-bold" style="color: var(--jtk-navy);"><?= h($title) ?></h2>
            <p class="text-muted small"><?= h($subtitle) ?></p>
        </div>

        <?= $this->Flash->render() ?>

        <?= $this->Form->create() ?>
            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <?= $this->Form->control('email', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'name@example.com',
                    'required' => true
                ]) ?>
            </div>
            <div class="mb-4">
                <label class="form-label">Password</label>
                <?= $this->Form->control('password', [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Enter password',
                    'required' => true
                ]) ?>
            </div>
            
            <?= $this->Form->button(__('Sign In'), ['class' => 'btn-signin']) ?>
        <?= $this->Form->end() ?>
        
        <div class="text-center mt-4">
            <?php if ($role !== 'staff'): ?>
                <p class="small text-muted mb-1">New here? 
                    <?= $this->Html->link('Create an account', ['action' => 'add']) ?>
                </p>
            <?php endif; ?>
            <p class="small">
                <?= $this->Html->link('← Back to Home', '/', ['class' => 'text-muted fw-normal']) ?>
            </p>
        </div>
    </div>
</div>

</body>
</html>