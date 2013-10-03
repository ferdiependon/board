<?php $title = "Login" ?>

<?php if (isset($_SESSION['username'])) : ?>
    <?php header("refresh: 3; url=/thread/index") ?>
    <h1>Logged In</h1>
    <p class="alert alert-success">
        You have logged in successfully,
        <b><?php echo $_SESSION['username'] ?></b>.
        Please wait while you are being redirected.
    </p>
    <a href="<?php eh(url('thread/index')) ?>">
        &larr; Go to Home
    </a>

<?php else : ?>
    <div class="alert alert-block">
        <h4 class="alert-heading">Login Error:</h4>
        <?php if (!empty($user->validation_errors['username']['length'])) : ?>
            <div><em>Username</em> must be between
                <?php eh($user->validation['username']['length'][1]) ?> and
                <?php eh($user->validation['username']['length'][2]) ?>
                characters in length.
            </div>
        <?php endif ?>
        <?php if (!empty($user->validation_errors['password']['length'])) : ?>
            <div><em>Password</em> must be between
                <?php eh($user->validation['password']['length'][1]) ?> and
                <?php eh($user->validation['password']['length'][2]) ?>
                characters in length.
            </div>
        <?php endif ?>
        <?php if (!$user->validation_errors['username']['length'] &&
                  !$user->validation_errors['password']['length']) : ?>
            <div>Wrong username or password.</div>
        <?php endif ?>
    </div>
<?php endif ?>
