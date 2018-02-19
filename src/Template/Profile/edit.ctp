<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Profile $profile
 */
?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $profile->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $profile->id)]
            )
        ?></li>
        <li><?= $this->Html->link(__('List Profile'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Users'), ['controller' => 'Users', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New User'), ['controller' => 'Users', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="profile form large-9 medium-8 columns content">
    <?= $this->Form->create($profile) ?>
    <fieldset>
        <legend><?= __('Edit Profile') ?></legend>
        <?php
            echo $this->Form->control('name');
            echo $this->Form->control('last_name');
            echo $this->Form->control('country');
            echo $this->Form->control('city');
            echo $this->Form->control('state');
            echo $this->Form->control('email');
            echo $this->Form->control('photo');
            echo $this->Form->control('number_phone');
            debug($apikey->status);
            echo $this->Form->select('apikey.status');
            echo $this->Form->control('user_id', ['options' => $users]);
           
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
