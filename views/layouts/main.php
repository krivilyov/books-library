<?php

/** @var yii\web\View $this */
/** @var string $content */

use app\assets\AppAsset;
use app\widgets\Alert;
use yii\bootstrap5\Breadcrumbs;
use yii\bootstrap5\Html;

AppAsset::register($this);

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => $this->params['meta_description'] ?? '']);
$this->registerMetaTag(['name' => 'keywords', 'content' => $this->params['meta_keywords'] ?? '']);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::getAlias('@web/favicon.ico')]);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">
<head>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="<?= Yii::getAlias('@web') ?>css/main.css">
</head>
<body class="d-flex flex-column h-100">
<?php $this->beginBody() ?>

<header id="header">
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container container-fluid d-flex justify-content-between">
    <a class="navbar-brand" href="/"><?= Yii::$app->name ?></a>
    
    <div class="d-flex gap-3 align-items-center">
      <a class="btn btn-primary" href="/rating" role="button">ТОП авторов</a>

      <? if(Yii::$app->user->isGuest): ?>
        <? if(Yii::$app->controller->action->id === 'login'): ?>
          <a class="btn btn-primary" href="/auth/registration" role="button">Регистрация</a>
        <? else: ?>
          <a class="btn btn-primary" href="/auth/login" role="button">Вход</a>
        <? endif ?>
      <? else: ?>
        <div class="dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              <?= Yii::$app->user->identity->email ?>
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/authors">Авторы</a></li>
              <li><a class="dropdown-item" href="/books">Книги</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="<?= Yii::$app->getUrlManager()->createUrl('/auth/logout') ?>">Выйти</a></li>
            </ul>
        </div>
      <? endif ?>
    </div>
  </div>
</nav>
</header>

<main id="main" class="h-100" role="main">
    <div class="container py-5 w-100 h-100">
        <?php if (!empty($this->params['breadcrumbs'])): ?>
            <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
        <?php endif ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</main>

<footer id="footer" class="mt-auto py-3 bg-light">
    <div class="container">
        <div class="row text-muted">
            <div class="col-md-6 text-center text-md-start">&copy; Ivan Krivilyov <?= date('Y') ?></div>
            <div class="col-md-6 text-center text-md-end"><?= Yii::powered() ?></div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
