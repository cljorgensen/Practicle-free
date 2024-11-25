<?php
include("./header.php");

set_time_limit(600);
ini_set('max_execution_time', 600);
?>
<?php
if (in_array("100001", $group_array)) {
} else {
    $CurrentPage = htmlspecialchars(basename($_SERVER['PHP_SELF']));
	notgranted($CurrentPage);
}
?>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card-group">
            <div class="card">
                <div class="card-header card-header"><i class="fa fa-cog fa-2x"></i><?php echo _("Import data"); ?></div>
                <div class="card-body">
                    <?php include("./administration_importdata_inc.php"); ?>
                    <form class="form-horizontal" action="" method="post" name="uploadCSV" enctype="multipart/form-data">
                        <div class="input-row">
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo _("Users") ?></label>
                                <label class="btn btn-sm btn-warning"><input type="file" name="file_users" id="file_users" accept=".csv"><?php echo _("Choose file"); ?></label>
                                <button class="btn btn-sm btn-success" type="submit" id="import_users" name="import_users" class="btn-submit">Import</button>
                                <button class="btn btn-sm btn-danger" type="submit" id="delete_users" name="delete_users" class="btn-submit" onclick="return confirm('Are you sure you want to reset installation, it cant be undone?')" onclick="return confirm('Are you sure you want to reset installation, it cant be undone?')">Empty table</button>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo _("Customers") ?></label>
                                <label class="btn btn-sm btn-warning"><input type="file" name="file_customers" id="file_customers" accept=".csv"><?php echo _("Choose file"); ?></label>
                                <button class="btn btn-sm btn-success" type="submit" id="import_customers" name="import_customers" class="btn-submit">Import</button>
                                <button class="btn btn-sm btn-danger" type="submit" id="delete_customers" name="delete_customers" class="btn-submit" onclick="return confirm('Are you sure you want to reset installation, it cant be undone?')" onclick="return confirm('Are you sure you want to reset installation, it cant be undone?')">Empty table</button>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo _("Companies") ?></label>
                                <label class="btn btn-sm btn-warning"><input type="file" name="file_companies" id="file_companies" accept=".csv"><?php echo _("Choose file"); ?></label>
                                <button class="btn btn-sm btn-success" type="submit" id="import_companies" name="import_companies" class="btn-submit">Import</button>
                                <button class="btn btn-sm btn-danger" type="submit" id="delete_companies" name="delete_companies" class="btn-submit" onclick="return confirm('Are you sure you want to reset installation, it cant be undone?')">Empty table</button>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo _("Teams") ?></label>
                                <label class="btn btn-sm btn-warning"><input type="file" name="file_teams" id="file_teams" accept=".csv"><?php echo _("Choose file"); ?></label>
                                <button class="btn btn-sm btn-success" type="submit" id="import_teams" name="import_teams" class="btn-submit">Import</button>
                                <button class="btn btn-sm btn-danger" type="submit" id="delete_teams" name="delete_teams" class="btn-submit" onclick="return confirm('Are you sure you want to reset installation, it cant be undone?')">Empty table</button>
                            </div>

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo _("Servers") ?></label>
                                <label class="btn btn-sm btn-warning"><input type="file" name="file_servers" id="file_servers" accept=".json"><?php echo _("Choose file"); ?></label>
                                <button class="btn btn-sm btn-success" type="submit" id="import_servers" name="import_servers" class="btn-submit"><?php echo _("Submit"); ?></button>
                                <button class="btn btn-sm btn-danger" type="submit" id="delete_servers" name="delete_servers" class="btn-submit" onclick="return confirm('Are you sure you want to delete all servers, it cant be undone?')"><?php echo _("Empty table"); ?></button>
                                <a href="./uploads/json/ci_servers.json" target="_blank" class="btn btn-sm btn-secondary"><?php echo _("Example") ?></a>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo _("Workstations") ?></label>
                                <label class="btn btn-sm btn-warning"><input type="file" name="file_workstations" id="file_workstations" accept=".json"><?php echo _("Choose file"); ?></label>
                                <button class="btn btn-sm btn-success" type="submit" id="import_workstations" name="import_workstations" class="btn-submit"><?php echo _("Submit"); ?></button>
                                <button class="btn btn-sm btn-danger" type="submit" id="delete_workstations" name="delete_workstations" class="btn-submit" onclick="return confirm('Are you sure you want to delete all workstations, it cant be undone?')"><?php echo _("Empty table"); ?></button>
                                <a href="./uploads/json/ci_workstations.json" target="_blank" class="btn btn-sm btn-secondary"><?php echo _("Example") ?></a>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo _("Handhelds") ?></label>
                                <label class="btn btn-sm btn-warning"><input type="file" name="file_handhelds" id="file_handhelds" accept=".json"><?php echo _("Choose file"); ?></label>
                                <button class="btn btn-sm btn-success" type="submit" id="import_handhelds" name="import_handhelds" class="btn-submit"><?php echo _("Submit"); ?></button>
                                <button class="btn btn-sm btn-danger" type="submit" id="delete_handhelds" name="delete_handhelds" class="btn-submit" onclick="return confirm('Are you sure you want to delete all handhelds, it cant be undone?')"><?php echo _("Empty table"); ?></button>
                                <a href="./uploads/json/ci_handhelds.json" target="_blank" class="btn btn-sm btn-secondary"><?php echo _("Example") ?></a>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo _("Subscriptions") ?></label>
                                <label class="btn btn-sm btn-warning"><input type="file" name="file_subscriptions" id="file_subscriptions" accept=".json"><?php echo _("Choose file"); ?></label>
                                <button class="btn btn-sm btn-success" type="submit" id="import_subscriptions" name="import_subscriptions" class="btn-submit"><?php echo _("Submit"); ?></button>
                                <button class="btn btn-sm btn-danger" type="submit" id="delete_subscriptions" name="delete_subscriptions" class="btn-submit" onclick="return confirm('Are you sure you want to delete all subscriptions, it cant be undone?')"><?php echo _("Empty table"); ?></button>
                                <a href="./uploads/json/ci_subscriptions.json" target="_blank" class="btn btn-sm btn-secondary"><?php echo _("Example") ?></a>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <label><?php echo _("Certificates") ?></label>
                                <label class="btn btn-sm btn-warning"><input type="file" name="file_certificates" id="file_certificates" accept=".json"><?php echo _("Choose file"); ?></label>
                                <button class="btn btn-sm btn-success" type="submit" id="import_certificates" name="import_certificates" class="btn-submit"><?php echo _("Submit"); ?></button>
                                <button class="btn btn-sm btn-danger" type="submit" id="delete_certificates" name="delete_certificates" class="btn-submit" onclick="return confirm('Are you sure you want to delete all certificates, it cant be undone?')"><?php echo _("Empty table"); ?></button>
                                <a href="./uploads/json/ci_certificates.json" target="_blank" class="btn btn-sm btn-secondary"><?php echo _("Example") ?></a>
                            </div>
                            <br>
                        </div>
                        <div id="labelError"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(
        function() {
            $("#frmCSVImport").on(
                "submit",
                function() {

                    $("#response").attr("class", "");
                    $("#response").html("");
                    var fileType = ".csv";
                    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(" +
                        fileType + ")$");
                    if (!regex.test($("#file").val().toLowerCase())) {
                        $("#response").addClass("error");
                        $("#response").addClass("display-block");
                        $("#response").html(
                            "Invalid File. Upload : <b>" + fileType +
                            "</b> Files.");
                        return false;
                    }
                    return true;
                });
        });
</script>

<?php include("./footer.php"); ?>