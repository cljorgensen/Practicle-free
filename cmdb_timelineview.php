<?php include("./header.php"); ?>
<?php
$ElementID = "";
$CITypeID = "1";
$CIName = "";
if (!empty($_GET['id'])) {
	$CITypeID = $_GET['id'];
}
if (!empty($_GET['elementid'])) {
	$ElementID = $_GET['elementid'];
}
$sql = "SELECT cmdb_cis.ID, cmdb_cis.Name, cmdb_cis.TableName
		FROM cmdb_cis
		WHERE cmdb_cis.ID = $CITypeID";
$result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
while ($row = mysqli_fetch_array($result)) {
	$CIName = $row["Name"];
	$CITableName = $row["TableName"];
}

if ($theme == "dark") {
	$ThemeForTimeline = ".theme.$theme";
} else {
	$ThemeForTimeline = "";
}

?>
<link rel="stylesheet" type="text/css" href="./assets/js/timeline3/css/timeline<?php echo $ThemeForTimeline?>.css">
<script src="./assets/js/timeline3/js/timeline-min.js"></script>

<script>
	$(document).ready(function() {
		let ElementID = "<?php echo $ElementID ?>";
		let CITypeID = <?php echo $CITypeID ?>;
		let UserLanguageCode = "<?php echo $UserLanguageCode ?>";
		let CIName = "<?php echo $CIName ?>";
		let Active = "1";

		fetchCMDBTimelineData(CITypeID, UserLanguageCode, Active, CIName);
	});
</script>

<div class="row">
	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
		<div class="card-group">
			<div class="card">
				<div class="card-header">
					<i class="fa fa-desktop"></i> <a href="cmdb.php"><?php echo _("Assets") ?></a> <i class="fa fa-angle-right"></i> <a href="./cmdb_tableview_cis.php?id=<?php echo $CITypeID ?>"><?php echo _("$CIName"); ?></a>
					<div class="float-end">
						<ul class="navbar-nav justify-content-end">
							<li class="nav-item dropdown pe-2">
								<a href="javascript:;" class="nav-link text-body p-0 position-relative" id="dropdownMenuButton" data-bs-toggle="collapse" data-bs-target="#collapseViewCIS" aria-expanded="false" aria-controls="collapseViewCIS">
									&nbsp;&nbsp;<i class="fa fa-circle-chevron-down" data-bs-toggle="tooltip" data-bs-title="<?php echo _("Assets") ?>"></i>&nbsp;&nbsp;
								</a>
							</li>
						</ul>
					</div>
					<div class="float-end">
						<ul class='navbar-nav justify-content-end'>
							<li class='nav-item dropdown pe-2'>
								<a href='javascript:;' class='nav-link text-body p-0 position-relative' id='dropdownMenuButton' data-bs-toggle='dropdown' aria-expanded='false'>
									&nbsp;&nbsp;<i class="fa-solid fa-ellipsis-vertical" title="<?php echo _("Actions") ?>"></i>&nbsp;&nbsp;
								</a>
								<ul class='dropdown-menu dropdown-menu-end p-2 me-sm-n4' aria-labelledby='dropdownMenuButton'>
									<li class='mb-2'>
										<a class='dropdown-item border-radius-md' href='./cmdb_tableview_cis.php?id=<?php echo $CITypeID ?>'>
											<div class='d-flex align-items-center py-1'>
												<div class='ms-2'>
													<h6 class='text-sm font-weight-normal my-auto'>
														<?php echo _("Table view") ?>
													</h6>
												</div>
											</div>
										</a>
									</li>
									<li class='mb-2'>
										<a class='dropdown-item border-radius-md' href='./cmdb_timelineview.php?id=<?php echo $CITypeID ?>'>
											<div class='d-flex align-items-center py-1'>
												<div class='ms-2'>
													<h6 class='text-sm font-weight-normal my-auto'>
														<?php echo _("Timeline view") ?>
													</h6>
												</div>
											</div>
										</a>
									</li>
									<li class='mb-2'>
										<a class='dropdown-item border-radius-md' onclick="makeThisCIStandardOpening(<?php echo $CITypeID ?>);">
											<div class='d-flex align-items-center py-1'>
												<div class='ms-2'>
													<h6 class='text-sm font-weight-normal my-auto'>
														<div class="form-check form-switch" data-bs-toggle="tooltip" data-bs-title="<?php echo _("Make this the Standard opening page?") ?>">
															<input class="form-check-input" type="checkbox" id="StandardCIToOpen" name="StandardCIToOpen">
															<label class="form-check-label" for="StandardCIToOpen"><?php echo _("Standard") ?></label>
														</div>
													</h6>
												</div>
											</div>
										</a>
									</li>
									<li class='mb-2'>
										<a class='dropdown-item border-radius-md' onclick="fetchCMDBDataAndBuildTable('<?php echo $ElementID ?>', '<?php echo $CITypeID ?>', '<?php echo $UserLanguageCode ?>', '0');">
											<div class='d-flex align-items-center py-1'>
												<div class='ms-2'>
													<h6 class='text-sm font-weight-normal my-auto'>
														<?php echo _("Archive") ?>
													</h6>
												</div>
											</div>
										</a>
									</li>
								</ul>
							</li>
						</ul>
					</div>
					<div class="float-end">
						<ul class="navbar-nav justify-content-end">
							<li class="nav-item dropdown pe-2" title="<?php echo $functions->translate("Create"); ?>">
								<a href="javascript:void(0);" onclick="runModalCreateCI();" class="nav-link text-body p-0 position-relative" aria-expanded="false">
									&nbsp;&nbsp;<i class="far far-dark fa-plus-square"></i>&nbsp;&nbsp;
								</a>
							</li>
						</ul>
					</div>
				</div>

				<div class="card-body">
					<div class="row">
						<div class="collapse" id="collapseViewCIS">
							<div class="row">
								<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
								</div>
								<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
									<script>
										$(document).ready(function() {
											<?php initiateSimpleViewTableHistoryTables("tableCIs", 20, []); ?>
										});
									</script>

									<table id="tableCIs" class="table-borderless" cellspacing="0">
										<thead style="display: none;">
											<tr>
												<th></th>
											</tr>
										</thead>
										<tbody>
											<?php
											$BSArray = getCIsForOverview();

											foreach ($BSArray as $key => $value) {
												$Name = _($value["Name"]);
												$Description = _($value["Description"]);
												$LastSyncronized = $value["LastSyncronized"];
												if ($value["ID"] == "0") {
													echo "<tr class='text-sm text-secondary mb-0' title='$Description synced: $LastSyncronized'>";
													echo "<td><a href='businessservices.php'>" . _($value["Name"]) . "</a></td>";
													echo "</tr>";
												} else {
													echo "<tr class='text-sm text-secondary mb-0' title='$Description synced: $LastSyncronized''>";
													echo "<td><a href='cmdb_tableview_cis.php?id=" . $value['ID'] . "'>" . $value["Name"] . "</a></td>";
													echo "</tr>";
												}
											}
											?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								<div id="timeline-embed" style="width: 100%; height: 600px"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include("./modals/modal_create_ci.php") ?>
	<?php include("./footer.php"); ?>