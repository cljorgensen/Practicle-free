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
		<?php initiateAdvancedViewTable("TableStandardChanges"); ?>
	});
</script>
<?php
if (isset($_POST['submit_new'])) {
	$UserID = $_SESSION["id"];
	$Name = $_POST["Name"];
	$Description = $_POST["Description"];

	createStandardChangeTemplate($UserID, $Name, $Description);
}
?>

<div class="row">
	<div class="col-md-8 col-sm-8 col-xs-12">
		<div class="card-group">
			<div class="card">
				<div class="card-header card-header"><i class="fas fa-check-double fa-lg"></i> <?php echo _("Standard Changes"); ?>
				</div>
				<div class="card-body">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						<table id="TableStandardChanges" class="table table-responsive table-borderless table-hover" cellspacing="0">
							<thead>
								<tr>
									<th><?php echo _("ID") ?></th>
									<th></th>
									<th><?php echo _("Name") ?></th>
									<th><?php echo _("Description") ?></th>
									<th><?php echo _("Active") ?></th>
								</tr>
							</thead>
							<?php

							$sql = "SELECT ID, Name, Description, Active 
								FROM changes_standards";

							$result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
							?>
							<tbody>
								<?php while ($row = mysqli_fetch_array($result)) { ?>
									<?php $StandardChangeID = $row['ID'] ?>
									<tr class='text-sm text-secondary mb-0'>
										<td><?php echo $row['ID']; ?></td>
										<td><a href="administration_standardchanges_view.php?stdchangeid=<?php echo $StandardChangeID ?>"><span class='badge badge-pill bg-gradient-danger'><i class='fa fa-pencil-alt'></i></span></a></td>
										<td><?php echo $row['Name']; ?></td>
										<td><?php echo $row['Description']; ?></td>
										<td><?php echo _($row['Active']); ?></td>
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
				<div class="card-header card-header"><i class="fas fa-plus fa-lg"></i> <?php echo _("Add"); ?>
				</div>
				<div class="card-body">
					<form method="post">

						<label class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo _("Name"); ?></label>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="input-group input-group-static mb-4">
								<input type="text" class="form-control" id="Name" name="Name" autocomplete="off" required>
							</div>
						</div>

						<label class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo _("Description"); ?></label>
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="input-group input-group-static mb-4">
								<textarea type="text" class="form-control" id="Description" name="Description" rows="15" autocomplete="off" required></textarea>
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

<?php include("./footer.php") ?>