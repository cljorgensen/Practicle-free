<!-- Modal Document Archive -->
<script>
  $(document).ready(function() {
    <?php initiateSimpleTrumbowyg("ModalBSDescription") ?>
  });

  function updateBusinessService() {
    var BSID = document.getElementById("ModalBSID").value;
    var Name = document.getElementById("ModalBSName").value;
    var Description = $("#ModalBSDescription").trumbowyg("html");
    var Type = document.getElementById("ModalBSType").value;
    var Shared = document.getElementById("ModalBSShared").value;
    var SLA = document.getElementById("ModalBSSLA").value;
    var Company = document.getElementById("ModalBSCompany").value;
    let Active = document.getElementById("ModalBSActive").value;
    let Responsible = document.getElementById("ModalBSResponsible").value;
    let ShortName = document.getElementById("ModalBSShortName").value;
    var url = './getdata.php?updateBusinessServiceInformation';

    var vData = {
      BSID: BSID,
      Name: Name,
      Description: Description,
      Type: Type,
      Shared: Shared,
      SLA: SLA,
      Company: Company,
      Active: Active,
      Responsible: Responsible,
      ShortName: ShortName
    };

    $.ajax({
      type: "POST",
      url: url,
      data: vData,
      success: function(data) {
        pnotify("Updated", "success");
        $("#ModalViewBusinessservice").modal("hide");
        //location.reload(true);
      },
    });
  }
</script>
<div class="modal fade" id="ModalViewBusinessservice" role="dialog" aria-labelledby="ModalViewBusinessserviceLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title font-weight-normal" id="ModalViewBusinessserviceLabel"><?php echo _('Business Service'); ?></h6>
        <button class="btn btn-link text-dark p-0 fixed-plugin-close-button" data-bs-dismiss="modal" aria-label="Close">
          <i class="material-icons">clear</i>
        </button>
      </div>
      <div class="modal-body">
        <div class="card">
          <div class="card-body">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <input type="hidden" id="ModalBSID" name="ModalBSID" class="form-control">
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="input-group input-group-static mb-4">
                  <label for="ModalBSName"><?php echo _('Name'); ?></label>
                  <input type="text" id="ModalBSName" name="ModalBSName" class="form-control">
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="input-group input-group-static mb-4">
                  <label for="ModalBSShortName" title="<?php echo _('This is used as unique join key for relation purposes'); ?>"><?php echo _('Short Name'); ?></label>
                  <input type="text" id="ModalBSShortName" name="ModalBSShortName" class="form-control">
                </div>
              </div>
              <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class='form-group'>
                  <textarea class="form-control" id="ModalBSDescription" name="ModalBSDescription" rows="10"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div class="input-group input-group-static mb-4">
                    <label for="ModalBSType"><?php echo _('Type'); ?></label>
                    <select id="ModalBSType" name="ModalBSType" class="form-control" required>
                      <?php
                      $sql = "SELECT ID, Name
                        FROM businessservices_types";
                      $result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
                      while ($row = mysqli_fetch_array($result)) {
                        echo "<option value='" . $row['ID'] . "'>" . $row['Name'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div class="input-group input-group-static mb-4">
                    <label for="ModalBSShared"><?php echo _('Shared'); ?></label>
                    <select id="ModalBSShared" name="ModalBSShared" class="form-control" required>
                      <option value='0'><?php echo _("No") ?></option>
                      <option value='1'><?php echo _("Yes") ?></option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <div class="input-group input-group-static mb-4">
                    <label for="ModalBSSLA"><?php echo _('SLA'); ?></label>
                    <select id="ModalBSSLA" name="ModalBSSLA" class="form-control" required>
                      <?php
                      $sql = "SELECT slaagreements.ID, slaagreements.Name AS SLAName
                          FROM slaagreements
                          ;";
                      $result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
                      while ($row = mysqli_fetch_array($result)) {
                        echo "<option value='" . $row['ID'] . "'>" . $row['SLAName'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
                  <div class="input-group input-group-static mb-4">
                    <label for="ModalBSActive"><?php echo _('Active'); ?></label>
                    <select id="ModalBSActive" name="ModalBSActive" class="form-control" required>
                      <option value='0'><?php echo _("No") ?></option>
                      <option value='1'><?php echo _("Yes") ?></option>
                    </select>
                  </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                  <div class="input-group input-group-static mb-4">
                    <label for="ModalBSCompany"><?php echo _('Company'); ?></label>
                    <select id="ModalBSCompany" name="ModalBSCompany" class="form-control" required>
                      <?php
                      $sql = "SELECT companies.ID, companies.Companyname
                            FROM companies
                            ORDER BY Companyname ASC;";
                      $result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
                      while ($row = mysqli_fetch_array($result)) {
                        echo "<option value='" . $row['ID'] . "'>" . $row['Companyname'] . "</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <div class="input-group input-group-static mb-4">
                    <label for="ModalBSResponsible" class="ms-0"><?php echo _("Responsible"); ?><code>*</code></label>
                    <select id="ModalBSResponsible" name="ModalBSResponsible" class="form-control">
                      <option value=''></option>
                      <?php
                      $sql = "SELECT ID, CONCAT(users.Firstname,' ',users.Lastname) AS Fullname, users.username
                          FROM users
                          ORDER BY users.Firstname ASC, users.Lastname ASC;";
                      $result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
                      while ($row = mysqli_fetch_array($result)) {
                        $ReponsibleID = $row['ID'];
                        $Username = $row['username'];
                        $UserFullname = $row['Fullname'] . " (" . $Username . ")";
                        echo "<option value='$ReponsibleID'>$UserFullname</option>";
                      }
                      ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
              <button name="update" id="update" class="btn btn-sm btn-success float-end" onclick="updateBusinessService();"><?php echo _("Update"); ?></button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- End Modal Document Archive -->