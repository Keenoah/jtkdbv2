<?php
/**
 * Reports Analytics View
 * Features: Professional PDF Print Layout
 */
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    /* --- SCREEN STYLES --- */
    .report-card {
        background: white; border-radius: 12px; padding: 25px;
        border: 1px solid #e2e8f0; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.02);
        height: 100%;
    }
    .chart-container { position: relative; height: 300px; width: 100%; }
    .print-btn { background: #003366; color: white; border: none; padding: 10px 20px; border-radius: 8px; font-weight: 600; }
    .print-btn:hover { background: #002244; color: white; }
    .print-only { display: none; }

    /* --- PRINT STYLES --- */
    @media print {
        @page { size: A4; margin: 15mm; }
        body { background: white; font-family: 'Arial', sans-serif; -webkit-print-color-adjust: exact; }
        
        /* Hide UI */
        .sidebar-wrapper, .mobile-nav, .print-btn, .no-print { display: none !important; }
        .print-only { display: block !important; }
        
        /* Reset Layout */
        main { margin: 0 !important; padding: 0 !important; width: 100% !important; }
        .container-fluid, .row, .col-12, .col-lg-6 { 
            width: 100% !important; margin: 0 !important; padding: 0 !important; display: block !important; 
        }
        
        /* Styles for Report Elements */
        .report-card { border: none !important; box-shadow: none !important; padding: 0 !important; margin-bottom: 30px !important; }
        
        /* Header Style */
        .doc-header-row { 
            display: flex !important; align-items: center; gap: 15px; 
            border-bottom: 2px solid #000; padding-bottom: 15px; margin-bottom: 30px; 
        }
        .doc-title { font-size: 16pt; font-weight: bold; text-transform: uppercase; margin: 0; color: #003366; }
        .doc-subtitle { font-size: 10pt; color: #555; margin: 0; }
        
        /* Section Headers */
        h6 { 
            background-color: #f3f4f6 !important; color: #000 !important; 
            font-size: 10pt; font-weight: bold; text-transform: uppercase; 
            padding: 8px; border-left: 4px solid #003366; margin-bottom: 15px; 
        }
        
        /* Charts need fixed height to print */
        .chart-container { height: 250px !important; width: 80% !important; margin: 0 auto 30px auto; }
        
        /* Table Border */
        .table { border: 1px solid #000 !important; font-size: 10pt; }
        .table th { background-color: #eee !important; color: black !important; border: 1px solid #000; }
        .table td { border: 1px solid #000; }
        .progress { border: 1px solid #ccc; }
    }
</style>

<div class="print-only">
    <div class="doc-header-row">
        <?= $this->Html->image('jatanegara.png', ['style' => 'height: 60px; filter: none !important;']) ?>
        <div>
            <h1 class="doc-title">JABATAN TENAGA KERJA (JTK)</h1>
            <p class="doc-subtitle">Official Analytical Report | Generated on: <?= date('d M Y, h:i A') ?></p>
        </div>
    </div>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 fw-bold mb-1" style="color: #003366;">Cases Analytics</h1>
        <p class="text-muted">Overview of case resolution and departmental loads.</p>
    </div>
    <button onclick="window.print()" class="print-btn">
        <i class="bi bi-printer-fill me-2"></i> Print Report
    </button>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-lg-6">
        <div class="report-card">
            <h6 class="fw-bold text-uppercase small text-muted mb-4">Case Resolution Status</h6>
            <div class="chart-container">
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="report-card">
            <h6 class="fw-bold text-uppercase small text-muted mb-4">Departmental Breakdown</h6>
            <div class="chart-container">
                <canvas id="deptChart"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="report-card">
    <h6 class="fw-bold text-uppercase small text-muted mb-4">Detailed Statistics</h6>
    <div class="table-responsive">
        <table class="table align-middle">
            <thead class="table-light">
                <tr>
                    <th style="width: 20%;">Category</th>
                    <th style="width: 15%;">Total Cases</th>
                    <th>Load Percentage</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($categories as $name => $count): 
                    $percent = ($total > 0) ? round(($count / $total) * 100) : 0;
                ?>
                <tr>
                    <td class="fw-bold text-secondary"><?= h($name) ?></td>
                    <td class="fw-bold"><?= $count ?> files</td>
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <div class="progress flex-grow-1" style="height: 8px; background-color: #f1f5f9;">
                                <div class="progress-bar" style="width: <?= $percent ?>%; background-color: #003366; -webkit-print-color-adjust: exact;"></div>
                            </div>
                            <span class="fw-bold small" style="width: 40px; text-align: right;"><?= $percent ?>%</span>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="print-only mt-4">
    <div style="border-top: 1px solid #000; padding-top: 10px; font-size: 9pt; display: flex; justify-content: space-between;">
        <div>System Generated Report</div>
        <div>Page 1 of 1</div>
    </div>
</div>

<script>
    // 1. Status Bar Chart
    const ctxStatus = document.getElementById('statusChart').getContext('2d');
    new Chart(ctxStatus, {
        type: 'bar',
        data: {
            labels: ['Submitted', 'In Progress', 'Settled'],
            datasets: [{
                label: 'Cases',
                data: [<?= $submitted ?>, <?= $active ?>, <?= $resolved ?>],
                backgroundColor: ['#ffc107', '#3b82f6', '#10b981'],
                borderColor: ['#cbd5e1', '#2563eb', '#059669'],
                borderWidth: 1,
                borderRadius: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, grid: { borderDash: [2, 2] } },
                x: { grid: { display: false } }
            },
            animation: false // Disable animation for better printing
        }
    });

    // 2. Department Donut Chart
    const ctxDept = document.getElementById('deptChart').getContext('2d');
    new Chart(ctxDept, {
        type: 'doughnut',
        data: {
            labels: ['General', 'Salary', 'Termination', 'Foreign'],
            datasets: [{
                data: [
                    <?= $categories['General'] ?>, 
                    <?= $categories['Salary'] ?>, 
                    <?= $categories['Termination'] ?>, 
                    <?= $categories['Foreign Worker'] ?>
                ],
                backgroundColor: ['#003366', '#f59e0b', '#ef4444', '#10b981'],
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: { position: 'right', labels: { usePointStyle: true, boxWidth: 10 } }
            },
            animation: false // Disable animation for better printing
        }
    });
</script>