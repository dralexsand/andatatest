<?php

require_once 'parts/head.php';
?>
<?php
if (isset($article)) { ?>
    <?= $article ?>
    <?php
} ?>

    <hr>

    <form>

        <input id="sort_by_name_value" type="hidden" value="ASC"/>
        <input id="sort_by_date_value" type="hidden" value="DESC"/>

        <div class="mb-3">
            <label for="user_name" class="form-label">Имя пользователя</label>
            <input
                    type="text"
                    class="form-control"
                    name="user_name"
                    id="user_name"
                    value="bred"
                    required
            >
        </div>

        <div class="mb-3">
            <label for="user_email" class="form-label">E-mail</label>
            <input
                    type="email"
                    class="form-control"
                    name="user_email"
                    id="user_email"
                    value="bred@mail.com"
                    required
            >
        </div>

        <div class="mb-3">
            <label for="comment_text">Комментарий</label>
            <textarea
                    class="form-control"
                    id="user_comment"
                    name="user_comment"
                    style="height: 100px"
                    required
            >
                Комментарий value
            </textarea>
        </div>

        <br>

        <button
                id="btnAddComment"
                type="button"
                class="btn btn-primary">
            Добавить комментарий
        </button>
    </form>

    <hr>

    <div class="container-fluid">

        <button
                id="sortByName"
                type="button"
                class="btn btn-primary">
            Сортировать по имени
        </button>

        <button
                id="sortByDate"
                type="button"
                class="btn btn-primary">
            Сортировать по дате
        </button>

        <div id="comments_area" class="comments_area">

            <?php

            if (isset($comments)) {
                foreach ($comments as $comment) {
                    ?>

                    <div class="card" style="width: 36rem;">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?= $comment['username'] ?>
                            </h5>
                            <h6 class="card-subtitle mb-2 text-muted font-italic comment_italic">
                                <?= $comment['email'] ?>
                            </h6>
                            <p class="card-text bg-comment m-1 p-1">
                                <?= $comment['comment'] ?>
                            </p>
                            <p class="comment_italic small font-italic">
                                <?= $comment['created_at'] ?>
                            </p>
                        </div>
                    </div>

                    <?php
                };
            }
            ?>

        </div>

    </div>

    <hr>

<?php
require_once 'parts/foot.php';
?>