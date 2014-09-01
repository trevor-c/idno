<div class="row">

    <div class="span10 offset1">
        <h1>
            Share your feedback
        </h1>
        <?= $this->draw('account/menu') ?>
        <p>
            <em>Want to share something with the Known team? We'd love to read your thoughts, suggestions, or ideas.</em>
        </p>
        <hr>

    </div>
</div>

<div class="row">
    <div class="span10 offset1">

        <form class="form-horizontal" action="<?= \Idno\Core\site()->config()->getURL() ?>account/settings/feedback"
              method="post">

            <p class="feedback">
                <strong>From:</strong> <?= \Idno\Core\site()->session()->currentUser()->email ?>
                <input type="hidden" name="email"
                       value="<?= htmlentities(\Idno\Core\site()->session()->currentUser()->email) ?>">
            </p>

            <p class="feedback"><strong>To:</strong> feedback@withknown.com</p>
            <br>

            <p class="feedback"><strong>Subject:</strong> Feedback for the Known team</p>

            <div class="control-group">
                <textarea rows="7" class="feedback" placeholder="Let us know what you think." name="message" required></textarea>

                <p>
                    <em>We will personally read all of your feedback. This form receives your email address so that we
                    can respond, but we won't add your address to any list.</em>
                </p>

                <div class="control-group">
                    <div class="feedback-btn">
                        <?= \Idno\Core\site()->actions()->signForm('/account/settings/feedback') ?>
                        <input type="submit" class="btn btn-feedback" value="Send feedback">
                    </div>
                </div>

        </form>
    </div>
