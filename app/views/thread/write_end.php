<?php $title = $thread->title ?>
<?php header("refresh: 3; url=/thread/view?thread_id=$thread->id") ?>

<h1><?php eh($thread->title) ?></h1>

<p class="alert alert-success">
    You successfully wrote this comment.
    Please wait while you are being redirected.
</p>
<a href="<?php eh(url('thread/view', array('thread_id' => $thread->id))) ?>">
    &larr; Back to Thread
</a>
