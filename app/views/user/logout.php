<?php $title = "Logout" ?>
<?php header("refresh: 3; url=/thread/index") ?>

<h1>Logged Out</h1>

<p class="alert alert-success">You have logged out successfully. Please wait while you are being redirected.</p>
<a href="<?php eh(url('thread/index')) ?>">
    &larr; Go to Home
</a>