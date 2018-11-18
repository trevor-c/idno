<!-- To silo is human, to syndicate divine -->
<link rel="alternate" type="application/rss+xml" title="<?= htmlspecialchars($vars['title']) ?>"
      href="<?= $this->getURLWithVar('_t', 'rss'); ?>"/>
<link rel="feed" type="application/rss+xml" title="<?= htmlspecialchars($vars['title']) ?>"
      href="<?= $this->getURLWithVar('_t', 'rss'); ?>"/>
<link rel="alternate feed" type="application/rss+xml"
      title="<?= htmlspecialchars(\Idno\Core\Idno::site()->config()->title) ?>: all content"
      href="<?= \Idno\Core\Idno::site()->config()->getDisplayURL() ?>content/all?_t=rss"/>
<link rel="alternate" type="application/json"
      title="<?= htmlspecialchars(\Idno\Core\Idno::site()->config()->title) ?>: all content"
      href="<?= \Idno\Core\Idno::site()->config()->getDisplayURL() ?>content/all?_t=rss" />
<link rel="feed" type="text/html" title="<?= htmlspecialchars(\Idno\Core\Idno::site()->config()->title) ?>"
      href="<?= \Idno\Core\Idno::site()->config()->getDisplayURL() ?>content/all"/>

<!-- Webmention endpoint -->
<link href="<?= \Idno\Core\Idno::site()->config()->getURL() ?>webmention/" rel="http://webmention.org/"/>
<link href="<?= \Idno\Core\Idno::site()->config()->getURL() ?>webmention/" rel="webmention"/>

<?php if (!empty(\Idno\Core\Idno::site()->config()->hub)) { ?>
    <!-- Pubsubhubbub -->
    <link href="<?= \Idno\Core\Idno::site()->config()->hub ?>" rel="hub"/>
<?php } ?>