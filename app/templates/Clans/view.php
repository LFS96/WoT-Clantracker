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
            <?= $this->Html->link(__('Edit Clan'), ['action' => 'edit', $clan->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Clan'), ['action' => 'delete', $clan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clan->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Clans'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Clan'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>


    <div class="column-responsive column-80">
        <div class="clans view content">
            <h3><span class="flag-icon" data-flag="<?= $clan?->lang?->iso2; ?>"></span> <?= h($clan->name) ?></h3>


            <table class="table table-sm table-striped">
                <tr>
                    <th><?= __('Tag') ?></th>
                    <td><?= h($clan->tag) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($clan->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Lang Id') ?></th>
                    <td><?= h($clan->lang_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($clan->id) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Description') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($clan->description)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Players') ?></h4>
                <?php if (!empty($clan->players)) : ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Nickname') ?></th>


                            <th><?= __('LastBattle') ?></th>
                        </tr>
                        <?php foreach ($clan->players as $users) : ?>
                        <tr>
                            <td><?= $this->Html->link($users->id, ['controller' => 'Players', 'action' => 'view', $users->id]) ?></td>
                            <td><?= $this->Html->link($users->nickname, "https://wot-life.com/eu/player/$users->nickname/") ?></td>
                            <td><?= h($users->lastBattle->format("d.m.Y H:i:s")) ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
