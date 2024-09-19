<?
    use app\helpers\Useful;
?>

<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Книги</h1>
        <a class="btn btn-primary" href="/book-create" role="button">Добавить</a>
    </div>
    

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Обложка</th>
                <th scope="col">ISBN</th>
                <th scope="col">Название</th>
                <th scope="col">Авторы</th>
                <th scope="col" class="col-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-tools" viewBox="0 0 16 16">
                        <path d="M1 0 0 1l2.2 3.081a1 1 0 0 0 .815.419h.07a1 1 0 0 1 .708.293l2.675 2.675-2.617 2.654A3.003 3.003 0 0 0 0 13a3 3 0 1 0 5.878-.851l2.654-2.617.968.968-.305.914a1 1 0 0 0 .242 1.023l3.27 3.27a.997.997 0 0 0 1.414 0l1.586-1.586a.997.997 0 0 0 0-1.414l-3.27-3.27a1 1 0 0 0-1.023-.242L10.5 9.5l-.96-.96 2.68-2.643A3.005 3.005 0 0 0 16 3q0-.405-.102-.777l-2.14 2.141L12 4l-.364-1.757L13.777.102a3 3 0 0 0-3.675 3.68L7.462 6.46 4.793 3.793a1 1 0 0 1-.293-.707v-.071a1 1 0 0 0-.419-.814zm9.646 10.646a.5.5 0 0 1 .708 0l2.914 2.915a.5.5 0 0 1-.707.707l-2.915-2.914a.5.5 0 0 1 0-.708M3 11l.471.242.529.026.287.445.445.287.026.529L5 13l-.242.471-.026.529-.445.287-.287.445-.529.026L3 15l-.471-.242L2 14.732l-.287-.445L1.268 14l-.026-.529L1 13l.242-.471.026-.529.445-.287.287-.445.529-.026z"/>
                    </svg>
                </th>
            </tr>
        </thead>
        <tbody>
            <? $i = 1 ?>
            <? foreach($books as $book): ?>
                <tr>
                    <th scope="row"><?= $i ?></th>
                    <td>
                    <? if($book->coverImage): ?>
                        <div style="width: 60px; height: 80px; background-image: url('<?= Useful::imgpatch($book->coverImage) ?>'); background-size: cover;" class="mx-auto"></div>
                    <? else: ?>
                        <div style="width: 60px; height: 80px; background-image: url('<?= Yii::getAlias('@web') ?>/images/emptyImage.png'); background-size: cover;" class="mx-auto"></div>
                    <? endif; ?>
                    </td>
                    <td><?= $book->isbn ?></td>
                    <td><?= $book->name ?></td>
                    <td>
                        <ul class="p-0 m-0">
                            <? foreach($book->authors as $author): ?>
                                <li><?= $author->surname ?></li>
                            <? endforeach; ?>
                        </ul>
                    </td>
                    <td>
                        <div style="width: 60px;" class="d-flex justify-content-between align-items-center">
                            <a class="icon-link" href="/book-edit/<?= $book->id ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                    <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.5.5 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11z"/>
                                </svg>
                            </a>
                            <a class="icon-link" href="/book-delete/<?= $book->id ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                <? $i++ ?>
            <? endforeach; ?>
        </tbody>
    </table>
</div>