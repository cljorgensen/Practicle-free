<?php include("./header.php") ?>
<?php
if (in_array("100001", $group_array) || in_array("100008", $group_array) || in_array("100007", $group_array)) {
} else {
  $CurrentPage = htmlspecialchars(basename($_SERVER['PHP_SELF']));
	notgranted($CurrentPage);
}
?>
<?php
$SolutionText = "";
?>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-8 col-sm-8 col-xs-12">
        <div class="card">
          <div class="card-header card-header-projects"> <?php echo _("Search Results"); ?>
          </div>
          <div class="card-body">

            <script>
              $(document).ready(function() {
                <?php initiateSimpleViewTableRelations("searchresults"); ?>
              });
            </script>

            <?php
            if (isset($_POST['do_search_solutions'])) {
              $searchstring = $_POST['incidentssearchstringsolutions'];
            ?>
              <div id="accordionSolution" role="tablist">
                <table id="searchresults" class="table table-responsive table-borderless table-hover" cellspacing="0">
                  <thead>
                    <tr>
                      <th><?php echo _("ID") ?></th>
                      <th><?php echo _("Solution") ?></th>
                    </tr>
                  </thead>
                  <?php

                  $sql = "SELECT tickets.ID, SolutionTextFullText, tickets.Subject
              FROM tickets
              WHERE MATCH(SolutionTextFullText) AGAINST ('$searchstring'  IN NATURAL LANGUAGE MODE);";

                  $result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
                  ?>
                  <tbody>
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                      <?php
                      $ID = $row['ID'];
                      $SolutionTextFullText = $row['SolutionTextFullText'];
                      $Subject = $row['Subject'];
                      $SolutionTextFullTextHeader = substr($row['SolutionTextFullText'], 0, 100);
                      ?>

                      <tr>
                        <td width="10%"><?php echo "<a href='incidents_view.php?elementid=$ID'><button class='btn btn-sm btn-warning' data-bs-toggle='tooltip' data-bs-title='" . _("Open Incident") . "'></i>$ID</button></a>" ?> </td>
                        <td width="90%">
                          <div class="card-collapse">
                            <div class="card-header" role="tab" id="heading<?php echo $ID; ?>">
                              <h5 class="mb-0">
                                <a class="collapsed" data-bs-toggle="collapse" href="#collapse<?php echo $ID; ?>" aria-expanded="false" aria-controls="collapse<?php echo $ID; ?>">
                                  <p class='category align-middle'><?php echo "<div class='col-md-12 col-sm-12 col-xs-12'>" . $SolutionTextFullTextHeader . "</div>"; ?></p>
                                </a>
                              </h5>
                            </div>
                            <div id="collapse<?php echo $ID; ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?php echo $ID; ?>" data-parent="#accordionSolution">
                              <div class="card-body">
                                <div class='col-md-12 col-sm-12 col-xs-12'>
                                  <?php
                                  echo "<h5>" . _("Subject") . "</h5> " . $Subject . "<br><br>";
                                  echo "<h5>" . _("Solution") . "</h5> " . $SolutionTextFullText;
                                  ?>
                                </div>
                              </div>
                            </div>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            <?php } ?>

            <?php
            if (isset($_POST['do_search_subjects'])) {
              $searchstring = $_POST['incidentssearchstringsubjects']; ?>
              <div id="accordionSubject" role="tablist">
                <table id="searchresults" class="table table-responsive table-borderless table-hover" cellspacing="0">
                  <thead>
                    <tr>
                      <th><?php echo _("ID") ?></th>
                      <th><?php echo _("Subject") ?></th>
                    </tr>
                  </thead>
                  <?php

                  $sql = "SELECT tickets.ID, Subject, ProblemTextFullText
              FROM tickets
              WHERE MATCH(Subject) AGAINST ('$searchstring'  IN NATURAL LANGUAGE MODE);";

                  $result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
                  ?>
                  <tbody>
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                      <?php
                      $ID = $row['ID'];
                      $SubjectHeader = substr($row['Subject'], 0, 100);
                      $Subject = $row['Subject'];
                      $ProblemText = $row['ProblemTextFullText'];
                      ?>
                      <tr>
                        <td width="10%"><?php echo "<a href='incidents_view.php?elementid=$ID'><button class='btn btn-sm btn-warning' data-bs-toggle='tooltip' data-bs-title='" . _("Open Incident") . "'></i>$ID</button></a>" ?> </td>
                        <td width="90%">
                          <div class="card-collapse">
                            <div class="card-header" role="tab" id="heading<?php echo $ID; ?>">
                              <h5 class="mb-0">
                                <a class="collapsed" data-bs-toggle="collapse" href="#collapse<?php echo $ID; ?>" aria-expanded="false" aria-controls="collapse<?php echo $ID; ?>">
                                  <p class='category align-middle'><?php echo "<div class='col-md-12 col-sm-12 col-xs-12'>" . $SubjectHeader . "</div>"; ?></p>
                                </a>
                              </h5>
                            </div>
                            <div id="collapse<?php echo $ID; ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?php echo $ID; ?>" data-parent="#accordionSubject">
                              <div class="card-body">
                                <div class='col-md-12 col-sm-12 col-xs-12'>
                                  <?php
                                  echo "<h5>" . _("Subject") . "</h5><p>" . $Subject . "</p><br><br>";
                                  echo "<h5>" . _("Problem Text") . "</h5><p>" . $ProblemText . "</p>";
                                  ?>
                                </div>
                              </div>
                            </div>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            <?php } ?>


            <?php
            if (isset($_POST['do_search_problems'])) {
              $searchstring = $_POST['incidentssearchstringproblems']; ?>
              <div id="accordionProblemText" role="tablist">
                <table id="searchresults" class="table table-responsive table-borderless table-hover" cellspacing="0">
                  <thead>
                    <tr>
                      <th><?php echo _("ID") ?></th>
                      <th><?php echo _("Subject") ?></th>
                    </tr>
                  </thead>
                  <?php

                  $sql = "SELECT tickets.ID, Subject, ProblemTextFullText
                          FROM tickets
                          WHERE MATCH(ProblemTextFullText) AGAINST ('$searchstring'  IN NATURAL LANGUAGE MODE);";

                  $result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
                  ?>
                  <tbody>
                    <?php while ($row = mysqli_fetch_array($result)) { ?>
                      <?php
                      $ID = $row['ID'];
                      $SubjectHeader = substr($row['Subject'], 0, 100);
                      $Subject = $row['Subject'];
                      $ProblemText = $row['ProblemTextFullText'];
                      ?>
                      <tr>
                        <td width="10%"><?php echo "<a href='incidents_view.php?elementid=$ID'><button class='btn btn-sm btn-warning' data-bs-toggle='tooltip' data-bs-title='" . _("Open Incident") . "'></i>$ID</button></a>" ?> </td>
                        <td width="90%">
                          <div class="card-collapse">
                            <div class="card-header" role="tab" id="heading<?php echo $ID; ?>">
                              <h5 class="mb-0">
                                <a class="collapsed" data-bs-toggle="collapse" href="#collapse<?php echo $ID; ?>" aria-expanded="false" aria-controls="collapse<?php echo $ID; ?>">
                                  <p class='category align-middle'><?php echo "<div class='col-md-12 col-sm-12 col-xs-12'>" . $SubjectHeader . "</div>"; ?></p>
                                </a>
                              </h5>
                            </div>
                            <div id="collapse<?php echo $ID; ?>" class="collapse" role="tabpanel" aria-labelledby="heading<?php echo $ID; ?>" data-parent="#accordionProblemText">
                              <div class="card-body">
                                <div class='col-md-12 col-sm-12 col-xs-12'>
                                  <?php
                                  echo "<h5>" . _("Subject") . "</h5><p>" . $Subject . "</p><br><br>";
                                  echo "<h5>" . _("Problem Text") . "</h5><p>" . $ProblemText . "</p>";
                                  ?>
                                </div>
                              </div>
                            </div>
                        </td>
                      </tr>
                    <?php } ?>
                  </tbody>
                </table>
              </div>
            <?php } ?>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
        <div class="card">
          <div class="card-header card-header-projects"><i class="fab fa-searchengin fa-lg"></i> <?php echo _("Projects search"); ?>
            <div class="float-end">
              <ul class="navbar-nav justify-content-end">
                <li class="nav-item dropdown pe-2">
                  <a href="javascript:;" class="nav-link text-body p-0 position-relative" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    &nbsp;&nbsp;<i class="fa-solid fa-circle-chevron-down" data-bs-toggle='tooltip' data-bs-title="<?php echo _("Create") ?>"></i>&nbsp;&nbsp;
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end p-2 me-sm-n4" aria-labelledby="dropdownMenuButton">
                    <li class="mb-2">
                      <a class="dropdown-item border-radius-md" onclick="window.location.href=('projects.php')">
                        <div class="d-flex align-items-center py-1">
                          <div class="ms-2">
                            <h6 class="text-sm font-weight-normal my-auto">
                              <?php echo _("Open projects") ?>
                            </h6>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li class="mb-2">
                      <a class="dropdown-item border-radius-md" onclick="window.location.href=('projects_finished.php')">
                        <div class="d-flex align-items-center py-1">
                          <div class="ms-2">
                            <h6 class="text-sm font-weight-normal my-auto">
                              <?php echo _("Closed projects") ?>
                            </h6>
                          </div>
                        </div>
                      </a>
                    </li>
                    <li class="mb-2">
                      <a class="dropdown-item border-radius-md" onclick="window.location.href=('projects_search.php')">
                        <div class="d-flex align-items-center py-1">
                          <div class="ms-2">
                            <h6 class="text-sm font-weight-normal my-auto">
                              <?php echo _("Search projects") ?>
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
							<li class="nav-item dropdown pe-2">
								<a href="javascript:void(0);" title="<?php echo _("Create project") ?>" onclick="runModalCreateNewProject();" class="nav-link text-body p-0 position-relative" aria-expanded="false">
									&nbsp;&nbsp;<i class="far far-dark fa-plus-square"></i>&nbsp;&nbsp;
								</a>
							</li>
						</ul>
					</div>
          </div>
          <div class="card-body">
            <form action="incidents_search.php" method="post">
              <p><i class='fa fa-ticket'></i> <?php echo _('Solutions'); ?></p>
              <div class="input-group input-group-static mb-4">
                <input type="text" id="incidentssearchstringsolutions" name="incidentssearchstringsolutions" class="form-control">
                <button name="do_search_solutions" class="btn btn-sm btn-success" type="submit"><?php echo _("Search"); ?></button>
              </div>

              <p><i class='fa fa-ticket'></i> <?php echo _('Subjects'); ?></p>
              <div class="input-group input-group-static mb-4">
                <input type="text" id="incidentssearchstringsubjects" name="incidentssearchstringsubjects" class="form-control">
                <button name="do_search_subjects" class="btn btn-sm btn-success" type="submit"><?php echo _("Search"); ?></button>
              </div>

              <p><i class='fa fa-ticket'></i> <?php echo _('Problem descriptions'); ?></p>
              <div class="input-group input-group-static mb-4">
                <input type="text" id="incidentssearchstringproblems" name="incidentssearchstringproblems" class="form-control">
                <button name="do_search_problems" class="btn btn-sm btn-success" type="submit"><?php echo _("Search"); ?></button>
              </div>
            </form>
          </div>
        </div>
      </div>      
    </div>
  </div>
</div>
<?php include("./footer.php") ?>