<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complaint $complaint
 */
?>
<div class="pdf-container">
    <div style="text-align: center; margin-bottom: 30px; border-bottom: 2px solid #003366; padding-bottom: 20px;">
        <h1>JABATAN TENAGA KERJA (JTK)</h1>
        <h3>OFFICIAL COMPLAINT RECORD</h3>
        <p>Reference No: #<?= h($complaint->id) ?> | Date: <?= h($complaint->created->format('d/m/Y')) ?></p>
    </div>

    <h4>1. COMPLAINANT INFORMATION</h4>
    <table class="table">
        <tr>
            <th width="30%">Full Name:</th>
            <td><?= h($complaint->user->name) ?></td>
        </tr>
        <tr>
            <th>IC/Passport:</th>
            <td><?= h($complaint->user->ic_number) ?></td>
        </tr>
        <tr>
            <th>Contact:</th>
            <td><?= h($complaint->user->phone) ?> / <?= h($complaint->user->email) ?></td>
        </tr>
    </table>

    <h4>2. EMPLOYER DETAILS</h4>
    <table class="table">
        <tr>
            <th width="30%">Company Name:</th>
            <td><?= h($complaint->employer_name) ?></td>
        </tr>
        <tr>
            <th>Address:</th>
            <td><?= h($complaint->employer_address) ?></td>
        </tr>
    </table>

    <h4>3. COMPLAINT DESCRIPTION</h4>
    <div style="padding: 15px; border: 1px solid #ccc; background-color: #f9f9f9; line-height: 1.6;">
        <?= $this->Text->autoParagraph(h($complaint->complaint_text)) ?>
    </div>

    <div style="margin-top: 50px;">
        <p><strong>Status:</strong> <?= h($complaint->status) ?></p>
        <p><strong>Assigned Officer:</strong> <?= $complaint->has('officer') ? h($complaint->officer->name) : 'Pending Assignment' ?></p>
    </div>
</div>