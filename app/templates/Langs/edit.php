<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Lang $lang
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $lang->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $lang->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Langs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="langs form content">
            <?= $this->Form->create($lang) ?>
            <fieldset>
                <legend><?= __('Edit Lang') ?></legend>
                <?php
                    echo $this->Form->control('iso2');
                    echo $this->Form->control('name');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
