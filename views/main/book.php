<?php

    use app\helpers\Useful;
?>

<div class="w-100 h-100 d-flex justify-content-center">
    <div class="d-flex flex-column">
        <div class="row">
            <div class="col">
                <? if($book->coverImage): ?>
                    <div style="width: 400px; height: 600px; background-image: url('<?= Useful::imgpatch($book->coverImage) ?>'); background-size: cover; object-position: center;"></div>
                <? else: ?>
                    <div style="width: 500px; height: 800px; background-image: url('<?= Yii::getAlias('@web') ?>/images/emptyImage.png'); background-size: cover; object-position: center;"></div>
                <? endif; ?>
            </div>
            <div class="col">
                <h1 class="fs-4"><?= $book->name ?></h1>
                <ul class="p-0 mb-4" style="list-style-type: none; font-size: 16px;">
                    <? foreach($book->authors as $author): ?>
                        <li>
                            <?= $author->surname . ' ' . $author->name . ' ' . $author->patronymic ?>
                        </li>
                    <? endforeach; ?>
                </ul>
                <div class="book-description">
                    <pre>
                        <?= $book->description ?>
                    </pre>
                </div>
                <div class="fw-semibold mb-2">
                    ISBN <?= $book->isbn ?>
                </div>
                <div style="margin-bottom: 60px;">
                    Год издания: <?= Useful::parseDate($book->createdAt); ?>
                </div>

                <a class="btn btn-primary" href="/subscribe/<?= $book->id ?>" role="button">Подписаться на авторов</a>
            </div>
        </div>

        
    </div>
</div>