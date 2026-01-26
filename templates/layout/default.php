<?php
/**
 * @var \App\View\AppView $this
 */

// Check if a user is currently logged in
$identity = $this->request->getAttribute('identity');
// Determine if the user is staff or public
$isStaff = $identity && $identity->get('role') === 'staff';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        JTK System: <?= $this->fetch('title') ?>
    </title>
    
    <?= $this->Html->meta('icon', '/img/jatanegara.png') ?>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <?= $this->Html->css(['style']) ?>

   <style>
    :root {
        --sidebar-bg: #003366; 
        --sidebar-width: 260px;
        --active-blue: #0d6efd; 
        --text-color: #f8f9fa;
        --jtk-navy: #003366;
    }

    body {
        background-color: #f5f7fa; 
        font-family: 'Inter', sans-serif;
    }

    /* SIDEBAR CONTAINER */
    .sidebar-wrapper {
        width: var(--sidebar-width);
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        background-color: var(--sidebar-bg);
        color: white;
        display: flex;
        flex-direction: column;
        z-index: 1000;
        box-shadow: 4px 0 10px rgba(0,0,0,0.1);
    }

    /* HEADER: "USER PORTAL" */
    .sidebar-header {
        padding: 30px 25px;
        margin-bottom: 10px;
    }

    /* SECTION HEADERS (MAIN MENU, RECORDS) */
    .nav-header {
        font-size: 0.7rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: rgba(255, 255, 255, 0.4); 
        padding: 0 25px;
        margin-bottom: 8px;
        margin-top: 10px;
    }

    /* NAVIGATION LINKS */
    .nav-link {
        color: rgba(255, 255, 255, 0.75); 
        padding: 12px 25px;
        display: flex;
        align-items: center;
        gap: 15px; 
        text-decoration: none;
        font-weight: 500;
        font-size: 0.95rem;
        transition: all 0.2s ease;
        border-left: 4px solid transparent; 
    }

    .nav-link i {
        font-size: 1.1rem;
    }

    /* HOVER STATE */
    .nav-link:hover {
        color: white;
        background-color: rgba(255, 255, 255, 0.05);
    }

    /* ACTIVE STATE */
    .nav-link.active {
        color: white;
        background: linear-gradient(90deg, rgba(255,255,255,0.1) 0%, transparent 100%);
        border-left-color: #38bdf8; 
        font-weight: 600;
    }
    
    /* CONTENT AREA OFFSET */
    main {
        margin-left: var(--sidebar-width);
        padding: 40px;
        min-height: 100vh;
    }

    /* MOBILE RESPONSIVENESS */
    @media (max-width: 991.98px) {
        .sidebar-wrapper { left: -100%; transition: 0.3s; }
        .sidebar-wrapper.show { left: 0; }
        main { margin-left: 0; padding: 20px; }
    }

    /* FLASH MESSAGE STYLING */
    .message.success {
        background-color: #d1fae5; /* Light Green Background */
        color: #065f46;            /* Dark Green Text */
        border: 1px solid #a7f3d0;
        padding: 15px 20px;
        margin-bottom: 20px;
        border-radius: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    
    /* Optional: Add a checkmark icon before the text using CSS */
    .message.success::before {
        content: "\F26A"; /* Bootstrap Icon Code for check-circle-fill */
        font-family: "bootstrap-icons";
        margin-right: 10px;
        font-size: 1.2rem;
    }

    /* ERROR MESSAGES (Just in case) */
    .message.error {
        background-color: #fee2e2;
        color: #991b1b;
        border: 1px solid #fecaca;
        padding: 15px;
        border-radius: 12px;
        margin-bottom: 20px;
    }
    
</style>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="sidebar-wrapper">
        <div class="sidebar-header d-flex align-items-center gap-3">
            <?= $this->Html->image('jatanegara.png', [
    'alt' => 'Logo',
    'style' => 'width: 40px; height: auto;'
]) ?>
            <div>
                <h5 class="m-0 fw-bold text-white" style="letter-spacing: 1px;">USER PORTAL</h5>
            </div>
        </div>

        <div class="nav-header">MAIN MENU</div>
        
        <a href="<?= $this->Url->build(['controller' => 'Complaints', 'action' => 'index']) ?>" 
           class="nav-link <?= $this->request->getParam('action') === 'index' ? 'active' : '' ?>">
            <i class="bi bi-columns-gap"></i> 
            <span>Dashboard</span> 
        </a>

        <a href="<?= $this->Url->build(['controller' => 'Complaints', 'action' => 'add']) ?>" 
           class="nav-link <?= $this->request->getParam('action') === 'add' ? 'active' : '' ?>">
            <i class="bi bi-pencil-square"></i> 
            <span>Submit Case</span>
        </a>

        <div class="nav-header mt-3">RECORDS</div>

        <a href="<?= $this->Url->build(['controller' => 'Complaints', 'action' => 'history']) ?>" 
           class="nav-link <?= $this->request->getParam('action') === 'history' ? 'active' : '' ?>">
            <i class="bi bi-clock-history"></i> 
            <span>History</span>
        </a>

        <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'profile']) ?>" 
           class="nav-link <?= $this->request->getParam('controller') === 'Users' ? 'active' : '' ?>">
            <i class="bi bi-person-gear"></i> 
            <span>Profile</span>
        </a>

        <div class="mt-auto p-4">
    <a href="#" 
       class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2 py-2 rounded-3 shadow-sm border-0"
       data-bs-toggle="modal" 
       data-bs-target="#logoutModal">
        <i class="bi bi-box-arrow-right"></i> Logout
    </a>
</div>
    </nav>

    <main>
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>
    
    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content rounded-4 border-0 p-5 text-center shadow-lg">
                
                <div class="mb-4 d-flex justify-content-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 80px; height: 80px; background-color: #fee2e2; color: #dc2626;">
                        <i class="bi bi-box-arrow-right display-4"></i>
                    </div>
                </div>

                <h3 class="fw-bold mb-2 text-dark">Signing Out?</h3>
                <p class="text-muted mb-4 fs-5">Are you sure you want to end your session?</p>

                <div class="d-flex justify-content-center gap-3">
                    <button type="button" class="btn btn-light fw-bold px-4 py-3 rounded-3 fs-6" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    
                    <a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'logout']) ?>" 
                       class="btn btn-danger fw-bold px-5 py-3 rounded-3 fs-6 shadow-sm">
                        Yes, Logout
                    </a>
                </div>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>