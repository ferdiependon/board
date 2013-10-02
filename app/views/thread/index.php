<?php $title = "Threads"; ?>

<h1>All Threads</h1>

<a class="btn btn-large btn-primary" href="<?php eh(url('thread/create')) ?>">Start New Thread</a>

<div class="thread-list">
    <div class="header">
        <span><b>Title</b></span>
        <span><b>Author</b></span>
        <span><b>Created</b></span>
    </div>
    <ul>
        <?php foreach ($threads as $v): ?>
            <li>
                <span>
                <a href="<?php eh(url('thread/view', array('thread_id' => $v->id))) ?>">
                    <?php eh($v->title) ?>
                </a></span>
                <span>
                    <?php eh($v->author) ?>
                </span>
                <span>
                    <?php eh(date("F j, Y, g:i:s A", strtotime($v->created))) ?>
                </span>
            </li>
        <?php endforeach ?>
    </ul>
</div>