<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Clan $clan
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Clans'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="clans form content">
            <?= $this->Form->create($clan) ?>
            <fieldset>
                <legend><?= __('Add Clan') ?></legend>
                <?php
                    echo $this->Form->control('tag');
                    echo $this->Form->control('name');
                    echo $this->Form->control('description');
                    echo $this->Form->control('lang_id');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
