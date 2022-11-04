
<?php
/**
 * @var \App\View\AppView $this
 */
?>

<table>
    <thead>

        <tr>
            <?php foreach ($data[0] as $row): ?>
            <?php foreach ($row as $key => $value): ?>
                <th><?= h($key) ?></th>
            <?php endforeach; ?>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($data as $row): ?>
        <tr>
            <?php foreach ($row as $key => $value): ?>
                <td><?= h($value) ?></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
</table>
