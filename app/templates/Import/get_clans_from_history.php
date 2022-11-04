<?php
/**
 * @var \App\View\AppView $this
 *
 *
 */
?>
<h1>Folgende Clans wurden gefunden</h1>
<ol>
<?php
foreach ($messages as $message){
    echo "<li>".$message."</li>";
}
?>
