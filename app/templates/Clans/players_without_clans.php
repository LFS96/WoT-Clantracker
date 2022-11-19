<?php
/**
 * @var \App\View\AppView $this
 * @var array{array{Spieler_ID: int, Nickname: string,  Austritt: string,  LetztesGefecht: string, LetzerClan: string,Sprachen: string}} $query
 */
?>

<?php $this->assign('title', __('Spieler ohne Clan')); ?>

<table class="table table-sm ">
    <thead>
    <tr>
        <th><?= __('Spieler_ID') ?></th>
        <th><?= __('Nickname') ?></th>
        <th><?= __('Austritt') ?></th>
        <th><?= __('LetztesGefecht') ?></th>
        <th><?= __('LetzerClan') ?></th>
        <th><?= __("TOMATO_GG")?></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($query as $row): ?>
        <tr>
            <td><?= $this->Html->link($row['Spieler_ID'], ['controller' => 'Players', 'action' => 'view', $row['Spieler_ID']]) ?></td>
            <td><?= $this->Html->link($row['Nickname'], "https://wot-life.com/eu/player/{$row["Nickname"]}/") ?></td>
            <td><?= h($row['Austritt']) ?></td>
            <td><?= h($row['LetztesGefecht']) ?></td>
            <td><?= $this->Html->link($row['LetzerClan'], ['controller' => 'Clans', 'action' => 'view', $row['LetzerClan']]) ?></td>
            <td><span class="tomatoGG" data-player="<?= $row['Spieler_ID'] ?>"></span> </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<br />
<br />
<center>We thank <?= $this->Html->link("TomatoGG","https://www.tomato.gg/") ?> for the allowance to use their API for WN8 an 30 days Battle Activity.</center>

<script>
    $(document).ready(function() {
        $('table').DataTable( {
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ],
            "order": [[ 2, "desc" ]],
            "pageLength": 5000,
        } );
    } );
</script>
