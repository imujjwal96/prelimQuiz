<div class="view hm-black-light">
    <div class="full-bg-img flex-center">
        <ul>
            <li>
                <h1 class="h1-responsive wow fadeInUp title"><?= Config::get('QUIZ_NAME') ?></h1>
            </li>
            <li>
                <a href="/register" class="btn btn-default btn-rounded">Add Instructions</a>
                <a href="/login" class="btn btn-default btn-rounded">Add a Question</a>
            </li>
            <li>
                <a href="index/instructions" class="btn btn-default btn-rounded">Edit a Question</a>
                <a href="index/leaderboard" class="btn btn-default btn-rounded">Delete a Question</a>
            </li>

        </ul>
    </div>
</div>