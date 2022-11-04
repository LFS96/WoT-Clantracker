<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Clan> $clans
 */
?>
<div class="clans index content">
    <?= $this->Html->link(__('New Clan'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Clans') ?></h3>
    <div class="table">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('tag') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('lang_id') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($clans as $clan): ?>
                <tr>
                    <td><?= $this->Number->format($clan->id) ?></td>
                    <td><?= h($clan->tag) ?></td>
                    <td><?= h($clan->name) ?></td>
                    <td><?= h($clan->lang_id) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $clan->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $clan->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $clan->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clan->id)]) ?>
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
