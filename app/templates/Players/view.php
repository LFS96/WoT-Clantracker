<?php
/**
 * @var AppView $this
 * @var Player $player
 */

use App\Model\Entity\Player;
use App\View\AppView;

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
            <table class="table table-sm table-striped">
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
                    <td><?= h($player->quit?->format("d.m.Y H:i:s")) ?></td>
                </tr>
                <tr>
                    <th><?= __('LastBattle') ?></th>
                    <td><?= h($player->lastBattle->format("d.m.Y H:i:s")) ?></td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Related Histories') ?></h4>
                <?php if (!empty($player->histories)) : ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <tr>
                            <th><?= __('Clan') ?></th>
                            <th><?= __('Joined') ?></th>
                            <th><?= __("lang") ?></th>

                        </tr>
                        <?php foreach ($player->histories as $histories) : ?>
                        <tr>

                            <td><?= $this->Html->link("[".$histories->clan->tag."]",['controller' => 'Clans', 'action' => 'view', $histories->clan->id])." ".h($histories->clan->name)?></td>
                            <td><?= h($histories->joined->format("d.m.Y H:i:s")) ?></td>

                            <td> <span class="flag-icon" data-flag="<?= $histories?->clan?->lang?->iso2; ?>"></span> </td>

                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
