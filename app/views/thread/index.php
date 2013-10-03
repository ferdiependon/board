<?php $title = "Threads"; ?>

<script type="text/javascript">
    function filter()
    {
        document.forms["pager"].submit();
    }
</script>

<h1>All Threads</h1>

<a class="btn btn-large btn-primary" href="<?php eh(url('thread/create')) ?>">
    Start New Thread
</a>

<div class="thread-list">
    <div class="header">
        <span><b>Title</b></span>
        <span><b>Author</b></span>
        <span class="comments"><b>Comments</b></span>
        <span><b>Last Post</b></span>
    </div>
    <ul>
        <?php foreach ($threads as $v) : ?>
            <li>
                <span>
                    <a href="
                        <?php eh(url(
                            'thread/view',
                            array('thread_id' => $v->id)
                        )) ?>">
                        <?php eh($v->title) ?>
                    </a>
                </span>
                <span>
                    <?php eh($v->author) ?>
                </span>
                <span class="comments">
                    <?php eh($v->comments) ?>
                </span>
                <span>
                    <?php eh(date(
                        "F j, Y, g:i:s A",
                        strtotime($v->last_post)
                    ))?>
                </span>
            </li>
        <?php endforeach ?>
    </ul>
    <div class="pager">
        <?php for ($i=1; $i <= $pages; $i++) : ?>
            <a href="<?php eh(url('', array('page'=>$i))) ?>"><?php eh($i) ?></a>
        <?php endfor ?>
        <form method="get" name="pager">
            Items:
            <select id="items" name="items" onchange="filter()">
                <option <?php if ($items == 5) echo 'selected' ?>>5</option>
                <option <?php if ($items == 10) echo 'selected' ?>>10</option>
                <option <?php if ($items == 20) echo 'selected' ?>>20</option>
                <option <?php if ($items == 30) echo 'selected' ?>>30</option>
                <option <?php if ($items == 50) echo 'selected' ?>>50</option>
            </select>
        </form>
    </div>
</div>
