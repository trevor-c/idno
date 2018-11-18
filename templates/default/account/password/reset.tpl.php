<div class="row">

    <div class="col-md-10 col-md-offset-1">

        <h1>Reset your password</h1>
        <p>
            To change your password, enter your new password below:
        </p>

    </div>
    <div class="col-md-10 col-md-offset-1">

        <form action="<?=\Idno\Core\Idno::site()->config()->getDisplayURL()?>account/password/reset" method="post" class="form-horizontal">

            <div class="control-group">
                <label class="control-label" for="inputEmail">Your email address<br />
                    <small>The address associated with your <?=\Idno\Core\Idno::site()->config()->title?> account.</small></label>
                <div class="controls">
                    <input type="email" id="inputEmail" placeholder="Email" class="form-control" name="email" value="<?=$vars['email']?>" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPassword">New password (7 characters or more)</label>
                <div class="controls">
                    <input type="password" id="inputPassword" class="form-control" name="password" value="" required>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPassword2">Retype password<br />
                    <small>We ask you to enter the password twice to protect against typos.</small></label>
                <div class="controls">
                    <input type="password" id="inputPassword2" class="form-control" name="password2" value="" required>
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                    <button type="submit" class="btn btn-primary">Reset password</button>
                    <input type="hidden" name="code" value="<?=$vars['code']?>">
                    <?= \Idno\Core\Idno::site()->actions()->signForm('/account/password/reset') ?>
                </div>
            </div>

        </form>

    </div>

</div>