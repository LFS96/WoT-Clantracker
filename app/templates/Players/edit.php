<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Player $player
 * @var string[]|\Cake\Collection\CollectionInterface $clans
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $player->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $player->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Players'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="players form content">
            <?= $this->Form->create($player) ?>
            <fieldset>
                <legend><?= __('Edit Player') ?></legend>
                <?php
                    echo $this->Form->control('nickname');
                    echo $this->Form->control('clan_id', ['options' => $clans, 'empty' => true]);
                    echo $this->Form->control('quit', ['empty' => true]);
                    echo $this->Form->control('lastBattle', ['empty' => true]);
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
