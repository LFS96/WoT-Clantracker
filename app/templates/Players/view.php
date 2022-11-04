<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Player $player
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Player'), ['action' => 'edit', $player->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Player'), ['action' => 'delete', $player->id], ['confirm' => __('Are you sure you want to delete # {0}?', $player->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Players'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Player'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="players view content">
            <h3><?= h($player->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Nickname') ?></th>
                    <td><?= h($player->nickname) ?></td>
                </tr>
                <tr>
                    <th><?= __('Clan') ?></th>
                    <td><?= $player->has('clan') ? $this->Html->link($player->clan->name, ['controller' => 'Clans', 'action' => 'view', $player->clan->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($player->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quit') ?></th>
                    <td><?= h($player->quit) ?></td>
                </tr>
                <tr>
                    <th><?= __('LastBattle') ?></th>
                    <td><?= h($player->lastBattle) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Histories') ?></h4>
                <?php if (!empty($player->histories)) : ?>
                <div class="table-responsive">
                    <table>
                        <tr>
                            <th><?= __('Id') ?></th>
                            <th><?= __('Player Id') ?></th>
                            <th><?= __('Clan Id') ?></th>
                            <th><?= __('Joined') ?></th>
                            <th class="actions"><?= __('Actions') ?></th>
                        </tr>
                        <?php foreach ($player->histories as $histories) : ?>
                        <tr>
                            <td><?= h($histories->id) ?></td>
                            <td><?= h($histories->player_id) ?></td>
                            <td><?= h($histories->clan_id) ?></td>
                            <td><?= h($histories->joined) ?></td>
                            <td class="actions">
                                <?= $this->Html->link(__('View'), ['controller' => 'Histories', 'action' => 'view', $histories->id]) ?>
                                <?= $this->Html->link(__('Edit'), ['controller' => 'Histories', 'action' => 'edit', $histories->id]) ?>
                                <?= $this->Form->postLink(__('Delete'), ['controller' => 'Histories', 'action' => 'delete', $histories->id], ['confirm' => __('Are you sure you want to delete # {0}?', $histories->id)]) ?>
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
