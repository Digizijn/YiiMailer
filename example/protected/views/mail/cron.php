<p>Message from <?= $name . ': ' . $message ?></p>

<p>You may change the content of this page by modifying the following two files:</p>
<ul>
	<li>View file: <tt><?= __FILE__; ?></tt></li>
	<li>Layout file: <tt><?= $mailer->getViewFile($mailer->getLayoutPath() . '.' . $mailer->getLayout()); ?></tt></li>
</ul>