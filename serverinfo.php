<?php include("./header.php") ?>
<?php
if (in_array("100001", $group_array)) {
} else {
    $CurrentPage = htmlspecialchars(basename($_SERVER['PHP_SELF']));
	notgranted($CurrentPage);
}
?>
<!-- page content -->
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>Current Server status</h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group float-end top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="button">Go</button>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="javascript:void(0);">Settings 1</a>
                            </li>
                            <li><a href="javascript:void(0);">Settings 2</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="clearfix"></div>
                <div class="x_content">
                    <?php

                    function getSystemMemInfo()
                    {
                        $memdata = explode("\n", file_get_contents("/proc/meminfo"));
                        $meminfo = array();
                        foreach ($memdata as $line) {
                            list($key, $val) = explode(":", $line);
                            $meminfo[$key] = trim($val);
                        }
                        return $meminfo;
                    }

                    echo "<p><h4>Memory information</h4></p>";
                    //Memory variables
                    // Returns used memory (either in percent (without percent sign) or free and overall in bytes)
                    function getServerMemoryUsage($getPercentage = true)
                    {
                        $memoryTotal = null;
                        $memoryFree = null;

                        if (stristr(PHP_OS, "win")) {
                            // Get total physical memory (this is in bytes)
                            $cmd = "wmic ComputerSystem get TotalPhysicalMemory";
                            @exec($cmd, $outputTotalPhysicalMemory);

                            // Get free physical memory (this is in kibibytes!)
                            $cmd = "wmic OS get FreePhysicalMemory";
                            @exec($cmd, $outputFreePhysicalMemory);

                            if ($outputTotalPhysicalMemory && $outputFreePhysicalMemory) {
                                // Find total value
                                foreach ($outputTotalPhysicalMemory as $line) {
                                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                                        $memoryTotal = $line;
                                        break;
                                    }
                                }

                                // Find free value
                                foreach ($outputFreePhysicalMemory as $line) {
                                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                                        $memoryFree = $line;
                                        $memoryFree *= 1024;  // convert from kibibytes to bytes
                                        break;
                                    }
                                }
                            }
                        } else {
                            if (is_readable("/proc/meminfo")) {
                                $stats = @file_get_contents("/proc/meminfo");

                                if ($stats !== false) {
                                    // Separate lines
                                    $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                                    $stats = explode("\n", $stats);

                                    // Separate values and find correct lines for total and free mem
                                    foreach ($stats as $statLine) {
                                        $statLineData = explode(":", trim($statLine));

                                        //
                                        // Extract size (TODO: It seems that (at least) the two values for total and free memory have the unit "kB" always. Is this correct?
                                        //

                                        // Total memory
                                        if (count($statLineData) == 2 && trim($statLineData[0]) == "MemTotal") {
                                            $memoryTotal = trim($statLineData[1]);
                                            $memoryTotal = explode(" ", $memoryTotal);
                                            $memoryTotal = $memoryTotal[0];
                                            $memoryTotal *= 1024;  // convert from kibibytes to bytes
                                        }

                                        // Free memory
                                        if (count($statLineData) == 2 && trim($statLineData[0]) == "MemFree") {
                                            $memoryFree = trim($statLineData[1]);
                                            $memoryFree = explode(" ", $memoryFree);
                                            $memoryFree = $memoryFree[0];
                                            $memoryFree *= 1024;  // convert from kibibytes to bytes
                                        }
                                    }
                                }
                            }
                        }

                        if (is_null($memoryTotal) || is_null($memoryFree)) {
                            return null;
                        } else {
                            if ($getPercentage) {
                                return (100 - ($memoryFree * 100 / $memoryTotal));
                            } else {
                                return array(
                                    "total" => $memoryTotal,
                                    "free" => $memoryFree,
                                );
                            }
                        }
                    }

                    function getNiceFileSize($bytes, $binaryPrefix = true)
                    {
                        if ($binaryPrefix) {
                            $unit = array('B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB');
                            if ($bytes == 0) return '0 ' . $unit[0];
                            return @round($bytes / pow(1024, ($i = floor(log($bytes, 1024)))), 2) . ' ' . (isset($unit[$i]) ? $unit[$i] : 'B');
                        } else {
                            $unit = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
                            if ($bytes == 0) return '0 ' . $unit[0];
                            return @round($bytes / pow(1000, ($i = floor(log($bytes, 1000)))), 2) . ' ' . (isset($unit[$i]) ? $unit[$i] : 'B');
                        }
                    }

                    // Memory usage: 4.55 GiB / 23.91 GiB (19.013557664178%)
                    $memUsage = getServerMemoryUsage(false);
                    echo sprintf(
                        "Memory usage: %s / %s (%s%%)",
                        getNiceFileSize($memUsage["total"] - $memUsage["free"]),
                        getNiceFileSize($memUsage["total"]),
                        getServerMemoryUsage(true)
                    );

                    echo "<p><h4>CPU information</h4></p>";
                    function _getServerLoadLinuxData()
                    {
                        if (is_readable("/proc/stat")) {
                            $stats = @file_get_contents("/proc/stat");

                            if ($stats !== false) {
                                // Remove double spaces to make it easier to extract values with explode()
                                $stats = preg_replace("/[[:blank:]]+/", " ", $stats);

                                // Separate lines
                                $stats = str_replace(array("\r\n", "\n\r", "\r"), "\n", $stats);
                                $stats = explode("\n", $stats);

                                // Separate values and find line for main CPU load
                                foreach ($stats as $statLine) {
                                    $statLineData = explode(" ", trim($statLine));

                                    // Found!
                                    if (
                                        (count($statLineData) >= 5) &&
                                        ($statLineData[0] == "cpu")
                                    ) {
                                        return array(
                                            $statLineData[1],
                                            $statLineData[2],
                                            $statLineData[3],
                                            $statLineData[4],
                                        );
                                    }
                                }
                            }
                        }

                        return null;
                    }

                    // Returns server load in percent (just number, without percent sign)
                    function getServerLoad()
                    {
                        $load = null;

                        if (stristr(PHP_OS, "win")) {
                            $cmd = "wmic cpu get loadpercentage /all";
                            @exec($cmd, $output);

                            if ($output) {
                                foreach ($output as $line) {
                                    if ($line && preg_match("/^[0-9]+\$/", $line)) {
                                        $load = $line;
                                        break;
                                    }
                                }
                            }
                        } else {
                            if (is_readable("/proc/stat")) {
                                // Collect 2 samples - each with 1 second period
                                // See: https://de.wikipedia.org/wiki/Load#Der_Load_Average_auf_Unix-Systemen
                                $statData1 = _getServerLoadLinuxData();
                                sleep(1);
                                $statData2 = _getServerLoadLinuxData();

                                if (
                                    (!is_null($statData1)) &&
                                    (!is_null($statData2))
                                ) {
                                    // Get difference
                                    $statData2[0] -= $statData1[0];
                                    $statData2[1] -= $statData1[1];
                                    $statData2[2] -= $statData1[2];
                                    $statData2[3] -= $statData1[3];

                                    // Sum up the 4 values for User, Nice, System and Idle and calculate
                                    // the percentage of idle time (which is part of the 4 values!)
                                    $cpuTime = $statData2[0] + $statData2[1] + $statData2[2] + $statData2[3];

                                    // Invert percentage to get CPU time, not idle time
                                    $load = 100 - ($statData2[3] * 100 / $cpuTime);
                                }
                            }
                        }

                        return $load;
                    }

                    $cpuLoad = getServerLoad();
                    if (is_null($cpuLoad)) {
                        echo "CPU load not estimateable (maybe too old Windows or missing rights at Linux or Windows)";
                    } else {
                        echo "Avarage load of CPU: " . $cpuLoad . "%";
                    }

                    ?>

                </div>
            </div>
        </div>
    </div>

    <!-- /page content -->

    <?php include("./footer.php") ?>