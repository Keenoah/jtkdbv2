<?php
/**
 * Admin Layout - JTK System
 * Features: Sidebar Logic, Responsive Nav, Aesthetic Logout Modal
 */
$cakeDescription = 'JTK Admin Portal';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->fetch('title') ?></title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <?= $this->Html->meta('icon') ?>

    <style>
        :root {
            --jtk-navy: #003366; 
            --jtk-navy-dark: #002244;
            --bg-light: #f8fafc;
            --text-main: #1e293b;
        }

        body { background-color: var(--bg-light); font-family: 'Inter', sans-serif; color: var(--text-main); }

        /* Sidebar Wrapper */
        .sidebar-wrapper { 
            width: 280px; height: 100vh; position: fixed; left: 0; top: 0; z-index: 1000; 
            background: var(--jtk-navy); border-right: 1px solid rgba(0,0,0,0.05); 
            display: flex; flex-direction: column;
        }

        .sidebar-menu { flex-grow: 1; overflow-y: auto; padding-bottom: 20px; }

        sidebar-footer {
            padding: 40px 25px; /* Matches the padding of the top header */
            background: transparent; /* No dark box */
            border: none; /* No line */
            margin-top: auto; /* Pushes it to the very bottom */
        }

        /* MATCHED HEADER STYLE FROM USER PORTAL */
        .sidebar-header {
            padding: 30px 25px;
            margin-bottom: 10px;
        }

        /* MAIN CONTENT AREA */
        main { 
            margin-left: 280px; 
            min-height: 100vh; 
            transition: 0.3s ease; 
            padding: 30px; 
        }

        /* Mobile Nav */
        .mobile-nav { 
            display: none; background: var(--jtk-navy); padding: 15px 20px; 
            align-items: center; justify-content: space-between; color: white; 
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Mobile Responsiveness */
        @media (max-width: 991.98px) {
            .sidebar-wrapper { 
                position: relative; width: 100%; height: auto; max-height: 0; 
                overflow: hidden; transition: max-height 0.4s ease-in-out;
            }
            .mobile-nav { display: flex; position: sticky; top: 0; z-index: 1050; }
            main { margin-left: 0; padding: 20px; }
            .sidebar-wrapper.active { max-height: 100vh; }
        }

        .menu-label { color: rgba(255,255,255,0.4); font-size: 0.7rem; font-weight: 700; text-transform: uppercase; padding: 0 25px; margin: 20px 0 10px 0; }
        
        .sidebar-link {
            display: flex; align-items: center; gap: 12px;
            color: rgba(255,255,255,0.7); text-decoration: none;
            padding: 12px 25px; font-size: 0.95rem; transition: 0.2s;
            border-left: 4px solid transparent;
        }
        .sidebar-link:hover, .sidebar-link.active {
            color: white; background: rgba(255,255,255,0.1);
            border-left-color: #60a5fa;
        }

        /* Logout Button Style */
        .btn-logout {
            display: block; width: 100%; padding: 10px; text-align: center;
            background-color: #dc3545; color: white !important;
            border-radius: 8px; font-weight: 600; text-decoration: none;
            transition: background 0.2s; border: 1px solid #b02a37; cursor: pointer;
        }
        .btn-logout:hover { background-color: #bb2d3b; }
    </style>
</head>
<body>

    <div class="mobile-nav">
        <div class="d-flex align-items-center gap-2">
            <?= $this->Html->image('jatanegara.png', ['style' => 'height: 30px;']) ?>
            <span class="fw-bold tracking-wide">ADMIN PANEL</span>
        </div>
        <button class="btn btn-link text-white p-0 border-0" onclick="toggleMenu()">
            <i class="bi bi-list fs-1"></i>
        </button>
    </div>

    <div class="sidebar-wrapper" id="sidebarMenu">
        
        <div class="sidebar-header d-flex align-items-center gap-3">
            <?= $this->Html->image('jatanegara.png', [
                'alt' => 'Logo',
                'style' => 'width: 40px; height: auto;'
            ]) ?>
            <div>
                <h5 class="m-0 fw-bold text-white" style="letter-spacing: 1px;">ADMIN PANEL</h5>
            </div>
        </div>
        
        <div class="sidebar-menu">
            <div class="menu-label">Main Menu</div>
            
            <?php 
                $isActive = $this->getRequest()->getParam('controller') === 'Admins' 
                          && $this->getRequest()->getParam('action') === 'index'; 
            ?>
            <?= $this->Html->link('<i class="bi bi-grid-1x2"></i> Dashboard', 
                ['controller' => 'Admins', 'action' => 'index'], 
                ['class' => 'sidebar-link ' . ($isActive ? 'active' : ''), 'escape' => false]) ?>

            <?php 
                $isCases = $this->getRequest()->getParam('controller') === 'Admins' 
                        && $this->getRequest()->getParam('action') === 'allCases' 
                        && empty($this->getRequest()->getQuery('status')); 
            ?>
            <?= $this->Html->link('<i class="bi bi-stack"></i> All Cases', 
                ['controller' => 'Admins', 'action' => 'allCases'], 
                ['class' => 'sidebar-link ' . ($isCases ? 'active' : ''), 'escape' => false]) ?>
                
            <?php $isReports = $this->getRequest()->getParam('controller') === 'Reports'; ?>
            <?= $this->Html->link('<i class="bi bi-bar-chart"></i> Reports', 
                ['controller' => 'Reports', 'action' => 'index'], 
                ['class' => 'sidebar-link ' . ($isReports ? 'active' : ''), 'escape' => false]) ?>

            <div class="menu-label">Management</div>

            <?php $isOfficers = $this->getRequest()->getParam('controller') === 'Officers'; ?>
            <?= $this->Html->link('<i class="bi bi-people-fill"></i> Officers', 
                ['controller' => 'Officers', 'action' => 'index'], 
                ['class' => 'sidebar-link ' . ($isOfficers ? 'active' : ''), 'escape' => false]) ?>

            <div class="menu-label">Lifecycle</div>

            <?php $isSub = $this->getRequest()->getQuery('status') === 'Submitted'; ?>
            <?= $this->Html->link('<i class="bi bi-plus-circle"></i> Submitted', 
                ['controller' => 'Admins', 'action' => 'allCases', '?' => ['status' => 'Submitted']], 
                ['class' => 'sidebar-link ' . ($isSub ? 'active' : ''), 'escape' => false]) ?>

            <?php $isInProg = $this->getRequest()->getQuery('status') === 'In Progress'; ?>
            <?= $this->Html->link('<i class="bi bi-arrow-repeat"></i> In Progress', 
                ['controller' => 'Admins', 'action' => 'allCases', '?' => ['status' => 'In Progress']], 
                ['class' => 'sidebar-link ' . ($isInProg ? 'active' : ''), 'escape' => false]) ?>

            <?php $isSet = $this->getRequest()->getQuery('status') === 'Settled'; ?>
            <?= $this->Html->link('<i class="bi bi-check-circle-fill"></i> Settled', 
                ['controller' => 'Admins', 'action' => 'allCases', '?' => ['status' => 'Settled']], 
                ['class' => 'sidebar-link ' . ($isSet ? 'active' : ''), 'escape' => false]) ?>
        </div>

        <div class="sidebar-footer mt-auto p-4">
            <button type="button" 
               class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2 py-2 rounded-3 shadow-sm border-0"
               data-bs-toggle="modal" 
               data-bs-target="#logoutModal">
                <i class="bi bi-box-arrow-right"></i> Logout
            </button>
        </div>
    </div>

    <main>
        <?= $this->Flash->render() ?>
        <?= $this->fetch('content') ?>
    </main>

    <div class="modal fade" id="logoutModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 border-0 p-4 text-center shadow-lg">
                <div class="mb-3 d-flex justify-content-center">
                    <div class="rounded-circle d-flex align-items-center justify-content-center" 
                         style="width: 70px; height: 70px; background-color: #fee2e2; color: #dc2626;">
                        <i class="bi bi-box-arrow-right display-5 ps-1"></i>
                    </div>
                </div>
                <h4 class="fw-bold mb-2 text-dark">Signing Out?</h4>
                <p class="text-muted small mb-4">
                    You are about to end your secure session.<br>
                    Please confirm to exit the Admin Panel.
                </p>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-light fw-bold px-4 rounded-3 border" data-bs-dismiss="modal">
                        Cancel
                    </button>
                    <?= $this->Html->link('Yes, Sign Out', 
                        ['controller' => 'Admins', 'action' => 'logout'], 
                        ['class' => 'btn btn-danger fw-bold px-4 rounded-3']) ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleMenu() {
            document.getElementById('sidebarMenu').classList.toggle('active');
        }
    </script>
</body>
</html>