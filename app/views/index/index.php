<?php require VIEWS_PATH . 'inc/header.php' ?>

<div class="row">
	<div class='col-auto'>
		<div class='h2'>測試</div>
	</div>
</div>
<div class='row'>
	<div class='col-12'>
		<table class="table table-dark">
			<thead>
				<tr>
					<?php foreach ($this->data[0] as $key => $val) { ?>
						<td>
							<?= $key; ?>
						</td>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($this->data as $data) { ?>
					<tr>
						<?php foreach ($data as $key => $val) { ?>
							<td>
								<?= $val; ?>
							</td>
						<?php } ?>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>
<div class='row'>
	<div class='col-12'>
		<table class="table table-dark">
			<thead>
				<tr>
					<?php foreach ($this->test[0] as $key => $val) { ?>
						<td>
							<?= $key; ?>
						</td>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($this->test as $data) { ?>
					<tr>
						<?php foreach ($data as $key => $val) { ?>
							<td>
								<?= $val; ?>
							</td>
						<?php } ?>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
</div>

<?php require VIEWS_PATH . 'inc/footer.php' ?>