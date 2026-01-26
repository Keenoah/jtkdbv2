<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @var \App\View\AppView $this
 */
$this->layout = 'landing'; 
?>

<div class="landing-card fade-in">
    <?= $this->Html->image('jatanegara.png', ['alt' => 'Jatanegara', 'class' => 'logo-img']) ?>

    <div>
        <span class="badge-pill-blue">Jabatan Tenaga Kerja</span>
    </div>
    
    <h2 class="fw-bold text-dark mb-3">Complaint System</h2>
    
    <p class="text-muted mb-4 small" style="line-height: 1.6;">
        Empowering workplace integrity through a secure and transparent platform. Submit and track your cases efficiently.
    </p>

    <?= $this->Html->link(
        '<i class="bi bi-person-fill me-2"></i> Public Login',
        ['controller' => 'Users', 'action' => 'login'],
        ['class' => 'btn btn-primary-jtk', 'escape' => false]
    ) ?>

    <?= $this->Html->link(
        '<i class="bi bi-pencil-square me-2"></i> Create Account',
        ['controller' => 'Users', 'action' => 'add'], 
        ['class' => 'btn btn-outline-jtk', 'escape' => false]
    ) ?>

    <div class="mt-4 pt-3 border-top">
        <?= $this->Html->link(
            '<i class="bi bi-lock-fill"></i> ADMIN & STAFF ACCESS', 
            ['controller' => 'Admins', 'action' => 'login'],       
            [
                'class' => 'admin-link', 
                'escape' => false  
            ]
        ) ?>
    </div>
</div>