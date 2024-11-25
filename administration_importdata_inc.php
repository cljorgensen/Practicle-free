<?php
if (in_array("100001", $group_array)) {
} else {
    $CurrentPage = htmlspecialchars(basename($_SERVER['PHP_SELF']));
	notgranted($CurrentPage);
}
?>
<?php
if (isset($_POST["import_users"])) {

    $fileName = $_FILES["file_users"]["tmp_name"];

    if ($_FILES["file_users"]["size"] > 0) {

        $file = fopen($fileName, "r");

        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
            $sql = "INSERT INTO users(Firstname, Lastname, Email, Username, Created_Date, CompanyID, RelatedUserTypeID, JobTitel, LinkedIn, Phone, Birthday, StartDate) 
                VALUES ('$column[0]','$column[1]','$column[2]','$column[3]','$column[4]',$column[5],'2',$column[6],$column[7],$column[8],'$column[9]','$column[10]')";

            $result = mysqli_query($conn, $sql);

            if (!empty($result)) {
                $type = "success";
                $message = "User CSV Data Imported into the Database";
            } else {
                $type = "error";
                $message = "Problem in Importing CSV Data";
            }
        }
    }
}
if (isset($_POST["delete_users"])) {
    $sql = "DELETE FROM users WHERE ID NOT BETWEEN 1 AND 100 and RelatedUserTypeID = 1";
    $sql2 = "ALTER TABLE users AUTO_INCREMENT = 100";
    mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
    mysqli_query($conn, $sql2) or die('Query fail: ' . mysqli_error($conn));
}
?>
    <?php
    if (isset($_POST["import_customers"])) {

        $fileName = $_FILES["file_customers"]["tmp_name"];

        if ($_FILES["file_customers"]["size"] > 0) {

            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sql = "INSERT INTO users(Firstname, Lastname, Email, Username, Created_Date, CompanyID, RelatedUserTypeID, JobTitel, LinkedIn, Phone, Birthday, StartDate) 
                VALUES ('$column[0]','$column[1]','$column[2]','$column[3]','$column[4]',$column[5],'2',$column[6],$column[7],'$column[8]','$column[9]',$column[10])";

                $result = mysqli_query($conn, $sql);

                if (!empty($result)) {
                    $type = "success";
                    $message = "Customer CSV Data Imported into the Database";
                    echo "<script type='text/javascript'>pnotify('Customer CSV Data Imported into the Database','success');</script>";
                } else {
                    $type = "error";
                    $message = "Problem with Importing CSV Data";
                    echo "<script type='text/javascript'>pnotify('Problem with Importing CSV Data','error');</script>";
                }
            }
        }
    }
    if (isset($_POST["delete_customers"])) {
        $sql = "DELETE FROM users WHERE RelatedUserTypeID = 2";
        $sql2 = "ALTER TABLE users AUTO_INCREMENT = 100";
        mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
        mysqli_query($conn, $sql2) or die('Query fail: ' . mysqli_error($conn));
    }
    ?>
    <?php
    if (isset($_POST["import_companies"])) {

        $fileName = $_FILES["file"]["tmp_name"];

        if ($_FILES["file"]["size"] > 0) {

            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sql = "INSERT INTO companies(Companyname, WebPage, Phone, RelatedSLAID, CustomerAccountNumber, Address, ZipCode, City, Email, CBR, Country, Notes) 
                VALUES ('$column[0]','$column[1]','$column[2]','$column[3]','$column[4]',$column[5],$column[6],$column[7],'$column[8]','$column[9]',$column[10],$column[11])";

                $result = mysqli_query($conn, $sql);

                if (!empty($result)) {
                    $type = "success";
                    $message = "Companies CSV Data Imported into the Database";
                } else {
                    $type = "error";
                    $message = "Problem in Importing CSV Data";
                }
            }
        }
    }
    if (isset($_POST["delete_companies"])) {
        $sql = "DELETE FROM companies WHERE ID != 1";
        $sql2 = "ALTER TABLE companies AUTO_INCREMENT = 1";
        mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
        mysqli_query($conn, $sql2) or die('Query fail: ' . mysqli_error($conn));
    }
    ?>
    <?php
    if (isset($_POST["import_teams"])) {

        $fileName = $_FILES["file_teams"]["tmp_name"];

        if ($_FILES["file_teams"]["size"] > 0) {

            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sql = "INSERT INTO teams(Teamname, ADUUID, Colour, TeamLeader, Description) 
                VALUES ('$column[0]','$column[1]','$column[2]','$column[3]','$column[4]',$column[5])";

                $result = mysqli_query($conn, $sql);

                if (!empty($result)) {
                    $type = "success";
                    $message = "Team CSV Data Imported into the Database";
                } else {
                    $type = "error";
                    $message = "Problem in Importing CSV Data";
                }
            }
        }
    }
    if (isset($_POST["delete_teams"])) {
        $sql = "DELETE FROM teams";
        $sql2 = "ALTER TABLE teams AUTO_INCREMENT = 0";
        mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
        mysqli_query($conn, $sql2) or die('Query fail: ' . mysqli_error($conn));
    }
    ?>
    <?php
    if (isset($_POST["import_companies"])) {

        $fileName = $_FILES["file_companies"]["tmp_name"];

        if ($_FILES["file_companies"]["size"] > 0) {

            $file = fopen($fileName, "r");

            while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
                $sql = "INSERT INTO users(Companyname, WebPage, Phone, RelatedSLAID, CustomerAccountNumber, Address, ZipCode, City, Email, CBR, Country, Notes) 
                VALUES ('$column[0]','$column[1]','$column[2]','$column[3]','$column[4]',$column[5],$column[6],$column[7],'$column[8]','$column[9]',$column[10],$column[11])";

                $result = mysqli_query($conn, $sql);

                if (!empty($result)) {
                    $type = "success";
                    $message = "Companies CSV Data Imported into the Database";
                } else {
                    $type = "error";
                    $message = "Problem in Importing CSV Data";
                }
            }
        }
    }
    if (isset($_POST["delete_companies"])) {
        $sql = "DELETE FROM companies WHERE ID != 1";
        $sql2 = "ALTER TABLE companies AUTO_INCREMENT = 1";
        mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
        mysqli_query($conn, $sql2) or die('Query fail: ' . mysqli_error($conn));
    }
    ?>

<?php
if (isset($_POST["import_servers"])) {
    $fname = "./uploads/json/ci_servers.csv";

    if(file_exists("./uploads/json/ci_servers.csv")){
        if (!($fp = fopen($fname, 'r'))) {
            return;
        }
        else{
            //read csv headers
            $key = fgetcsv($fp, "1024", ",");

            // parse csv rows into array
            $json = array();
            while ($row = fgetcsv($fp, "1024", ",")) {
                $json[] = array_combine($key, $row);
            }

            // release file handle
            fclose($fp);

            // encode array to json
            foreach ($json as $row) {
                $Hostname = $row["VM"];
                if (empty($Hostname)) {
                } else {
                    $ModelNo = $row["ModelNo"];
                    if(empty($ModelNo)){
                        $ModelNo = "";
                    };
                    $Description = $row["Desc"];
                    if (empty($Description)) {
                        $Description = "";
                    };
                    $Ram = $row["RAM"];
                    if (empty($Ram)) {
                        $Ram = "";
                    };
                    $CPU = $row["CPU"];
                    if (empty($CPU)) {
                        $CPU = "";
                    };
                    $Domain = $row["Domain"];
                    if (empty($Domain)) {
                        $Domain = "";
                    };
                    $FQDN = $row["FQDN"];
                    if (empty($FQDN)) {
                        $FQDN = "";
                    };
                    $Tier1 = $row["Tier1"];
                    if (empty($Tier1)) {
                        $Tier1 = 0;
                    };
                    $Tier2 = $row["Tier2"];
                    if (empty($Tier2)) {
                        $Tier2 = 0;
                    };
                    $Tier3 = $row["Tier3"];
                    if (empty($Tier3)) {
                        $Tier3 = 0;
                    };
                    
                    $Harddiskspace = $Tier1 + $Tier2 + $Tier3;
                    $RelatedProducerID = $row["RelatedProducerID"];
                    if (empty($RelatedProducerID)) {
                        $RelatedProducerID = "28";
                    };
                    $RelatedOS = $row["OS"];
                    if (empty($RelatedOS)) {
                        $RelatedOSID = "20";
                    }
                    else{
                        if(str_contains($RelatedOS, 'Windows')){
                            $RelatedOSID = "21";
                        }
                        else {
                            $RelatedOSID = "22";
                        }
                    }
                    $RelatedTypeID = $row["RelatedTypeID"];
                    if (empty($RelatedTypeID)) {
                        $RelatedTypeID = "3";
                    };

                    $StartDate = date("Y-m-d H:m:s");
                    $Expires = date("2025-01-01 08:00:00");
                    $CreatedBy = "1";
                    $RelatedUserID = "1";
                    $Active = "1";
                    $json[] = array('Hostname' => $Hostname, 'Description' => $Description, 'ModelNo' => $ModelNo, 'Ram' => $Ram, 'CPU' => $CPU,'Domain' => $Domain,'FQDN' => $FQDN, 'Harddiskspace' => $Harddiskspace, 'RelatedProducerID' => $RelatedProducerID, 'RelatedOSID' => $RelatedOSID, 'RelatedTypeID' => $RelatedTypeID, 'StartDate' => $StartDate, 'Expires' => $Expires, 'CreatedBy' => $CreatedBy, 'RelatedUserID' => $RelatedUserID, 'Active' => $Active,);
                }
            }
        }
        $jsondata = json_encode($json);
    }
    if(empty($jsondata)){
        $jsondata = file_get_contents('./uploads/json/ci_servers.json');
        $data = json_decode($jsondata, true);
    }else{
        $data = json_decode($jsondata, true);
    }
    foreach ($data as $row) {
        
        $Name = $row["Hostname"];
        if (empty($Name)) {
        } else {

            $ModelNo = $row["ModelNo"];
            $Ram = $row["Ram"];
            $Description = $row["Description"];
            $CPU = $row["CPU"];
            $Domain = $row["Domain"];
            $FQDN = $row["FQDN"];
            $Harddiskspace = $row["Harddiskspace"];
            $RelatedProducerID = $row["RelatedProducerID"];
            $RelatedOSID = $row["RelatedOSID"];
            $RelatedTypeID = $row["RelatedTypeID"];
            $StartDate = $row["StartDate"];
            $Expires = $row["Expires"];
            $CreatedBy = $row["CreatedBy"];
            $RelatedUserID = $row["RelatedUserID"];
            $Active = $row["Active"];

            $exists = checkifServerExists($Name, $ModelNo);

            $mysqli = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);
            
            if ($exists == 1) {
                if (mysqli_connect_errno()) {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit();
                }

                $sql = "UPDATE cis SET RelatedUserID='$RelatedUserID', RelatedCompanyID='1', StartDate='$StartDate', Expires='$Expires', Active=$Active, CreatedBy='$CreatedBy' WHERE cis.Name = '$Name';
                        UPDATE ci_servers SET Ram='$Ram', Description='$Description',CPU='$CPU', Domain='$Domain', FQDN='$FQDN', Harddiskspace='$Harddiskspace', RelatedProducerID='$RelatedProducerID', RelatedOSID='$RelatedOSID', RelatedTypeID='$RelatedTypeID' WHERE ci_servers.Hostname = '$Name';";
                if ($mysqli->multi_query($sql)) {
                    do {
                        if ($result = $mysqli->store_result()) {
                            while ($row = $result->fetch_row()) {
                                printf("%s\n", $row[0]);
                            }
                            $result->free();
                        }
                        if ($mysqli->more_results()) {
                        }
                    } while ($mysqli->next_result());
                }
                echo "Server: $Name with ModelNo: $ModelNo exists -> server updated<br>";
            } else {
                if (mysqli_connect_errno()) {
                    printf("Connect failed: %s\n", mysqli_connect_error());
                    exit();
                }

                $sql = "INSERT INTO cis(Name, RelatedClassID, RelatedCompanyID, RelatedUserID, StartDate, Expires, Active, Removed, Created, CreatedBy) VALUES ('$Name',1,2,$RelatedUserID,DATE_SUB(NOW(),INTERVAL 1 DAY),DATE_ADD(Now(), INTERVAL 1 YEAR),1,0,Now(),1);
                        INSERT INTO ci_servers(RelatedCI, Description, ModelNo, Ram, CPU, Domain, FQDN, Harddiskspace, Hostname, RelatedProducerID, RelatedOSID, RelatedTypeID) VALUES (LAST_INSERT_ID(),'$Description','$ModelNo',$Ram,'$CPU','$Domain','$FQDN','$Harddiskspace','$Name',$RelatedProducerID,$RelatedOSID,$RelatedTypeID);";
                $sqldebug = str_replace("'","#", $sql);

                if ($mysqli->multi_query($sql)) {
                    do {
                        if ($result = $mysqli->store_result()) {
                            while ($row = $result->fetch_row()) {
                                printf("%s\n", $row[0]);
                            }
                            $result->free();
                        }
                        if ($mysqli->more_results()) {
                        }
                    } while ($mysqli->next_result());
                }
                echo "Server: $Name with ModelNo: $ModelNo didnt exist -> server imported<br>";
            }
        }
    }

    //Set servers not found inactive
    $sql = "SELECT Hostname, RelatedCI
            FROM ci_servers
            LEFT JOIN cis ON ci_servers.RelatedCI = cis.ID
            WHERE cis.Active != '0'";

    $result = mysqli_query($conn, $sql) or die('Query fail: ' . mysqli_error($conn));
    while ($row = mysqli_fetch_array($result)) {
        $Hostname = $row['Hostname'];
        $RelatedCI = $row['RelatedCI'];
        $exist = searchForHostname($Hostname, $data);
        if(empty($exist)){
            setServerInactive($RelatedCI);
        }
    }

    echo "<script type='text/javascript'>pnotify('Server Data Imported into the Database','success');</script>";

}

function searchForHostname($Hostname, $array)
{
    foreach ($array as $key => $val) {
        if ($val['Hostname'] === "$Hostname") {
            return $key;
        }
    }
    return null;
}

if (isset($_POST["delete_servers"])) {
    deleteAllServers();
    echo "<script type='text/javascript'>pnotify('Servers deleted','success');</script>";
}
?>

<?php
if (isset($_POST["import_workstations"])) {

    $jsondata = file_get_contents('./uploads/json/ci_workstations.json');

    if (!empty($jsondata)) {
        $data = json_decode($jsondata, true);

        foreach ($data as $row) {
            $Name = $row["Hostname"];
            if (empty($Name)) {
            } else {
                $ModelNo = $row["ModelNo"];
                $Ram = $row["Ram"];
                $CPU = $row["CPU"];
                $Harddiskspace = $row["Harddiskspace"];
                $RelatedProducerID = $row["RelatedProducerID"];
                $RelatedOSID = $row["RelatedOSID"];
                $RelatedTypeID = $row["RelatedTypeID"];
                $StartDate = $row["StartDate"];
                $Expires = $row["Expires"];
                $CreatedBy = $row["CreatedBy"];
                $RelatedUserID = $row["RelatedUserID"];
                $Active = $row["Active"];

                $exists = checkifWorkstationsExists($Name, $ModelNo);

                if ($exists == 1) {

                    $mysqli = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

                    if (mysqli_connect_errno()) {
                        printf("Connect failed: %s\n", mysqli_connect_error());
                        exit();
                    }

                    $sql = "UPDATE cis SET RelatedUserID='$RelatedUserID', StartDate='$StartDate', Expires='$Expires', Active=$Active, CreatedBy='$CreatedBy' WHERE cis.Name = '$Name';
                            UPDATE ci_workstations SET Ram='$Ram', CPU='$CPU', Harddiskspace='$Harddiskspace', RelatedProducerID='$RelatedProducerID', RelatedOSID='$RelatedOSID', RelatedTypeID='$RelatedTypeID' WHERE ci_workstations.Hostname = '$Name';";

                    if ($mysqli->multi_query($sql)) {
                        do {
                            if ($result = $mysqli->store_result()) {
                                while ($row = $result->fetch_row()) {
                                    printf("%s\n", $row[0]);
                                }
                                $result->free();
                            }
                            if ($mysqli->more_results()) {
                            }
                        } while ($mysqli->next_result());
                    }
                    echo "Workstation with name: $Name AND with ModelNo: $ModelNo exists -> server updated<br>";
                } else {

                    $mysqli = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

                    if (mysqli_connect_errno()) {
                        printf("Connect failed: %s\n", mysqli_connect_error());
                        exit();
                    }

                    $sql = "INSERT INTO cis(Name, RelatedClassID, RelatedCompanyID, RelatedUserID, StartDate, Expires, Active, Removed, Created, CreatedBy) VALUES ('$Name',2,1,$RelatedUserID,DATE_SUB(NOW(),INTERVAL 1 DAY),DATE_ADD(Now(), INTERVAL 1 YEAR),1,0,Now(),1);
                            INSERT INTO ci_workstations(RelatedCI, ModelNo, Ram, CPU, Harddiskspace, Hostname, RelatedProducerID, RelatedOSID, RelatedTypeID) VALUES (LAST_INSERT_ID(),'$ModelNo',$Ram,'$CPU','$Harddiskspace','$Name',$RelatedProducerID,$RelatedOSID,$RelatedTypeID);";

                    $sqldebug = str_replace("'", "-", $sql);

                    if ($mysqli->multi_query($sql)) {
                        do {
                            if ($result = $mysqli->store_result()) {
                                while ($row = $result->fetch_row()) {
                                    printf("%s\n", $row[0]);
                                }
                                $result->free();
                            }
                            if ($mysqli->more_results()) {
                                printf("Workstation: $Name created<br>");
                            }
                        } while ($mysqli->next_result());
                    }
                }
            }
        }

        echo "<script type='text/javascript'>pnotify('Workstation Data Imported into the Database','success');</script>";
    }
}
if (isset($_POST["delete_workstations"])) {

    $sql = "DELETE FROM cis WHERE RelatedClassID = 2;
            ALTER TABLE ci_workstations AUTO_INCREMENT = 1";
    $result = mysqli_multi_query($conn, $sql) or die(mysqli_error($conn));
    echo "<script type='text/javascript'>pnotify('Workstations deleted','success');</script>";
}
?>

<?php
if (isset($_POST["import_handhelds"])) {

    $jsondata = file_get_contents('./uploads/json/ci_handhelds.json');

    if (!empty($jsondata)) {
        $data = json_decode($jsondata, true);

        foreach ($data as $row) {
            $Name = $row["Name"];
            if (empty($Name)) {
            } else {
                $ModelNo = $row["ModelNo"];
                $SerialNumber = $row["SerialNumber"];
                $RelatedProducerID = $row["RelatedProducerID"];
                $RelatedTypeID = $row["RelatedTypeID"];
                $StartDate = $row["StartDate"];
                $Expires = $row["Expires"];
                $CreatedBy = $row["CreatedBy"];
                $RelatedUserID = $row["RelatedUserID"];
                $Active = $row["Active"];

                $exists = checkifHandheldsExists($ModelNo, $SerialNumber);
                if ($exists == 1) {

                    $mysqli = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

                    if (mysqli_connect_errno()) {
                        printf("Connect failed: %s\n", mysqli_connect_error());
                        exit();
                    }

                    $sql = "UPDATE cis SET Name='$Name',RelatedUserID='$RelatedUserID', StartDate='$StartDate', Expires='$Expires', Active=$Active, CreatedBy='$CreatedBy' WHERE cis.Name = '$Name';
                            UPDATE ci_handhelds SET SerialNumber='$SerialNumber', ModelNo='$ModelNo', RelatedProducerID='$RelatedProducerID', RelatedTypeID='$RelatedTypeID' WHERE ci_handhelds.SerialNumber = '$SerialNumber';";

                    if ($mysqli->multi_query($sql)) {
                        do {
                            if ($result = $mysqli->store_result()) {
                                while ($row = $result->fetch_row()) {
                                    printf("%s\n", $row[0]);
                                }
                                $result->free();
                            }
                            if ($mysqli->more_results()) {
                            }
                        } while ($mysqli->next_result());
                    }
                    echo "Handheld device named: $Name, with ModelNo: $ModelNo and SerialNumber: $SerialNumber exists -> handheld updated<br>";
                } else {

                    $mysqli = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

                    if (mysqli_connect_errno()) {
                        printf("Connect failed: %s\n", mysqli_connect_error());
                        exit();
                    }

                    $sql = "INSERT INTO cis(Name, RelatedClassID, RelatedCompanyID, RelatedUserID, StartDate, Expires, Active, Removed, Created, CreatedBy) VALUES ('$Name',3,1,$RelatedUserID,DATE_SUB(NOW(),INTERVAL 1 DAY),DATE_ADD(Now(), INTERVAL 1 YEAR),1,0,Now(),1);
                            INSERT INTO ci_handhelds(RelatedCI, ModelNo, SerialNumber, RelatedProducerID, RelatedTypeID) VALUES (LAST_INSERT_ID(),'$ModelNo','$SerialNumber',$RelatedProducerID,$RelatedTypeID);";

                    if ($mysqli->multi_query($sql)) {
                        do {
                            if ($result = $mysqli->store_result()) {
                                while ($row = $result->fetch_row()) {
                                    printf("%s\n", $row[0]);
                                }
                                $result->free();
                            }
                            if ($mysqli->more_results()) {
                                printf("Handheld: $Name created<br>");
                            }
                        } while ($mysqli->next_result());
                    }
                }
            }
        }
        echo "<script type='text/javascript'>pnotify('Handheld Data Imported into the Database','success');</script>";
    }
}


if (isset($_POST["delete_handhelds"])) {

    $sql = "DELETE FROM cis WHERE RelatedClassID = 3;
            ALTER TABLE ci_handhelds AUTO_INCREMENT = 1";
    $result = mysqli_multi_query($conn, $sql) or die(mysqli_error($conn));
    echo "<script type='text/javascript'>pnotify('Workstations deleted','success');</script>";
}
?>

<?php
if (isset($_POST["import_subscriptions"])) {

    $jsondata = file_get_contents('./uploads/json/ci_subscriptions.json');

    if (!empty($jsondata)) {
        $data = json_decode($jsondata, true);

        foreach ($data as $row) {
            $Name = $row["Name"];
            if (empty($Name)) {
            } else {
                $MobilePhoneNumber = $row["MobilePhoneNumber"];
                $SIM = $row["SIM"];
                $IMEI = $row["IMEI"];
                $SubscriptionFirm = $row["SubscriptionFirm"];
                $SubscriptionType = $row["SubscriptionType"];
                $StartDate = $row["StartDate"];
                $Expires = $row["Expires"];
                $CreatedBy = $row["CreatedBy"];
                $RelatedUserID = $row["RelatedUserID"];
                $Active = $row["Active"];

                $exists = checkifSubscriptionExists($MobilePhoneNumber, $SIM);
                if ($exists == 1) {

                    $mysqli = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

                    if (mysqli_connect_errno()) {
                        printf("Connect failed: %s\n", mysqli_connect_error());
                        exit();
                    }

                    $sql = "UPDATE cis SET Name='$Name',RelatedUserID='$RelatedUserID', StartDate='$StartDate', Expires='$Expires', Active=$Active, CreatedBy='$CreatedBy' WHERE cis.Name = '$Name';
                            UPDATE ci_mobilesubscriptions SET MobilePhoneNumber='$MobilePhoneNumber', SIM='$SIM', SubscriptionFirm='$SubscriptionFirm', SubscriptionType='$SubscriptionType' WHERE ci_mobilesubscriptions.MobilePhoneNumber = '$MobilePhoneNumber';";

                    if ($mysqli->multi_query($sql)) {
                        do {
                            if ($result = $mysqli->store_result()) {
                                while ($row = $result->fetch_row()) {
                                    printf("%s\n", $row[0]);
                                }
                                $result->free();
                            }
                            if ($mysqli->more_results()) {
                            }
                        } while ($mysqli->next_result());
                    }
                    echo "Mobile Subscription named: $Name, with MobilePhoneNumber: $MobilePhoneNumber and SIM: $SIM exists -> Subscription updated<br>";
                } else {

                    $mysqli = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

                    if (mysqli_connect_errno()) {
                        printf("Connect failed: %s\n", mysqli_connect_error());
                        exit();
                    }

                    $sql = "INSERT INTO cis(Name, RelatedClassID, RelatedCompanyID, RelatedUserID, StartDate, Expires, Active, Removed, Created, CreatedBy) VALUES ('$Name',6,1,$RelatedUserID,DATE_SUB(NOW(),INTERVAL 1 DAY),DATE_ADD(Now(), INTERVAL 1 YEAR),1,0,Now(),1);
                            INSERT INTO ci_mobilesubscriptions(RelatedCI, SubscriptionFirm, MobilePhoneNumber, SIM, IMEI, SubscriptionType) VALUES (LAST_INSERT_ID(),$SubscriptionFirm,'$MobilePhoneNumber','$SIM','$IMEI',$SubscriptionType);";

                    if ($mysqli->multi_query($sql)) {
                        do {
                            if ($result = $mysqli->store_result()) {
                                while ($row = $result->fetch_row()) {
                                    printf("%s\n", $row[0]);
                                }
                                $result->free();
                            }
                            if ($mysqli->more_results()) {
                                printf("Subscrition: $Name created<br>");
                            }
                        } while ($mysqli->next_result());
                    }
                }
            }
        }
        echo "<script type='text/javascript'>pnotify('Subscription Data Imported into the Database','success');</script>";
    }
}
if (isset($_POST["delete_subscriptions"])) {
    $sql = "DELETE FROM cis WHERE RelatedClassID = 6;
            ALTER TABLE ci_mobilesubscriptions AUTO_INCREMENT = 1";
    $result = mysqli_multi_query($conn, $sql) or die(mysqli_error($conn));
    echo "<script type='text/javascript'>pnotify('Workstations deleted','success');</script>";
}
?>

<?php
if (isset($_POST["import_certificates"])) {

    $jsondata = file_get_contents('./uploads/json/ci_certificates.json');

    if (!empty($jsondata)) {
        $data = json_decode($jsondata, true);

        foreach ($data as $row) {
            $Name = $row["Name"];
            if (empty($Name)) {
            } else {
                $RelatedServerID = $row["RelatedServerID"];
                $CertType = $row["CertType"];
                $StartDate = $row["StartDate"];
                $Expires = $row["Expires"];
                $CreatedBy = $row["CreatedBy"];
                $RelatedUserID = $row["RelatedUserID"];
                $Active = $row["Active"];

                $exists = checkifCertificateExists($Name, $Active);
                if ($exists == 1) {

                    $mysqli = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

                    if (mysqli_connect_errno()) {
                        printf("Connect failed: %s\n", mysqli_connect_error());
                        exit();
                    }

                    $sql = "UPDATE cis SET Name='$Name',RelatedUserID='$RelatedUserID', StartDate='$StartDate', Expires='$Expires', Active=$Active, CreatedBy='$CreatedBy' WHERE cis.Name = '$Name';
                            UPDATE ci_certificates SET CertName='$Name', RelatedServerID='$RelatedServerID', CertType='$CertType' WHERE ci_certificates.CertName = '$Name';";

                    if ($mysqli->multi_query($sql)) {
                        do {
                            if ($result = $mysqli->store_result()) {
                                while ($row = $result->fetch_row()) {
                                    printf("%s\n", $row[0]);
                                }
                                $result->free();
                            }
                            if ($mysqli->more_results()) {
                            }
                        } while ($mysqli->next_result());
                    }
                    echo "Certificate named: $Name exists -> Certificate updated<br>";
                } else {

                    $mysqli = new mysqli($dbservername, $dbusername, $dbpassword, $dbname);

                    if (mysqli_connect_errno()) {
                        printf("Connect failed: %s\n", mysqli_connect_error());
                        exit();
                    }

                    $sql = "INSERT INTO cis(Name, RelatedClassID, RelatedCompanyID, RelatedUserID, StartDate, Expires, Active, Removed, Created, CreatedBy) VALUES ('$Name',4,1,$RelatedUserID,DATE_SUB(NOW(),INTERVAL 1 DAY),DATE_ADD(Now(), INTERVAL 1 YEAR),1,0,Now(),1);
                            INSERT INTO ci_certificates(RelatedCI, CertName, RelatedServerID, CertType) VALUES (LAST_INSERT_ID(),'$Name',$RelatedServerID,'$CertType');";

                    if ($mysqli->multi_query($sql)) {
                        do {
                            if ($result = $mysqli->store_result()) {
                                while ($row = $result->fetch_row()) {
                                    printf("%s\n", $row[0]);
                                }
                                $result->free();
                            }
                            if ($mysqli->more_results()) {
                                printf("Certificate: $Name created<br>");
                            }
                        } while ($mysqli->next_result());
                    }
                }
            }
        }
        echo "<script type='text/javascript'>pnotify('Subscription Data Imported into the Database','success');</script>";
    }
}
if (isset($_POST["delete_certificates"])) {
    $sql = "DELETE FROM cis WHERE RelatedClassID = 4;
            ALTER TABLE ci_certificates AUTO_INCREMENT = 1";
    $result = mysqli_multi_query($conn, $sql) or die(mysqli_error($conn));
    echo "<script type='text/javascript'>pnotify('Workstations deleted','success');</script>";
}
?>