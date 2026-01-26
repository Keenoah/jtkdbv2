<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Officer $officer
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Officer'), ['action' => 'edit', $officer->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Officer'), ['action' => 'delete', $officer->id], ['confirm' => __('Are you sure you want to delete # {0}?', $officer->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Officers'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Officer'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="officers view content">
            <h3><?= h($officer->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($officer->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Department') ?></th>
                    <td><?= h($officer->department) ?></td>
                </tr>
                <tr>
                    <th><?= __('Email') ?></th>
                    <td><?= h($officer->email) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($officer->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($officer->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($officer->modified) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Complaints') ?></h4>
                <?php if (!empty($officer->complaints)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('User Id') ?></th>
                            <th><?= __('Officer Id') ?></th>
                            <th><?= __('Admin Id') ?></th>
                            <th><?= __('Category') ?></th>
                            <th><?= __('Complaint Text') ?></th>
                            <th><?= __('Status') ?></th>
                            <th><?= __('File Path') ?></th>
                            <th><?= __('Employer Name') ?></th>
                            <th><?= __('Employer Address') ?></th>
                            <th><?= __('Employer Tel') ?></th>
                            <th><?= __('Employer Email') ?></th>
                            <th><?= __('Person In Charge') ?></th>
                            <th><?= __('Comp Name 1') ?></th>
                            <th><?= __('Comp Ic 1') ?></th>
                            <th><?= __('Comp Name 2') ?></th>
                            <th><?= __('Comp Ic 2') ?></th>
                            <th><?= __('Comp Name 3') ?></th>
                            <th><?= __('Comp Ic 3') ?></th>
                            <th><?= __('Created') ?></th>
                            <th><?= __('Modified') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($officer->complaints as $complaint) : ?>
                        <tr>
                            <td><?= h($complaint->id) ?></td>
                            <td><?= h($complaint->user_id) ?></td>
                            <td><?= h($complaint->officer_id) ?></td>
                            <td><?= h($complaint->admin_id) ?></td>
                            <td><?= h($complaint->category) ?></td>
                            <td><?= h($complaint->complaint_text) ?></td>
                            <td><?= h($complaint->status) ?></td>
                            <td><?= h($complaint->file_path) ?></td>
                            <td><?= h($complaint->employer_name) ?></td>
                            <td><?= h($complaint->employer_address) ?></td>
                            <td><?= h($complaint->employer_tel) ?></td>
                            <td><?= h($complaint->employer_email) ?></td>
                            <td><?= h($complaint->person_in_charge) ?></td>
                            <td><?= h($complaint->comp_name_1) ?></td>
                            <td><?= h($complaint->comp_ic_1) ?></td>
                            <td><?= h($complaint->comp_name_2) ?></td>
                            <td><?= h($complaint->comp_ic_2) ?></td>
                            <td><?= h($complaint->comp_name_3) ?></td>
                            <td><?= h($complaint->comp_ic_3) ?></td>
                            <td><?= h($complaint->created) ?></td>
                            <td><?= h($complaint->modified) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Complaints', 'action' => 'view', $complaint->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Complaints', 'action' => 'edit', $complaint->id]) ?>
                                <?= $this->Form->postLink(
                                    __('Delete'),
                                    ['controller' => 'Complaints', 'action' => 'delete', $complaint->id],
                                    [
                                        'method' => 'delete',
                                        'confirm' => __('Are you sure you want to delete # {0}?', $complaint->id),
                                    ]
                                ) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>