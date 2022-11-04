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
            <h3><?= h($clan->name) ?></h3>

            <h4>Erkannte sprache:</h4>
            <pre>
                <?php print_r($lang) ?>
            </pre>
            <table>
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
                <h4><?= __('Related Users') ?></h4>
                <?php if (!empty($clan->users)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Nickname') ?></th>
                            <th><?= __('Clan Id') ?></th>
                            <th><?= __('Quit') ?></th>
                            <th><?= __('LastBattle') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($clan->users as $users) : ?>
                        <tr>
                            <td><?= h($users->id) ?></td>
                            <td><?= h($users->nickname) ?></td>
                            <td><?= h($users->clan_id) ?></td>
                            <td><?= h($users->quit) ?></td>
                            <td><?= h($users->lastBattle) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Users', 'action' => 'view', $users->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Users', 'action' => 'edit', $users->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Users', 'action' => 'delete', $users->id], ['confirm' => __('Are you sure you want to delete # {0}?', $users->id)]) ?>
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
