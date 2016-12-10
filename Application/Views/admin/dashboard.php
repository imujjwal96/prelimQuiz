<div class="view hm-black-light">
    <div class="full-bg-img flex-center">
        <ul>
            <li>
                <h1 class="h1-responsive wow fadeInUp title"><?= \Application\Core\Config::get('QUIZ_NAME') ?></h1>
            </li>
            <li>
                <a href="/admin/instructions" class="btn btn-default btn-rounded">Add Instructions</a>
                <a href="/admin/question/add" class="btn btn-default btn-rounded">Add a Question</a>
            </li>
            <li>
                <a href="/admin/question/edit" class="btn btn-default btn-rounded">Edit a Question</a>
                <a href="/admin/question/delete" class="btn btn-default btn-rounded">Delete a Question</a>
            </li>
            <li>
                <a href="/login/logout" class="btn btn-default btn-rounded">Logout</a>
            </li>

        </ul>
    </div>
</div>