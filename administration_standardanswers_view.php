<?php include("./header.php"); ?>
<?php
$StandardAnswerID = $_GET['answerid'];
$RedirectPage = "administration_standardanswers_view.php?answerid=" . $StandardAnswerID;
$UserID = $_SESSION["id"];
$sql = "SELECT ID, Name, RelatedModuleID, Answer, Active 
        FROM standardanswers 
        WHERE ID = $StandardAnswerID";

$result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
while ($row = mysqli_fetch_array($result)) {
    $IDVal = $row['ID'];
    $NameVal = $row['Name'];
    $RelatedModuleIDVal = $row['RelatedModuleID'];
    $AnswerVal = $row['Answer'];
    $ActiveVal = $row['Active'];
}
?>
<script>
    $(document).ready(function() {
        <?php initiateSimpleTrumbowyg("AnswerVal") ?>
    });
</script>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card-group">
            <div class="card">
                <div class="card-header card-header"><i class="fas fa-comment-dots fa-lg"></i> <a href="administration_standardanswers.php"><?php echo _("Standard Answers"); ?> </a> <i class="fa fa-angle-right fa-sm"></i> <a href="administration_standardanswers_view.php?answerid=<?php echo $StandardAnswerID; ?>"><?php echo $NameVal; ?></a>
                </div>
                <div class="card-body">
                    <?php
                    if (isset($_POST['submit_updatestandard_answer'])) {

                        $AnswerID = $_POST['StandardAnswerID'];
                        $NameVal = $_POST['NameVal'];
                        $AnswerVal = $_POST['AnswerVal'];
                        $RelatedModuleIDVal = $_POST['RelatedModuleIDVal'];
                        $ActiveVal = $_POST['ActiveVal'];

                        updateStandardAnswerInformation($UserID, $AnswerID, $NameVal, $AnswerVal, $RelatedModuleIDVal, $ActiveVal);
                        echo "<script>localStorage . setItem('pnotify', 'Updated')</script>";
                        echo "<script>window.location.href = '$RedirectPage';</script>";
                    }
                    ?>

                    <form method="post">
                        <div class="row">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo _("ID"); ?></label>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input-group input-group-static mb-4">
                                    <input type="text" class="form-control" id="StandardAnswerID" name="StandardAnswerID" value="<?php echo $StandardAnswerID; ?>" readonly>
                                </div>
                            </div>

                            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo _("Name"); ?></label>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input-group input-group-static mb-4">
                                    <input type="text" class="form-control" id="NameVal" name="NameVal" value="<?php echo $NameVal; ?>">
                                </div>
                            </div>

                            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo _("Answer Text"); ?></label>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input-group input-group-static mb-4">
                                    <textarea type="text" class="form-control" id="AnswerVal" name="AnswerVal" rows="15" required><?php echo $AnswerVal; ?></textarea>
                                </div>
                            </div>

                            <label class="control-label col-md-4 col-sm-4 col-xs-12"><?php echo _("Related Module"); ?></label>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input-group input-group-static mb-4">
                                    <select class="form-control" id="RelatedModuleIDVal" name="RelatedModuleIDVal">
                                        <?php
                                        $sql = "SELECT ID, Name
                                                FROM Modules
                                                WHERE Active = 1 AND ID IN (1,2,3,4)";
                                        $result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
                                        while ($row = mysqli_fetch_array($result)) {
                                            $Name = _($row['Name']);
                                            $ID = _($row['ID']);
                                            if ($RelatedModuleIDVal == $row['ID']) {
                                                echo "<option value='$ID' selected='select'>$Name</option>";
                                            } else {
                                                echo "<option value='$ID'>$Name</option>";
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <label class="control-label col-md-3 col-sm-3 col-xs-12"><?php echo _("Status"); ?></label>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="input-group input-group-static mb-4">
                                    <select class="form-control" id="ActiveVal" name="ActiveVal">
                                        <?php
                                        $sql = "SELECT ID, Active
                                    FROM standardanswers WHERE ID = $IDVal";
                                        $result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
                                        while ($row = mysqli_fetch_array($result)) {
                                            if ($ActiveVal == True) {
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
                        </div>
                        <div class="row">
                            <?php
                            if (in_array("100001", $group_array)) {
                                echo "<div class='col-md-12 col-sm-12 col-xs-12'>
                                <button type='submit' name='submit_updatestandard_answer' class='btn btn-sm btn-success float-end' onclick='updateNotes()'>" ?><?php echo _('Update'); ?><?php echo "</button></div";
                                                                                                                                                                                        } else {
                                                                                                                                                                                        }
                                                                                                                                                                                            ?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include("./footer.php"); ?>