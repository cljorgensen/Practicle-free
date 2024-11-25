<?php
if (in_array("100001", $group_array) || in_array("100018", $group_array) || in_array("100019", $group_array)) {
} else {
	$CurrentPage = htmlspecialchars(basename($_SERVER['PHP_SELF']));
	notgranted($CurrentPage);
}
?>
<script src="./scripts/functions.js"></script>

<!-- Modal Generate Password -->
<div class="modal fade" id="createnewrandomModal" tabindex="-1" role="dialog" aria-labelledby="createnewrandomModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title font-weight-normal" id="createnewrandomModalLabel"><?php echo _('Password generator'); ?></h6>
				<button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p class="statusMsg"></p>
				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="input-group input-group-static mb-4">
						<select id="length" name="length" class="form-control" required>
							<option value=6>6</option>
							<option value=7>7</option>
							<option value=8>8</option>
							<option value=9>9</option>
							<option value=10>10</option>
							<option value=11>11</option>
							<option value=12 selected='select'>12</option>
							<option value=14>14</option>
							<option value=16>16</option>
							<option value=20>20</option>
							<option value=28>28</option>
						</select>
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="input-group input-group-static mb-4">
						<input type="text" class="form-control" id="numbers" name="numbers" value="0123456789" placeholder="">
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="input-group input-group-static mb-4">
						<input type="text" class="form-control" id="smallletters" name="smallletters" value="abcdefghijklmnopqrstuvwxyz" placeholder="">
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="input-group input-group-static mb-4">
						<input type="text" class="form-control" id="bigletters" name="bigletters" value="ABCDEFGHIJKLMNOPQRSTUVWXYZ" placeholder="">
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="input-group input-group-static mb-4">
						<input type="text" class="form-control" id="specialchars" name="specialchars" value="!@#$%&~" placeholder="">
					</div>
				</div>

				<label class="control-label col-md-12 col-sm-12 col-xs-12">
					<p></p>
				</label>
				<label class="control-label col-md-12 col-sm-12 col-xs-12">
					<p><?php echo _("Generated password"); ?></p>
				</label>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<div class="input-group input-group-static mb-4">
						<input type="text" class="form-control" id="generatedpassword" name="generatedpassword" value="" onclick="copytoclipboard('generatedpassword')">
					</div>
				</div>

				<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
					<button type="submit" name="generate_new" class="btn btn-success float-end" onclick="generateRandomString()"><?php echo _("Generate"); ?></button>
				</div>
				<div class="modal-footer">
				</div>
			</div>
		</div>
	</div>
</div>
<!-- End Modal Generate Password -->
