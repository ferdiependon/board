<?php $title = "Register" ?>

<h1>Register Account</h1>

<?php if ($user->hasError() || $user->username_reg) : ?>
    <div class="alert alert-block">
        <h4 class="alert-heading">Registration Error:</h4>
    <?php $user->username_reg ?>
        <?php if ($user->username_reg) : ?>
            <div><em>Username</em> already exists!</div>
        <?php endif ?>
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
        <?php if (!empty($user->validation_errors['password_reg']['match'])) : ?>
            <div><em>Passwords</em> do not match.</div>
        <?php endif ?>
    </div>
<?php endif ?>

<form class="well" method="post" action="<?php url() ?>">
    <label>Username</label>
    <input type="text" class="span2" name="username" value="<?php eh(Param::get('username')) ?>">
    <label>Password</label>
    <input type="password" class="span2" name="password" value="<?php eh(Param::get('password')) ?>">
    <label>Repeat Password</label>
    <input type="password" class="span2" name="password_reg" value="<?php eh(Param::get('password_reg')) ?>">
    <br/>
    <input type="hidden" name="page_next" value="register_end">
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
