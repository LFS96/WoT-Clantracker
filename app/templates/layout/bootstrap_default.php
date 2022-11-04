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

    <?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css' ) ?>
    <?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css') ?>
    <?= $this->Html->css('https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css' ) ?>


    <?= $this->Html->css('https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css' ) ?>

    <?= $this->Html->css('default' ) ?>

    <?= $this->Html->script('https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js') ?>
    <?= $this->Html->script('https://code.jquery.com/jquery-3.6.1.min.js') ?>
    <?= $this->Html->script('https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js' ) ?>
    <?= $this->Html->script('https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap4.min.js' ) ?>
    <?= $this->Html->script('https://cdn.jsdelivr.net/npm/chart.js' ) ?>

    <?= $this->fetch('css'); ?>
    <?= $this->fetch('js'); ?>
<body>
<nav class="navbar navbar-dark bg-dark navbar-expand-md">
    <div class="container">
        <?= $this->Html->link("Clan Interface", ['controller' => 'CLans', 'action' => 'add', 'home'], ["class" => "navbar-brand"]) ?>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <?= $this->Html->link("Auszeit nehmen", ['controller' => 'Inactives', 'action' => 'add', 'home'], ["class" => "nav-link"]) ?>
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
    });
</script>
</body>
</html>
