<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Apikey $apikey
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $apikey->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $apikey->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Apikey'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="apikey form large-9 medium-8 columns content">
    <?= $this->Form->create($apikey) ?>
    <fieldset>
        <legend><?= __('Edit Apikey') ?></legend>
        <?php
            echo $this->Form->control('key_api');
            echo $this->Form->control('status');
            echo $this->Form->control('user_id', ['options' => $users]);
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
