<?php

    use app\helpers\Useful;

?>
<div class="site-index">
    <div class="row row-cols-5 gap-2">
        <? foreach($books as $book): ?>
            <a href="/book/<?= $book->alias ?>" class="card col py-3 d-block" style="cursor: pointer;">
                <? if($book->coverImage): ?>
                    <div style="width: 100%; height: 280px; background-image: url('<?= Useful::imgpatch($book->coverImage) ?>'); background-size: cover; object-position: center;"></div>
                <? else: ?>
                    <div style="width: 100%; height: 280px; background-image: url('<?= Yii::getAlias('@web') ?>/images/emptyImage.png'); background-size: cover; object-position: center;"></div>
                <? endif; ?>
                <div class="card-body">
                    <h5 class="card-title fs-6"><?= $book->name ?></h5>
                    <p class="card-text">
                        <ul class="p-0" style="list-style-type: none; font-size: 12px;">
                            <? foreach($book->authors as $author): ?>
                                <li>
                                    <?= $author->surname . ' ' . $author->name . ' ' . $author->patronymic ?>
                                </li>
                            <? endforeach; ?>
                        </ul>
                    </pre>
                </div>
            </a>
        <? endforeach; ?>
    </div>
    
</div>
