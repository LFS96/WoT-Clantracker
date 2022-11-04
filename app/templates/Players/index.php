<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Player> $players
 */
?>
<div class="players index content">
    <?= $this->Html->link(__('New Player'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Players') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('nickname') ?></th>
                    <th><?= $this->Paginator->sort('clan_id') ?></th>
                    <th><?= $this->Paginator->sort('quit') ?></th>
                    <th><?= $this->Paginator->sort('lastBattle') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($players as $player): ?>
                <tr>
                    <td><?= $this->Number->format($player->id) ?></td>
                    <td><?= h($player->nickname) ?></td>
                    <td><?= $player->has('clan') ? $this->Html->link($player->clan->name, ['controller' => 'Clans', 'action' => 'view', $player->clan->id]) : '' ?></td>
                    <td><?= h($player->quit) ?></td>
                    <td><?= h($player->lastBattle) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $player->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $player->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $player->id], ['confirm' => __('Are you sure you want to delete # {0}?', $player->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
