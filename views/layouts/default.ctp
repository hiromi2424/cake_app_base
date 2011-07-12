<?php echo $this->Html->docType('xhtml-trans') ?>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
	<?php echo $this->element('layout' . DS . 'meta') ?>
	<title><?php echo $title_for_layout ?> | <?php echo Configure::read('Site.htmlTitle') ?></title>
	<?php echo $this->element('layout' . DS . 'assets', compact('scripts_for_layout')) ?>
</head>

<body>
	<div id="container">
		<div id="header">
			<?php
				echo $this->element('layout' . DS . 'header', compact('title_for_layout'));
			?>
		</div>
		<div id="content">

			<?php echo $this->Session->flash('auth'); ?>
			<?php echo $this->Session->flash(); ?>

			<?php echo $content_for_layout; ?>
		</div>
		<div id="footer">
			<?php echo $this->element('layout' . DS . 'footer', array('cache' => true)) ?>
		</div>
	</div>
	<?php echo $this->Js->writeBuffer() ?>
</body>
</html>