<?php

use App\View\AppView;
/**
 *
 * @var AppView $this
 *
 */
?>

<strong>Es wurden <?= count($messages) ?> neue Clans gefunden.</strong>

<h1>Folgende Clans wurden gefunden</h1>
<ol>
<?php
foreach ($messages as $message){
    echo "<li>".$message."</li>";
}
?>
</ol>
<script>
    window.setTimeout( function() {
        window.location.reload();
    }, 1000);
</script>
