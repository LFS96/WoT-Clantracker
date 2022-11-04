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
            <?= $this->Html->link(__('Edit Lang'), ['action' => 'edit', $lang->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Lang'), ['action' => 'delete', $lang->id], ['confirm' => __('Are you sure you want to delete # {0}?', $lang->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Langs'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Lang'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="langs view content">
            <h3><?= h($lang->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= h($lang->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Iso2') ?></th>
                    <td><?= h($lang->iso2) ?></td>
                </tr>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($lang->name) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Clans') ?></h4>
                <?php if (!empty($lang->clans)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Tag') ?></th>
                            <th><?= __('Name') ?></th>
                            <th><?= __('Description') ?></th>
                            <th><?= __('Lang Id') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($lang->clans as $clans) : ?>
                        <tr>
                            <td><?= h($clans->id) ?></td>
                            <td><?= h($clans->tag) ?></td>
                            <td><?= h($clans->name) ?></td>
                            <td><?= h($clans->description) ?></td>
                            <td><?= h($clans->lang_id) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Clans', 'action' => 'view', $clans->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Clans', 'action' => 'edit', $clans->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Clans', 'action' => 'delete', $clans->id], ['confirm' => __('Are you sure you want to delete # {0}?', $clans->id)]) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
