<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Complaint $complaint
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $officers
 * @var string[]|\Cake\Collection\CollectionInterface $admins
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $complaint->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $complaint->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Complaints'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column column-80">
        <div class="complaints form content">
            <?= $this->Form->create($complaint) ?>
            <fieldset>
                <legend><?= __('Edit Complaint') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users]);
                    echo $this->Form->control('officer_id', ['options' => $officers, 'empty' => true]);
                    echo $this->Form->control('admin_id', ['options' => $admins, 'empty' => true]);
                    echo $this->Form->control('category');
                    echo $this->Form->control('complaint_text');
                    echo $this->Form->control('status');
                    echo $this->Form->control('file_path');
                    echo $this->Form->control('employer_name');
                    echo $this->Form->control('employer_address');
                    echo $this->Form->control('employer_tel');
                    echo $this->Form->control('employer_email');
                    echo $this->Form->control('person_in_charge');
                    echo $this->Form->control('comp_name_1');
                    echo $this->Form->control('comp_ic_1');
                    echo $this->Form->control('comp_name_2');
                    echo $this->Form->control('comp_ic_2');
                    echo $this->Form->control('comp_name_3');
                    echo $this->Form->control('comp_ic_3');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
