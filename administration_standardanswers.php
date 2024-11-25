<?php
include("./header.php");
?>
<?php
if (in_array("100001", $group_array)) {
} else {
	$CurrentPage = htmlspecialchars(basename($_SERVER['PHP_SELF']));
	notgranted($CurrentPage);
}
?>
<script>
	$(document).ready(function() {
		<?php initiateMediumViewTableHistoryTables("TableStandardAnswer"); ?>
	});
</script>

<?php
if (isset($_POST['submit_new'])) {
	$UserID = $_SESSION["id"];
	$Name = $_POST["Name"];
	$AnswerText = $_POST["AnswerText"];
	$RelatedModule = $_POST["RelatedModule"];

	createStandardAnswer($UserID, $Name, $AnswerText, $RelatedModule);
}
?>

<div class="row">
	<div class="col-md-8 col-sm-8 col-xs-12">
		<div class="card-group">
			<div class="card">
				<div class="card-header card-header"><i class="fas fa-comment-dots fa-lg"></i> <?php echo _("Standard Answers"); ?></div>
				<div class="card-body">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<table id="TableStandardAnswer" class="table table-responsive table-borderless table-hover" cellspacing="0">
							<thead>
								<tr>
									<th><?php echo _("ID") ?></th>
									<th></th>
									<th><?php echo _("Name") ?></th>
									<th><?php echo _("Answer") ?></th>
									<th><?php echo _("Module") ?></th>
								</tr>
							</thead>
							<?php

							$sql = "SELECT standardanswers.ID, standardanswers.Name, Answer, modules.Name AS ModuleName
									FROM standardanswers
									INNER JOIN modules ON standardanswers.RelatedModuleID = modules.ID
									ORDER BY Name ASC";

							$result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
							?>
							<tbody>
								<?php while ($row = mysqli_fetch_array($result)) { ?>
									<tr class='text-sm text-secondary mb-0'>
										<td><?php echo $row['ID']; ?></td>
										<td><?php echo "<a href='./administration_standardanswers_view.php?answerid=" . $row['ID'] . "'><span class='badge badge-pill bg-gradient-secondary'><i class='fa fa-folder-open'></i></span></a>"; ?></td>
										<td><?php echo $row['Name']; ?></td>
										<td><?php echo $row['Answer']; ?></td>
										<td><?php echo _($row['ModuleName']); ?></td>
									</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-sm-4 col-xs-12">
		<div class="card-group">
			<div class="card">
				<div class="card-header card-header"><i class="fas fa-plus fa-lg"></i> <?php echo _("Add"); ?></div>
				<div class="card-body">
					<form method="post">

						<label class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo _("Name"); ?></label>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="input-group input-group-static mb-4">
								<input type="text" class="form-control" id="Name" name="Name" required>
							</div>
						</div>

						<label class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo _("Answer Text"); ?></label>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="input-group input-group-static mb-4">
								<textarea type="text" class="form-control" id="AnswerText" name="AnswerText" rows="15" required></textarea>
							</div>
						</div>

						<label class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo _("Related Module"); ?></label>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="input-group input-group-static mb-4">
								<select id="RelatedModule" name="RelatedModule" class="form-control" required>
									<?php
									$sql = "SELECT ID, Name
											FROM modules
											WHERE Active = 1 AND ID IN (1,2,3,4)";
									$result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));

									while ($row = mysqli_fetch_array($result)) {
										$ID = $row['ID'];
										$Name = _($row['Name']);
										echo "<option value='$ID'>$Name</option>";
									}
									?>
								</select>
							</div>
						</div>
						
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<button type="submit" name="submit_new" class="btn btn-sm btn-success float-end"><?php echo _("Create"); ?></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<?php include("./footer.php") ?>