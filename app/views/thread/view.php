<?php $title = " - " . $thread->title ?>
<p><a href="<?php eh(url('thread/index')) ?>">All Threads</a> &raquo; <?php eh($thread->title) ?></p>
<h1><?php eh($thread->title) ?></h1>

<?php foreach ($comments as $k => $v): ?>
    <div class="comment">
        <div class="meta">
            #<?php eh($k + 1) ?>: Posted by <b><?php eh($v->username) ?></b> on 
             <?php eh(date("F j, Y @ g:i:s A", strtotime($v->created))) ?>
        </div>
        <div class="text">
            <?php echo readable_text($v->body) ?>
        </div>
    </div>
<?php endforeach ?>

<hr>

<form class="well" method="post" action="<?php eh(url('thread/write')) ?>">
    <label>Name</label>
    <?php if(isset($_SESSION['username'])): ?>
        <input type="text" class="span2" name="username" value="<?php eh($_SESSION['username']) ?>" readonly>
    <?php else: ?>
        <input type="text" class="span2" name="username" value="<?php eh(Param::get('username')) ?>">
    <?php endif ?>
    <label>Comment</label>
    <textarea name="body"><?php eh(Param::get('body')) ?></textarea>
    <br/>
    <input type="hidden" name="thread_id" value="<?php eh($thread->id) ?>">
    <input type="hidden" name="page_next" value="write_end">
    <button type="submit" class="btn btn-primary">Submit</button>
</form>