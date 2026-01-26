<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complaint $complaint
 */

// ==========================================
// 1. PREPARE IMAGES (CONVERT TO BASE64)
// ==========================================

// A. LOGO SETUP
$logoPath = WWW_ROOT . 'img' . DS . 'jatanegara.png';
$logoSrc = '';
if (file_exists($logoPath)) {
    $logoData = base64_encode(file_get_contents($logoPath));
    $logoSrc = 'data:image/png;base64,' . $logoData;
}

// B. EVIDENCE SETUP
$evidenceSrc = '';
if (!empty($complaint->file_path)) {
    // Check 'files' folder first (Standard)
    $evidencePath = WWW_ROOT . 'files' . DS . $complaint->file_path;
    
    // Fallback: Check 'uploads' folder if not in 'files'
    if (!file_exists($evidencePath)) {
        $evidencePath = WWW_ROOT . 'uploads' . DS . $complaint->file_path;
    }

    // If file found, convert to Base64
    if (file_exists($evidencePath)) {
        $ext = pathinfo($complaint->file_path, PATHINFO_EXTENSION);
        // Only process images
        if (in_array(strtolower($ext), ['jpg', 'jpeg', 'png'])) {
            $evidenceData = base64_encode(file_get_contents($evidencePath));
            // Determine mime type
            $mime = (strtolower($ext) === 'png') ? 'image/png' : 'image/jpeg';
            $evidenceSrc = "data:$mime;base64," . $evidenceData;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Case Record #<?= h($complaint->id) ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Arimo:wght@400;700&display=swap" rel="stylesheet">
    <style>
        /* 1. PAPER SETUP */
        @page { size: A4; margin: 20mm; }
        body { 
            font-family: 'Arimo', sans-serif; 
            font-size: 11px; 
            color: #000; 
            line-height: 1.4; 
            margin: 0; padding: 20px;
        }

        /* 2. LAYOUT HELPERS */
        .header { border-bottom: 2px solid #000; padding-bottom: 15px; margin-bottom: 20px; display: flex; align-items: center; gap: 15px; }
        /* Use CSS to set logo size */
        .logo-img { width: 60px; height: auto; } 
        .title-block h1 { margin: 0; font-size: 16px; text-transform: uppercase; font-weight: 800; letter-spacing: 0.5px; }
        .title-block p { margin: 2px 0 0; font-size: 10px; color: #555; }
        
        /* 3. SECTIONS */
        .section-box { margin-bottom: 25px; }
        .section-title { 
            background: #f4f4f4; 
            padding: 5px 10px; 
            font-weight: 700; 
            font-size: 10px; 
            text-transform: uppercase; 
            border-left: 4px solid #003366; 
            margin-bottom: 10px;
        }

        /* 4. DATA GRIDS */
        .row { display: flex; margin-bottom: 6px; }
        .label { width: 140px; font-weight: 700; color: #444; }
        .value { flex: 1; font-weight: 400; }
        
        .status-bar { 
            display: flex; justify-content: space-between; 
            background: #fff; border: 1px solid #ddd; padding: 8px 15px; 
            margin-bottom: 25px; font-weight: 700;
        }

        /* 5. TABLES */
        table { width: 100%; border-collapse: collapse; margin-top: 5px; font-size: 10px; }
        th { text-align: left; background: #eee; padding: 6px; border: 1px solid #ccc; }
        td { padding: 6px; border: 1px solid #ccc; }

        /* 6. EVIDENCE PAGE */
        .page-break { page-break-before: always; }
        .evidence-img { max-width: 100%; border: 1px solid #ddd; padding: 5px; }

        /* PRINT SETTINGS */
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="no-print" style="position:fixed; top:20px; right:20px; background:gold; padding:10px; cursor:pointer;" onclick="window.print()">
        Click to Print / Save PDF
    </div>

    <div class="header">
        <?php if($logoSrc): ?>
            <img src="<?= $logoSrc ?>" class="logo-img">
        <?php else: ?>
            <div style="width:60px; height:60px; background:#ccc; display:flex; align-items:center; justify-content:center;">Logo</div>
        <?php endif; ?>

        <div class="title-block">
            <h1>Jabatan Tenaga Kerja (JTK)</h1>
            <p>Official Complaint Management System | Case Record</p>
        </div>
    </div>

    <div class="status-bar">
        <span>CASE ID: #<?= h($complaint->id) ?></span>
        <span>Category: <?= h($complaint->category) ?> | Status: <?= h($complaint->status) ?></span>
    </div>

    <div class="section-box">
        <div class="section-title">MAIN COMPLAINANT PROFILE</div>
        <div class="row"><span class="label">Full Name:</span> <span class="value"><?= h(strtoupper($complaint->user->name)) ?></span></div>
        <div class="row"><span class="label">IC Number:</span> <span class="value"><?= h($complaint->user->ic_number) ?></span></div>
        
        <div style="display: flex; justify-content: space-between;">
            <div style="flex:1;">
                <div class="row"><span class="label">Phone:</span> <span class="value"><?= h($complaint->user->phone) ?></span></div>
                <div class="row"><span class="label">Nationality:</span> <span class="value"><?= h($complaint->user->nationality ?? 'Malaysia') ?></span></div>
            </div>
            <div style="flex:1;">
                 <div class="row">
                    <span class="label">Age / Gender:</span> 
                    <span class="value">
                        <?= !empty($complaint->user->age) ? h($complaint->user->age) . ' Years' : '-' ?> / 
                        <?= !empty($complaint->user->gender) ? h($complaint->user->gender) : '-' ?>
                    </span>
                </div>
            </div>
        </div>
        
        <div class="row"><span class="label">Address:</span> <span class="value"><?= h($complaint->user->address) ?></span></div>
    </div>

    <?php if (!empty($complaint->comp_name_1)): ?>
    <div class="section-box">
        <div class="section-title">ADDITIONAL REPRESENTED PERSONS</div>
        <table>
            <thead>
                <tr>
                    <th style="width: 30px;">#</th>
                    <th>Full Name</th>
                    <th style="width: 150px;">IC / Passport No.</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td><?= h($complaint->comp_name_1) ?></td>
                    <td><?= h($complaint->comp_ic_1) ?></td>
                </tr>
                <?php if (!empty($complaint->comp_name_2)): ?>
                <tr>
                    <td>2</td>
                    <td><?= h($complaint->comp_name_2) ?></td>
                    <td><?= h($complaint->comp_ic_2) ?></td>
                </tr>
                <?php endif; ?>
                <?php if (!empty($complaint->comp_name_3)): ?>
                <tr>
                    <td>3</td>
                    <td><?= h($complaint->comp_name_3) ?></td>
                    <td><?= h($complaint->comp_ic_3) ?></td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>

    <div class="section-box">
        <div class="section-title">EMPLOYER INFORMATION</div>
        <div style="display: flex;">
            <div style="flex:1;">
                <div class="row"><span class="label">Company Name:</span> <span class="value"><?= h($complaint->employer_name) ?></span></div>
                <div class="row"><span class="label">Employer Tel:</span> <span class="value"><?= h($complaint->employer_tel) ?></span></div>
            </div>
            <div style="flex:1;">
                <div class="row"><span class="label">Person In Charge:</span> <span class="value"><?= h($complaint->person_in_charge) ?></span></div>
                <div class="row"><span class="label">Employer Email:</span> <span class="value"><?= h($complaint->employer_email) ?></span></div>
            </div>
        </div>
        <div class="row" style="margin-top: 5px;"><span class="label">Address:</span> <span class="value"><?= h($complaint->employer_address) ?></span></div>
    </div>

    <div class="section-box">
        <div class="section-title">DETAILED CASE DESCRIPTION</div>
        <div style="border: 1px solid #ddd; padding: 10px; background: #fafafa; min-height: 60px;">
            <?= $this->Text->autoParagraph(h($complaint->complaint_text)); ?>
        </div>
    </div>

    <div class="section-box" style="margin-top: 30px; border-top: 1px solid #ccc; padding-top: 10px;">
        <div class="section-title">INTERNAL ASSIGNMENT & ACTION</div>
        <div style="display: flex;">
             <div style="flex:1;">
                
                <div class="row">
                    <span class="label">Officer Assigned:</span> 
                    <span class="value">
                        <?= !empty($complaint->officer) ? h(strtoupper($complaint->officer->name)) : 'Pending' ?>
                    </span>
                </div>

                <?php if (!empty($complaint->officer) && !empty($complaint->officer->email)): ?>
                <div class="row">
                    <span class="label">Officer Email:</span> 
                    <span class="value"><?= h($complaint->officer->email) ?></span>
                </div>
                <?php endif; ?>

                <div class="row">
                    <span class="label">Submitted On:</span> 
                    <span class="value"><?= h($complaint->created->format('d M Y, H:i')) ?></span>
                </div>

            </div>
            <div style="flex:1;">
                 <div class="row">
                    <span class="label">Processed By:</span> 
                    <span class="value">
                        <?= !empty($complaint->admin) ? h(strtoupper($complaint->admin->username)) : 'System / Pending' ?>
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div style="position: fixed; bottom: 10px; left: 20px; font-size: 8px; color: #999;">
        Computer-generated document. Case ID: #<?= h($complaint->id) ?> | Page 1/2
    </div>

    <?php if ($evidenceSrc): ?>
        <div class="page-break"></div> 
        
        <div class="header">
            <?php if($logoSrc): ?>
                <img src="<?= $logoSrc ?>" class="logo-img">
            <?php else: ?>
                 <div style="width:60px; height:60px; background:#ccc;">Logo</div>
            <?php endif; ?>
            <div class="title-block">
                <h1>Jabatan Tenaga Kerja (JTK)</h1>
                <p>Official Complaint Management System | Case Record</p>
            </div>
        </div>

        <div class="section-title">ATTACHED EVIDENCE</div>
        
        <div style="text-align: center; margin-top: 20px;">
            <img src="<?= $evidenceSrc ?>" class="evidence-img">
        </div>

        <div style="position: fixed; bottom: 10px; left: 20px; font-size: 8px; color: #999;">
            Computer-generated document. Case ID: #<?= h($complaint->id) ?> | Page 2/2
        </div>
    <?php endif; ?>

</body>
</html>