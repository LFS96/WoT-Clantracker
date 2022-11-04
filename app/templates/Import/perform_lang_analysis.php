<?php
/**
 * @var \App\View\AppView $this
 * @var array $good
 * @var array $bad
 */
?>

<h3> Erfolgreich </h3>
<table>
    <tr>
        <th> Tag </th>
        <th> Sprache </th>
        <th> Name </th>
        <th> Beschreibung </th>
    </tr>
    <?php foreach ($good as $tag => $data) : ?>
    <tr>
        <td><?= h($tag) ?></td>
        <td><?= h($data[0]) ?></td>
        <td><?= h($data[1]) ?></td>
        <td><?= h($data[2]) ?></td>
    </tr>
    <?php endforeach; ?>
</table>
<h3> Nicht erfolgreich </h3>

<table>
    <tr>
        <th>Tag</th>
        <th>Name</th>
    </tr>
    <?php foreach ($bad as $tag => $name) : ?>
        <tr>
            <td><?= $tag ?></td>
            <td><?= $name ?></td>
        </tr>
    <?php endforeach; ?>
</table>


