<?php require TPL_PATH.'/header.php'; ?>

<!-- Main jumbotron for a primary marketing message or call to action -->
<div class="jumbotron">
	<div class="container">
		<h2>Mast web</h2>

		<h3>Start</h3>
			<pre>
				<?php $this->utils->shell("/etc/init.d/mast start"); ?>
			</pre>
		<h3>Stop</h3>
			<pre>
				<?php $this->utils->shell("/etc/init.d/mast stop"); ?>
			</pre>
		<h3>List</h3>
			<pre>
				<?php $this->utils->shell("/etc/init.d/mast list"); ?>
			</pre>
		<h3>List-log</h3>
			<pre>
				<?php $this->utils->shell("/etc/init.d/mast List-log"); ?>
			</pre>
	</div>
</div>


<?php require TPL_PATH.'/footer.php'; ?>
