<?php include("./header.php") ?>
<?php
if (in_array("100001", $group_array) || in_array("100008", $group_array) || in_array("100007", $group_array)) {
} else {
	$CurrentPage = htmlspecialchars(basename($_SERVER['PHP_SELF']));
	notgranted($CurrentPage);
}
?>
<script>
	$(document).ready(function() {
		<?php initiateSimpleTrumbowyg("ProjectDescription") ?>
	});
</script>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card">
			<div class="card-header card-headers"><i class="fas fa-project-diagram fa-lg"></i> <?php echo _("Create new project"); ?>
			</div>
			<div class="card-body">
				<?php

				$UserID = $_SESSION['id'];
				$time = strtotime(date("Y-m-d H:i:s"));
				$datenow = date("d-m-Y G:i", $time);

				if (isset($_POST['submit_createproject'])) {
					$ProjectManager = $_POST['ProjectManager'];
					$ProjectStatus = $_POST['ProjectStatus'];
					$GroupAccess = $_POST['GroupAccess'];
					$GroupManage = $_POST['GroupManage'];
					$ProjectResponsible = $_POST['ProjectResponsible'];
					$ProjectDeadline = $_POST['ProjectDeadline'];
					$ProjectName = $_POST['ProjectName'];
					$ProjectDescription = $_POST['ProjectDescription'];
					$ProjectEstimatedBudget = $_POST['ProjectEstimatedBudget'];
					$ProjectRelCustomer = $_POST['ProjectRelCustomer'];

					createNewProject($ProjectManager, $ProjectStatus, $GroupAccess, $GroupManage, $ProjectDeadline, $ProjectName, $ProjectDescription, $ProjectEstimatedBudget, $ProjectRelCustomer, $ProjectResponsible);
					echo "<script>pnotify('Project created','success')</script>";

					$redirectpage = "<meta http-equiv='refresh' content='2';url=projects_front.php>";
					echo $redirectpage;
				}
				?>
				<form role='form' method='POST'>

					<div class="row">
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="input-group input-group-static mb-4">
								<label for="ProjectManager"><?php echo _("Manager"); ?></label>
								<select id="ProjectManager" name="ProjectManager" class="form-control" required>
									<option value='-1' label=''></option>
									<?php
									$sql = "SELECT ID, CONCAT(users.firstname,' ',users.lastname,' (',users.username,')') AS FullName, Username
											FROM users
											WHERE RelatedUserTypeID IN (1,3) AND Active = 1";
									$result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
									while ($row = mysqli_fetch_array($result)) {
										echo "<option value='" . $row['ID'] . "'>" . $row['FullName'] . "</option>";
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="input-group input-group-static mb-4">
								<label for="ProjectResponsible"><?php echo _("Responsible"); ?></label>
								<select id="ProjectResponsible" name="ProjectResponsible" class="form-control" required>
									<option value='-1' label=''></option>
									<?php
									$sql = "SELECT ID, CONCAT(users.firstname,' ',users.lastname,' (',users.username,')') AS FullName, Username
											FROM users
											WHERE RelatedUserTypeID IN (1,3) AND Active = 1";
									$result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
									while ($row = mysqli_fetch_array($result)) {
										echo "<option value='" . $row['ID'] . "'>" . $row['FullName'] . "</option>";
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="input-group input-group-static mb-4">
								<label for="ProjectStatus"><?php echo _("Status"); ?></label>
								<select id="ProjectStatus" name="ProjectStatus" class="form-control" required>
									<option value='-1' label=''></option>
									<?php
									$sql = "SELECT ID, StatusName 
											FROM projects_statuscodes
											WHERE projects_statuscodes.Active = 1";
									$result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
									while ($row = mysqli_fetch_array($result)) {
										$Status = _($row['StatusName']);
										echo "<option value='" . $row['ID'] . "'>" . $Status . "</option>";
									}
									?>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="input-group input-group-static mb-4">
								<label for="GroupAccess" data-bs-toggle="tooltip" data-bs-title="<?php echo _("User group that can participate in this project") ?>"><?php echo _("Group Access"); ?></label>
								<select id="GroupAccess" name="GroupAccess" class="form-control" required>
									<option value='-1' label=''></option>
									<?php
									$sql = "SELECT  usergroups.ID, usergroups.GroupName 
											FROM usergroups
											WHERE RelatedModuleID = 6";
									$result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
									while ($row = mysqli_fetch_array($result)) {
										$GroupName = _($row['GroupName']);
										echo "<option value='" . $row['ID'] . "'>" . $GroupName . "</option>";
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="input-group input-group-static mb-4">
								<label for="GroupManage" data-bs-toggle="tooltip" data-bs-title="<?php echo _("User group that can administrate this project") ?>"><?php echo _("Group Managers"); ?></label>
								<select id="GroupManage" name="GroupManage" class="form-control" required>
									<option value='-1' label=''></option>
									<?php
									$sql = "SELECT  usergroups.ID, usergroups.GroupName 
											FROM usergroups
											WHERE RelatedModuleID = 6";
									$result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
									while ($row = mysqli_fetch_array($result)) {
										$GroupName = _($row['GroupName']);
										echo "<option value='" . $row['ID'] . "'>" . $GroupName . "</option>";
									}
									?>
								</select>
							</div>
						</div>

						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="input-group input-group-static mb-4">
								<label for="ProjectRelCustomer" data-bs-toggle="tooltip" data-bs-title="<?php echo _("Customer that this project is to be related to") ?>"><?php echo _("Related Customer"); ?></label>
								<select id="ProjectRelCustomer" name="ProjectRelCustomer" class="form-control" required>
									<option value='-1' label=''></option>
									<?php
									$sql = "SELECT ID, Companyname
											FROM companies";
									$result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
									while ($row = mysqli_fetch_array($result)) {
										echo "<option value='" . $row['ID'] . "'>" . $row['Companyname'] . "</option>";
									}
									?>
								</select>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="input-group input-group-static mb-4">
								<label for="ProjectDeadline"><?php echo _("Deadline"); ?></label>
								<input type="text" id="ProjectDeadline" name="ProjectDeadline" class="form-control" value="<?php echo $datenow; ?>">
							</div>
						</div>

						<div class="col-md-4 col-sm-6 col-xs-12">
							<div class="input-group input-group-static mb-4">
								<label for="ProjectEstimatedBudget"><?php echo _("Estimated Budget"); ?></label>
								<input type="text" id="ProjectEstimatedBudget" name="ProjectEstimatedBudget" class="form-control" value="0">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="input-group input-group-static mb-4">
								<label for="ProjectName"><?php echo _("Name"); ?></label>
								<input type="text" id="ProjectName" name="ProjectName" class="form-control">
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="input-group input-group-static mb-4">
								<label for="ProjectDescription"><?php echo _("Description"); ?></label>
								<textarea type="text" id="ProjectDescription" name="ProjectDescription" class="form-control" rows="20"></textarea>
							</div>
						</div>
					</div>
					<button type="submit" name="submit_createproject" id="submit_createproject" class="btn btn-sm btn-success float-end"><span class=""></span> <?php echo _("Create"); ?></button>
				</form>
			</div>
		</div>
	</div>
</div>


<script>
	$(function() {

		jQuery('#ProjectDeadline').datetimepicker({
			format: 'd-m-Y H:i',
			prevButton: false,
			nextButton: false,
			step: 60,
			dayOfWeekStart: 1
		});
		$.datetimepicker.setLocale('<?php echo $languageshort ?>');
	});
</script>

<?php include("./footer.php") ?>