<h2><?php eh($thread->title) ?></h2>

<p class="alert alert-success">Thread successfully created.</p>

<a href="<?php eh(url('thread/view', array('thread_id' => $thread->id))) ?>">
    &larr; Got to thread
</a>