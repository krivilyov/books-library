<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>ТОП 10 авторов</h1>
    </div>
    

    <table class="table">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Автор</th>
                <th scope="col">Количество книг</th>
            </tr>
        </thead>
        <tbody>
            <? $i=1; ?>
            <? foreach($authors as $author): ?>
                <tr>
                    <th scope="row"><?= $i ?></th>
                    <td><?= $author['author']->surname . ' ' . $author['author']->name . ' ' . $author['author']->patronymic ?></td>
                    <td><?= $author['books'] ?></td>
                </tr>
                <? $i++; ?>
            <? endforeach; ?>
        </tbody>
    </table>
</div>