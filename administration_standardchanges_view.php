<?php include("./header.php"); ?>
<?php
$StandardChangeID = $_GET['stdchangeid'];
$RedirectPage = "administration_standardchanges_view.php?stdchangeid=" . $StandardChangeID;
$UserID = $_SESSION["id"];
$FieldName = "";
$FieldContent = "";
$FieldEntryID = "";

$sql = "SELECT ID, Name, Description, Created, CreatedBy, Active 
            FROM changes_standards
            WHERE ID = $StandardChangeID";

$result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));

while ($row = mysqli_fetch_array($result)) {
    $StandardChangeIDVal = $row['ID'];
    $Name = $row['Name'];
    $Description = $row['Description'];
    $Created = $row['Created'];
    $CreatedBy = $row['CreatedBy'];
    $Active = $row['Active'];
}
?>
<?php
if (isset($_POST['submit_new'])) {
    $FieldName = $_POST["FieldName"];
    $FieldContent = $_POST["FieldContent"];

    createFieldForStandardChangeTemplate($FieldName, $FieldContent, $StandardChangeID);
}
?>
<script>
    function deleteFieldEntry(fieldentryid) {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.open("GET", "getdata.php?deleteFieldEntry=" + fieldentryid, true);
        xmlhttp.send();
        location.reload(true);
    }

    function createNewFieldEntry() {

        var fieldname = document.getElementById('FieldName').value;
        var fieldcontent = document.getElementById('FieldContent').value;
        var relatedstdchangeid = '<?php echo $StandardChangeID ?>';

        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.open("GET", "getdata.php?createFieldEntry=" + fieldname + "&fieldcontent=" + fieldcontent + "&relatedstdchangeid=" + relatedstdchangeid, true);
        xmlhttp.send();
        location.reload(true);
    }
</script>

<div class="row">
    <div class="col-md-6 col-sm-6 col-xs-12">
        <div class="card-group">
            <div class="card">
                <div class="card-header card-header"><i class="fas fa-check-double fa-lg"></i> <a href="administration_standardchanges.php"><?php echo _("Standard Change"); ?> </a> <i class="fa fa-angle-right fa-sm"></i> <a href="administration_standardchanges_view.php?stdchangeid=<?php echo $StandardChangeID; ?>"><?php echo $Name; ?></a>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_POST['submit_update'])) {
                        $Name = $_POST['Name'];
                        $Description = $_POST['Description'];
                        $Active = $_POST['Active'];

                        updateStandardAnswerInformation($UserID, $StandardChangeIDVal, $Name, $Description, $Active);
                        echo "<script>pnotify('Standard change template updated', 'success');</script>";

                        $redirectpagego = "<meta http-equiv='refresh' content='0';url='$RedirectPage'>";
                        echo $redirectpagego;
                    }

                    if (isset($_POST['submit_delete'])) {

                        deleteStandardChange($UserID, $StandardChangeIDVal);
                        echo "<script>pnotify('Standard change template deleted', 'success');</script>";
                        $url = "administration_standardchanges.php";
                        $redirectpagego = "<meta http-equiv='refresh' content='0';url='$url'>";
                        echo $redirectpagego;
                    }
                    ?>
                    <form method="post">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo _("ID") ?></label>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input-group input-group-static mb-4">
                                <input type="text" class="form-control" id="StandardChangeID" name="StandardChangeID" value="<?php echo $StandardChangeID; ?>" readonly>
                            </div>
                        </div>

                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo _("Name") ?></label>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input-group input-group-static mb-4">
                                <input type="text" class="form-control" id="Name" name="Name" value="<?php echo $Name; ?>">
                            </div>
                        </div>

                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo _("Description") ?></label>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input-group input-group-static mb-4">
                                <textarea type="text" class="form-control" id="Description" name="Description" rows="15" required><?php echo $Description; ?></textarea>
                            </div>
                        </div>

                        <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo _("Active") ?></label>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <div class="input-group input-group-static mb-4">
                                <select class="form-control" id="Active" name="Active">
                                    <?php
                                    $sql = "SELECT ID, Active
                                    FROM changes_standards WHERE ID = $StandardChangeIDVal";
                                    $result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
                                    while ($row = mysqli_fetch_array($result)) {
                                        $Active = $row['Active'];
                                        if ($Active == 1) {
                                            echo "<option value='1' selected='select'>Active</option>";
                                            echo "<option value='0'>Not Active</option>";
                                        } else {
                                            echo "<option value='1'>Active</option>";
                                            echo "<option value='0' selected='select'>Not Active</option>";
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php
                        if (in_array("100001", $group_array) || in_array("100009", $group_array)) {

                            echo "<div class='col-md-12 col-sm-12 col-xs-12'>
                        <button type='submit' name='submit_update' class='btn btn-sm btn-success float-end'>" ?><?php echo _('Update'); ?><?php echo "</button></div";
                                                                                                                                            echo "<div class='col-md-12 col-sm-12 col-xs-12'>
                        <button type='submit' name='submit_delete' class='btn btn-sm btn-danger float-end' onclick=\"return confirm('Are you sure?');\"><i class='fas fa-trash'></i>" ?><?php echo " " . _('Delete'); ?><?php echo "</button></div";
                                                                                                                                                                                                                    } else {
                                                                                                                                                                                                                    }
                                                                                                                                                                                                                        ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
        <div class="card-group">
            <div class="card">
                <div class="card-header card-header"><i class="fas fa-plus fa-lg"></i> <?php echo _("Add"); ?>
                </div>
                <div class="card-body">
                    <label class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo _("Field Name"); ?></label>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="input-group input-group-static mb-4">
                            <input type="text" class="form-control" id="FieldName" name="FieldName" autocomplete="off" required>
                        </div>
                    </div>

                    <label class="control-label col-md-12 col-sm-12 col-xs-12"><?php echo _("Content"); ?></label>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="input-group input-group-static mb-4">
                            <textarea type="text" class="form-control" id="FieldContent" name="FieldContent" rows="15" autocomplete="off" required></textarea>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <button type="submit" class="btn btn-sm btn-success float-end" onclick="createNewFieldEntry();"><?php echo _("Create"); ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-group">
            <div class="card">
                <div class="card-header card-header"><i class="fas fa-check-double fa-lg"></i> <?php echo _("Fields"); ?></a>
                </div>
                <div class="card-body">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <table id="TableStandardChanges" class="table table-responsive table-borderless table-hover" cellspacing="0">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th><?php echo _("Field Name") ?></th>
                                    <th><?php echo _("Content") ?></th>
                                </tr>
                            </thead>
                            <?php

                            $sql = "SELECT ID AS FieldEntryID, RelatedStdChangeID, FieldName, FieldContent 
                            FROM changes_standard_fields 
                            WHERE RelatedStdChangeID = $StandardChangeID";

                            $result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
                            ?>
                            <tbody>
                                <?php while ($row = mysqli_fetch_array($result)) { ?>
                                    <?php $FieldEntryID = $row['FieldEntryID'] ?>
                                    <?php $StandardChangeID = $row['RelatedStdChangeID'] ?>
                                    <tr class='text-sm text-secondary mb-0'>
                                        <td>
                                            <a href="javascript:void(0);" onclick="deleteFieldEntry('<?php echo $FieldEntryID ?>');"><span class='badge badge-pill bg-gradient-danger'><i class='fa fa-trash'></i></span></a>
                                        </td>
                                        <td><?php echo $row['FieldName']; ?></td>
                                        <td><?php echo $row['FieldContent']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("./footer.php"); ?>