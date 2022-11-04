<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Lang> $langs
 */
?>
<div class="langs index content">
    <?= $this->Html->link(__('New Lang'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Langs') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('iso2') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($langs as $lang): ?>
                <tr>
                    <td><?= h($lang->id) ?></td>
                    <td><?= h($lang->iso2) ?></td>
                    <td><?= h($lang->name) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $lang->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $lang->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $lang->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lang->id)]) ?>
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
