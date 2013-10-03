<?php $title = $thread->title ?>
<h2><?php eh($thread->title) ?></h2>
<?php header("refresh: 3; url=/thread/view?thread_id=$thread->id") ?>

<p class="alert alert-success">You successfully wrote this comment. Please wait while you are being redirected.</p>
<a href="<?php eh(url('thread/view', array('thread_id' => $thread->id))) ?>">
    &larr; Back to Thread
</a>