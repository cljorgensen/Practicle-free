<?php
if (in_array("100001", $group_array) || in_array("100018", $group_array) || in_array("100019", $group_array)) {
} else {
	$CurrentPage = htmlspecialchars(basename($_SERVER['PHP_SELF']));
	notgranted($CurrentPage);
}
?>
<!-- Modal Create Password -->
<script>
	$(document).ready(function() {
		<?php initiateSimpleTrumbowyg("modalCreateDescription") ?>
	});
</script>

<div class="modal fade" id="modalCreateNewPasswordModal" tabindex="-1" role="dialog" aria-labelledby="createnewpasswordModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h6 class="modal-title font-weight-normal" id="createnewpasswordModalLabel"><?php echo _('Create password'); ?></h6>
				<button class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<p class="statusMsg"></p>
				<form action="<?php echo $redirectpage; ?>" method="post">
					<div class="row">
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label for="modalCreateRelatedGroup" class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo _("Group Access"); ?></label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="input-group input-group-static mb-4">
									<select id="modalCreateRelatedGroup" name="modalCreateRelatedGroup" class="form-control">
										<?php
										$sql = "SELECT usergroups.ID, usergroups.GroupName
								FROM usergroups
								WHERE Active=1 AND
								RelatedModuleID=9
								ORDER BY GroupName ASC;";
										$result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
										while ($row = mysqli_fetch_array($result)) {
											if ($row['ID'] == 20) {
												echo "<option value='" . $row['ID'] . "' selected='select'>" . $row['GroupName'] . "</option>";
											} else {
												echo "<option value=" . $row['ID'] . ">" . $row['GroupName'] . "</option>";
											}
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<label for="modalCreateCompanyID" class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo _("Company"); ?></label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="input-group input-group-static mb-4">
									<select id="modalCreateCompanyID" name="modalCreateCompanyID" class="form-control">
										<?php
										$sql = "SELECT companies.id AS CompanyID, companies.Companyname AS Companyname 
								FROM companies 
								WHERE companies.Active=TRUE
								ORDER BY companies.Companyname ASC;";
										$result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
										while ($row = mysqli_fetch_array($result)) {
											echo "<option value=" . $row['CompanyID'] . ">" . $row['Companyname'] . "</option>";
										}
										?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-md-6 col-sm-6 col-xs-12">
							<label for="modalCreateType" class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo _("Type"); ?></label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="input-group input-group-static mb-4">
									<select id="modalCreateType" name="modalCreateType" class="form-control">
										<?php
										$sql = "SELECT passwordmanager_passwordtypes.ID AS ID, passwordmanager_passwordtypes.TypeName AS TypeName 
								FROM passwordmanager_passwordtypes
								ORDER BY TypeName ASC;";
										$result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
										while ($row = mysqli_fetch_array($result)) {
											echo "<option value=" . $row['ID'] . ">" . $row['TypeName'] . "</option>";
										}
										?>
									</select>
								</div>
							</div>
						</div>

						<div class="col-md-6 col-sm-6 col-xs-12">
							<label for="modalCreateDestination" class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo _("Destination"); ?></label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="input-group input-group-static mb-4">
									<input type="text" class="form-control" id="modalCreateDestination" name="modalCreateDestination" value="">
								</div>
							</div>
						</div>

						<div class="col-md-6 col-sm-6 col-xs-12">
							<label for="modalCreateDomain" class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo _("Domain"); ?></label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="input-group input-group-static mb-4">
									<input type="text" class="form-control" id="modalCreateDomain" name="modalCreateDomain" value="">
								</div>
							</div>
						</div>

						<div class="col-md-6 col-sm-6 col-xs-12">
							<label for="modalCreateUserName" class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo _("Username"); ?></label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="input-group input-group-static mb-4">
									<input type="text" class="form-control" id="modalCreateUserName" name="modalCreateUserName" value="">
								</div>
							</div>
						</div>

						<div class="col-md-6 col-sm-6 col-xs-12">
							<label for="modalCreatePassword" class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo _("Password"); ?></label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="input-group input-group-static mb-4">
									<input type="text" class="form-control" id="modalCreatePassword" name="modalCreatePassword" value="">
								</div>
							</div>
						</div>

						<div class="col-md-12 col-sm-12 col-xs-12">
							<label for="modalCreateDescription" class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo _("Description"); ?></label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<div class="input-group input-group-static mb-4">
									<textarea id="modalCreateDescription" name="modalCreateDescription" rows="10" class="resizable_textarea form-control"></textarea>
								</div>
							</div>
						</div>

						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<button type="submit" name="submit_new" class="btn btn-sm btn-success float-end"><?php echo _("Create"); ?></button>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
			</div>
		</div>
	</div>
</div>
<!-- End Modal Create Password -->