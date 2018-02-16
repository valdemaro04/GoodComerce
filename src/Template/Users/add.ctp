<?php
/**
 * @var \App\View\AppView $this



 * @var \App\Model\Entity\User $user
 */

?>
<nav class="large-3 medium-4 columns" id="actions-sidebar">
    <ul class="side-nav">
        <li class="heading"><?= __('Actions') ?></li>
        <li><?= $this->Html->link(__('List Users'), ['action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('List Profile'), ['controller' => 'Profile', 'action' => 'index']) ?></li>
        <li><?= $this->Html->link(__('New Profile'), ['controller' => 'Profile', 'action' => 'add']) ?></li>
    </ul>
</nav>
<div class="users form large-9 medium-8 columns content">
    <?= $this->Form->create($user) ?>
    <fieldset>
        <legend><?= __('Add User') ?></legend>
        <?php
            echo $this->Form->control('username');
            echo $this->Form->control('password');
            echo $this->Form->control('profile.name');
            echo $this->Form->control('profile.last_name');
            echo $this->Form->control('profile.country');
            echo $this->Form->control('profile.city');
            echo $this->Form->control('profile.state');
            echo $this->Form->control('profile.email');
            echo $this->Form->control('profile.number_phone');
            echo $this->Form->control('config.url');
            echo $this->Form->control('config.consumer_key');
            echo $this->Form->control('config.consumer_secret');
        ?>
    </fieldset>
    <?= $this->Form->button(__('Submit')) ?>
    <?= $this->Form->end() ?>
</div>
