<?php include("./header.php"); ?>
<?php
if (in_array("100001", $group_array) || in_array("100018", $group_array) || in_array("100019", $group_array)) {
} else {
  $CurrentPage = htmlspecialchars(basename($_SERVER['PHP_SELF']));
  notgranted($CurrentPage);
}
?>
<div class="row">
  <div class="col-md-12 col-sm-12 col-xs-12">
    <div class="card">
      <div class="card-header card-header-passwords"><?php echo _("Passwords"); ?>
        <div class="float-end">
          <ul class="navbar-nav justify-content-end">
            <li class="nav-item dropdown pe-2">
              <a href="javascript:;" class="nav-link text-body p-0 position-relative" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                &nbsp;&nbsp;<i class="fa-solid fa-ellipsis-vertical" data-bs-toggle='tooltip' data-bs-title="<?php echo _("Create password") ?>"></i>&nbsp;&nbsp;
              </a>
              <ul class="dropdown-menu dropdown-menu-end p-2 me-sm-n4" aria-labelledby="dropdownMenuButton">
                <li class="mb-2">
                  <a class="dropdown-item border-radius-md" onclick="runmodalcreatenew()">
                    <div class="d-flex align-items-center py-1">
                      <div class="ms-2">
                        <h6 class="text-sm font-weight-normal my-auto">
                          <?php echo _("Create password"); ?>
                        </h6>
                      </div>
                    </div>
                  </a>
                </li>
                <li class=" mb-2">
                  <a class="dropdown-item border-radius-md" onclick="runmodalcreatenewrandom()">
                    <div class="d-flex align-items-center py-1">
                      <div class="ms-2">
                        <h6 class="text-sm font-weight-normal my-auto">
                          <?php echo _("Password generator"); ?>
                        </h6>
                      </div>
                    </div>
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <div class="card-body">

        <?php $redirectpage = "passwordmanager.php"; ?>
        <?php
        if (isset($_POST['submit_new'])) {
          $UserID = $_SESSION["id"];
          $RelatedCompanyID = $_POST["modalCreateCompanyID"];
          $ServerDestination = $_POST["modalCreateDestination"];
          $ServerDomain = $_POST["modalCreateDomain"];
          $Username = $_POST["modalCreateUserName"];
          $password = $_POST["modalCreatePassword"];
          $TypeID = $_POST["modalCreateType"];
          $Description = $_POST["modalCreateDescription"];
          $RelatedGroupID = $_POST["modalCreateRelatedGroup"];

          createNewPasswordEntry($RelatedCompanyID, $ServerDestination, $ServerDomain, $Username, $password, $TypeID, $Description, $RelatedGroupID);

          $redirectpagego = "<meta http-equiv='refresh' content='1';url=" . $redirectpage . "><p><b><div class='alert alert-success'><strong>Password entry added</strong></div></b></p>";
          echo $redirectpagego;
        }

        if (isset($_POST['submit_update'])) {
          $UserID = $_SESSION["id"];
          $PasswordID = $_POST["modalEditID"];
          $RelatedCompanyID = $_POST["modalEditCompany"];
          $ServerDestination = $_POST["modalEditDestination"];
          $ServerDomain = $_POST["modalEditDomain"];
          $Username = $_POST["modalEditUsername"];
          $password = $_POST["modalEditPassword"];
          $TypeID = $_POST["modalEditTypes"];
          $Description = $_POST["modalEditDescription"];
          $RelatedGroupID = $_POST["modalEditGroup"];

          updatePasswordEntry($PasswordID, $RelatedCompanyID, $ServerDestination, $ServerDomain, $Username, $password, $TypeID, $Description, $RelatedGroupID);

          echo "
          <script> pnotify('" . _("Password entry updated") . "','success');</script>
          ";
          $redirectpagego = "<meta http-equiv='refresh' content='1';url=" . $redirectpage . ">";
          echo $redirectpagego;
        }

        if (isset($_POST['submit_remove'])) {
          $UserID = $_SESSION["id"];
          $PasswordID = $_POST["modalEditID"];

          deletePasswordEntry($PasswordID);
          echo "
          <script> pnotify('" . _("Password entry deleted") . "','success');</script>
          ";
          $redirectpagego = "<meta http-equiv='refresh' content='1';url=" . $redirectpage . ">";
          echo $redirectpagego;
        }
        ?>

        <script>
          $(document).ready(function() {
            <?php initiateAdancedViewTable("myPasswords"); ?>
          });
        </script>
        <script>
          function openEditPasswordModal(passwordid) {
            var url = './getdata.php?popModalEditPasswords=' + passwordid;
            $("#editpasswordentryModal").modal('show')
            $.ajax({
              url: url,
              data: {
                data: passwordid
              },
              type: 'POST',
              success: function(data) {

                var obj = JSON.parse(data);
                for (var i = 0; i < obj.length; i++) {
                  document.getElementById('modalEditID').value = obj[i].ID;
                  document.getElementById('modalEditGroup').value = obj[i].RelatedGroupID;
                  document.getElementById('modalEditCompany').value = obj[i].RelatedCompanyID;
                  document.getElementById('modalEditTypes').value = obj[i].DestinationTypeID;
                  document.getElementById('modalEditDestination').value = obj[i].ServerDestination;
                  document.getElementById('modalEditDomain').value = obj[i].Domain;
                  document.getElementById('modalEditUsername').value = obj[i].Username;
                  document.getElementById('modalEditPassword').value = obj[i].Password;
                  document.getElementById('modalCopyPassword').value = obj[i].Password;
                  $('#modalEditDescription').trumbowyg('html', obj[i].Description);
                }
              }
            });
          }

          function runmodalcreatenew() {
            $("#modalCreateNewPasswordModal").modal('show');
          };

          function runmodalcreatenewrandom() {
            $("#modalCreateNewRandomModal").modal('show');
          };
        </script>
        <table id="myPasswords" class="table table-responsive table-borderless table-hover" cellspacing="0">
          <thead>
            <tr>
              <th><?php echo _("ID"); ?></th>
              <th></th>
              <th><?php echo _("Company"); ?></th>
              <th><?php echo _("Domain"); ?></th>
              <th><?php echo _("Destination"); ?></th>
              <th><?php echo _("Username"); ?></th>
              <th><?php echo _("Password"); ?></th>
              <th><?php echo _("Type"); ?></th>
              <th><?php echo _("Type Description"); ?></th>
            </tr>
          </thead>
          <?php

          $sql = "SELECT passwordmanager_passwords.ID AS ID, companies.Companyname AS CompanyName, passwordmanager_passwords.ServerDestination AS ServerDestination, 
                  Username, Password, Domain, DestinationTypeID, passwordmanager_passwordtypes.TypeName AS TypeName, passwordmanager_passwordtypes.HelpText AS HelpText
                  From passwordmanager_passwords INNER JOIN
                  passwordmanager_passwordtypes ON passwordmanager_passwords.DestinationTypeID = passwordmanager_passwordtypes.ID INNER JOIN
                  companies ON passwordmanager_passwords.RelatedCompanyID = companies.ID
                  WHERE passwordmanager_passwords.RelatedGroupID IN('" . implode("','", $group_array) . "');";

          $result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
          ?>
          <tbody>
            <?php while ($row = mysqli_fetch_array($result)) {
              $passwordid = $row['ID'];
              $connectusername = $row['Username'];
              $domain = $row['Domain'];
              $address = $row['ServerDestination'];
              $type = $row['DestinationTypeID'];
              $rdpconnecturl = "";
            ?>
              <tr class='text-sm text-secondary mb-0'>
                <td><?php echo $row['ID'] ?> </td>
                <td>
                  <?php echo "<a href='javascript:void(0)' data-bs-toggle='tooltip' data-bs-title='" . _("Edit") . "' onclick=\"openEditPasswordModal('$passwordid')\"><span class='badge badge-pill bg-gradient-danger'><i class='fas fa-edit'></i></span></a>"; ?>
                  <?php
                  if ($type == 1) {
                    $rdpconnecturl = "createrdpfile.php?autoconnect=1&full_address=$address&name=$address&username=$connectusername&domain=$domain";
                    echo "&nbsp;";
                    echo "<a href='$rdpconnecturl' data-bs-toggle='tooltip' data-bs-title='" . _("Connect to server") . "'><span class='badge badge-pill bg-gradient-secondary'><i class='fas fa-desktop'></i></span></a>";
                  }
                  ?>
                </td>
                <td><?php echo $row['CompanyName']; ?></td>
                <td><?php echo $row['Domain']; ?></td>
                <td><?php echo $row['ServerDestination']; ?></td>
                <td><?php echo $row['Username']; ?></td>
                <td>********</td>
                <td><?php echo $row['TypeName']; ?></td>
                <td><?php echo $row['HelpText']; ?></td>
              </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <?php include("./passwordmanager_createnew.php"); ?>
  <?php include("./passwordmanager_createnewrandom.php"); ?>
  <?php include("./modals/modal_password_edit.php"); ?>
</div>

<!-- /page content -->
<?php include("./footer.php"); ?>