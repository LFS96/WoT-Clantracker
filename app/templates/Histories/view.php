<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\History $history
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit History'), ['action' => 'edit', $history->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete History'), ['action' => 'delete', $history->id], ['confirm' => __('Are you sure you want to delete # {0}?', $history->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Histories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New History'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="histories view content">
            <h3><?= h($history->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Clan') ?></th>
                    <td><?= $history->has('clan') ? $this->Html->link($history->clan->name, ['controller' => 'Clans', 'action' => 'view', $history->clan->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($history->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Player Id') ?></th>
                    <td><?= $this->Number->format($history->player_id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Joined') ?></th>
                    <td><?= h($history->joined) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
