<?php
/**
 * Created by PhpStorm.
 * User: fHarmsen
 * Date: 20.02.2019
 * Time: 09:36
 *
 * @var AppView $this
 * @var RightsHelper|null $rights
 * @var User|null $auth
 */


use App\Logic\Helper\RightsHelper;
use App\Model\Entity\User;
use App\View\AppView;
use Cake\Core\Configure;

$lang = Configure::read('App.language');

/**
 * Default `flash` block.
 */
if (!$this->fetch('tb_flash')) {
    $this->start('tb_flash');
    if (isset($this->Flash))
        echo $this->Flash->render();
    $this->end();
}
if (!$this->fetch('tb_breadcrumb')) {
    $this->start('tb_breadcrumb');
    if (isset($this->Breadcrumbs)) {
        echo "<div class='mps-bread'>";
        echo $this->Breadcrumbs->render();
        echo "</div>";
    }
    $this->end();
}


/**
 * Prepend `meta` block with `author` and `favicon`.
 */
$this->prepend('meta', $this->Html->meta('author', null, ['name' => 'author', 'content' => Configure::read('App.author')]));
$this->prepend('meta', $this->Html->meta('favicon.ico', '/favicon.ico', ['type' => 'icon']));
$this->prepend('meta', $this->Html->meta(array('name' => 'robots', 'content' => 'noindex, nofollow'), null, array('inline' => false)));

$isOnlyPlayer = false;
$user = $this->request->getAttribute('identity');

$container_class = "container";
if (isset($container)) {
    $container_class = $container;
}

?>
<!DOCTYPE html>
<head lang="<?= $lang ?>" class="no-js">
    <?= $this->Html->charset() ?>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1">
    <title><?= $this->fetch('title') ?></title>
    <?= $this->fetch('meta') ?>

    <?= $this->Html->css('all.min.css' ) ?><!-- Font Awesome 6.2.0 -->
    <?= $this->Html->css('bootstrap.min.css') ?><!-- Bootstrap 5.2.2 -->
    <?= $this->Html->css('dataTables.bootstrap4.min.css' ) ?>
    <?= $this->Html->css('bootstrap-icons.css' ) ?>
    <?= $this->Html->css('default' ) ?>

    <?= $this->Html->script('bootstrap.bundle.min.js') ?>
    <?= $this->Html->script('jquery-3.6.1.min.js') ?>
    <?= $this->Html->script('jquery.dataTables.min.js' ) ?>
    <?= $this->Html->script('dataTables.bootstrap4.min.js' ) ?>
    <?= $this->Html->script('chart.js' ) ?>



    <!-- DataTables Excel Export -->
    <?= $this->Html->script('dataTables.buttons.min.js' ) ?>
    <?= $this->Html->script('jszip.min.js' ) ?>
    <?= $this->Html->script('pdfmake.min.js' ) ?>
    <?= $this->Html->script('vfs_fonts.js' ) ?>
    <?= $this->Html->script('buttons.html5.min.js' ) ?>
    <?= $this->Html->script('buttons.print.min.js' ) ?>




    <?= $this->fetch('css'); ?>
    <?= $this->fetch('js'); ?>
<body>
<nav class="navbar navbar-dark bg-dark navbar-expand-md">
    <div class="container">
        <?= $this->Html->link("Clan Tracker", "/", ["class" => "navbar-brand"]) ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                        <?//= $this->Html->link("Auszeit nehmen", ['controller' => 'Inactives', 'action' => 'add', 'home'], ["class" => "nav-link"]) ?>
                </li>
            </ul>
        </div>

    </div>
</nav>
<div class="<?= $container_class ?>">
    <br/>
    <?= $this->fetch('tb_breadcrumb'); ?>

    <?= $this->fetch('tb_flash'); ?>

    <?= $this->fetch('content'); ?>
    <br/>
    <?= $this->fetch('tb_footer'); ?>
</div>
<?php

$copyright = '    <span class="copyright-lfs96">by LFS96 ' .
    $this->Html->link('<i class="bi bi-github"></i>', 'https://github.com/LFS96/WoT_1FP_Claninterface', ["escape" => false, "target" => "_blank"]) . ' ' .
    $this->Html->link('<i class="bi bi-telegram"></i>', 'https://t.me/FabiGothic', ["escape" => false, "target" => "_blank"]) . ' ' .
    $this->Html->link('<i class="bi bi-instagram"></i>', 'https://instagram.com/fabigothic/', ["escape" => false, "target" => "_blank"]) . '<br/>
    <a rel="license" href="https://www.gnu.org/licenses/gpl-3.0.en.html" target="_blank"><img
            alt="GNU GENERAL PUBLIC LICENSE" style="border-width:0"
            src="https://upload.wikimedia.org/wikipedia/commons/9/93/GPLv3_Logo.svg"
            title="Dieses Werk ist lizenziert unter einer GNU GENERAL PUBLIC LICENSE"/></a>
    </span>';

if (Configure::read('footer.enable') === true): ?>
    <br/><br/><br/><br/>
    <div class="container-fluid">
        <footer class="text-center text-lg-start bg-dark text-light fixed-bottom">
            <div class="row">
                <div class="col-12">
                    <?= Configure::read('footer.text') ?> <br/>
                    <?= $this->Html->link(Configure::read('footer.link.text'), Configure::read('footer.link.url'), ["target" => Configure::read('footer.link.target')]) ?>
                </div>
            </div>
            <?= $copyright; ?>
        </footer>
    </div>
<?php endif; ?>
<?php if (Configure::read('footer.enable') !== true): ?>
    <?= $copyright; ?>
<?php endif; ?>
<?= $this->fetch('scriptBottom'); ?>
<script>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        var table = null;
        $("#buildDatatable").click(function (){
            $(this).hide();
            table = $('table').DataTable( {
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                "order": [[ 2, "desc" ]],
                "pageLength": 5000,
            } );
        });

        $("#destroyDatatable").click(function (){
            table.destroy();
        });



        $(".flag-icon").each(function () {
            try {
                if (getOS() !== "Windows" || getBrowser() === "firefox") {
                    $(this).text(emoji($(this).data("flag")));
                } else {
                    $(this).html("<img src='/img/flags/4x3/" + $(this).data("flag").toLowerCase() + ".svg'>");

                }
            }catch (e) {
                console.log(e);
            }
        });

        $(".tomatoGG").each(function (){
            try{
                let playerId = $(this).data("player");
                let url = "https://tomatobackend.herokuapp.com/api/player/eu/" + playerId +"?cache=true" ;
                $.getJSON(url, function (data) {
                    if(data != null) {
                        printTomatoGG(data)
                    }else{
                        let url = "https://tomatobackend.herokuapp.com/api/player/eu/" + playerId ;
                        $.getJSON(url, function (data) {
                            if (data != null) {
                                printTomatoGG(data)
                            } else {

                            }
                        });
                    }
                });
            }catch (e) {
                $(this).html("N/A");
            }

        });



        function printTomatoGG(data){
            let wn8 = data.overallStats.overallWN8;
            let battles = data.overallStats.battles;
            let battles30d = data.recents.recent30days.battles;
            let element = ".tomatoGG[data-player='" + data.summary.account_id;
            $(element).html(wn8 + " / " + battles30d + " / " + battles);
        }

        function getBrowser() {
            let userAgent = navigator.userAgent;
            let browserName;

            if (userAgent.match(/chrome|chromium|crios/i)) {
                browserName = "chrome";
            } else if (userAgent.match(/firefox|fxios/i)) {
                browserName = "firefox";
            } else if (userAgent.match(/safari/i)) {
                browserName = "safari";
            } else if (userAgent.match(/opr\//i)) {
                browserName = "opera";
            } else if (userAgent.match(/edg/i)) {
                browserName = "edge";
            } else {
                browserName = "No browser detection";
            }
            return browserName;
        }

        function getOS() {
            var userAgent = window.navigator.userAgent,
                platform = window.navigator?.userAgentData?.platform ?? window.navigator.platform,
                macosPlatforms = ['Macintosh', 'MacIntel', 'MacPPC', 'Mac68K'],
                windowsPlatforms = ['Win32', 'Win64', 'Windows', 'WinCE'],
                iosPlatforms = ['iPhone', 'iPad', 'iPod'],
                os = null;

            if (macosPlatforms.indexOf(platform) !== -1) {
                os = 'Mac OS';
            } else if (iosPlatforms.indexOf(platform) !== -1) {
                os = 'iOS';
            } else if (windowsPlatforms.indexOf(platform) !== -1) {
                os = 'Windows';
            } else if (/Android/.test(userAgent)) {
                os = 'Android';
            } else if (!os && /Linux/.test(platform)) {
                os = 'Linux';
            }

            return os;
        }

        function emoji(country) {

            const offset = 127397;
            const A = 65;
            const Z = 90;

            const f = country.codePointAt(0);
            const s = country.codePointAt(1);

            if (country.length !== 2 ||  f > Z || f < A || s > Z || s < A)
            throw new Error('Not an alpha2 country code');

            return String.fromCodePoint(f + offset)
                + String.fromCodePoint(s + offset);
        }



    });
</script>
</body>
</html>
