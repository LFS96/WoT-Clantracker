<?php
/**
 * @var \App\View\AppView $this
 */
?>

<h1>Clan tracker - Find player that left a Clan</h1>

<div class="mt-3 jumbotron jumbotron-fluid bg-dark text-light ">
    <div class="h-100 p-5 text-bg-dark rounded-3">
        <h2>Player list</h2>
        <p>All players that had a battle in the last 30 days and no clans</p>
        <?= $this->Html->link("Show all players", ['action' => 'playersWithoutClans'], ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<div class="mt-3 jumbotron jumbotron-fluid bg-dark text-light ">
    <div class="h-100 p-5 text-bg-dark rounded-3">
        <h2>Import</h2>
        if the cron container is not running, a imports starts automatically at 00:00 every day.<br/>
        You can start the import manually here:<br/>
        <button id="FastImport" class="btn btn-primary">Start fast import</button>
        <button id="FullImport" class="btn btn-primary">Start full import</button>
        <div id="importStatus" class="mt-3"></div>
    </div>
</div>
<div class="mt-3 jumbotron jumbotron-fluid bg-dark text-light ">
    <div class="h-100 p-5 text-bg-dark rounded-3">
        <h2>Lang analysis</h2>
        <p>run an full language analysis </p>
        <?= $this->Html->link("Lang analysis FULL", ['controller' => 'import', 'action' => 'performLangAnalysis', 1 ], ['class' => 'btn btn-primary']) ?>
        <?= $this->Html->link("Lang analysis FAST", ['controller' => 'import', 'action' => 'performLangAnalysis', 0 ], ['class' => 'btn btn-primary']) ?>
    </div>
</div>

<script>
    $(document).ready(function () {
        $("#FastImport").click(function () {
            let url = "<?= $this->Url->build(["controller" => "import", "action" => "url",0]) ?>";
            startImport(url);
        });
        $("#FullImport").click(function () {
            let url = "<?= $this->Url->build(["controller" => "import", "action" => "url",1]) ?>";
            startImport(url);
        });
        function startImport(url) {
            var d = new Date();
            var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() +" " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
            var importStatus = $("#importStatus");
            $(importStatus).html("");
            $(importStatus).append("Import started: " + strDate + "<br/>");

            $.getJSON( url, async function (data) {
                console.log(data);
                $(data).each(function (index, value) {
                    $(importStatus).append(value + "<br/>");

                    $.ajax({
                        url: value,
                        type: 'GET',
                        async: false,
                    });

                });
            }).done(function() {
                var d = new Date();
                var strDate = d.getFullYear() + "-" + (d.getMonth()+1) + "-" + d.getDate() +" " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();

                $(importStatus).append("Import done: " + strDate + "<br/>");
            }).fail(function() {
                $(importStatus).append("Import failed");
            });

        }
        async function urlFetch(url) {
            const response = await fetch(url);
            const data = await response.text();
            console.log(data);
        }
    });



</script>
