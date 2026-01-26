<!DOCTYPE html>
<html>
<head>
    <title><?= $this->fetch('title') ?></title>
    <style>
        body { font-family: 'Helvetica', sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #003366; padding-bottom: 10px; }
        .table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        .table th, .table td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        .badge { font-weight: bold; color: #003366; }
    </style>
</head>
<body>
    <div class="header">
        <h2>JABATAN TENAGA KERJA (JTK)</h2>
        <p>Official Complaint Record</p>
    </div>
    <?= $this->fetch('content') ?>
</body>
</html>