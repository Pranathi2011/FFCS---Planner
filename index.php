<?php 
session_start();
$connect = mysqli_connect("sql306.byetcluster.com", "epiz_29240093", "ZAq9CLmdQR1FN", "epiz_29240093_ffcs");
    if(isset($_GET["add"]))
{
    $add=$_GET['add'];
    $query = "SELECT * FROM winterjr WHERE id='$add' ORDER BY id ASC";
                $result = mysqli_query($connect, $query);
                if(mysqli_num_rows($result) > 0)
                {
                    while($row = mysqli_fetch_array($result))
                    {
    if(isset($_SESSION["registered_courses"]))
    {
        $item_array_id = array_column($_SESSION["registered_courses"], "item_id");
        if(!in_array($_GET["add"], $item_array_id))
        {
            $count = count($_SESSION["registered_courses"]);
            $item_array = array(
                'item_id'           =>  $_GET["add"],
                'item_code'         =>  $row["code"],
                'item_title'        =>  $row["title"],
                'item_type'     =>  $row["type"],
                'item_venue'     =>  $row["venue"],
                'item_credits'     =>  $row["credits"],
                'item_slot'        =>  $row["slot"],
                'item_faculty'     =>  $row["faculty"]
            );
            $_SESSION["registered_courses"][$count] = $item_array;
        }
        else
        {
            echo '<script>alert("Item Already Added")</script>';
        }
    }
    else
    {
        $item_array = array(
                'item_id'           =>  $_GET["add"],
                'item_code'         =>  $row["code"],
                'item_title'        =>  $row["title"],
                'item_type'     =>  $row["type"],
                'item_venue'     =>  $row["venue"],
                'item_credits'     =>  $row["credits"],
                'item_slot'        =>  $row["slot"],
                'item_faculty'     =>  $row["faculty"]
        );
        $_SESSION["registered_courses"][0] = $item_array;
    }
}
}
header('Location:index.php');
}
if(isset($_GET["delete"])){
    foreach($_SESSION["registered_courses"] as $keys => $values)
		{
			if($values["item_id"] == $_GET["delete"])
			{
	    unset($_SESSION["registered_courses"][$keys]);
        $_SESSION["registered_courses"] = array_values($_SESSION["registered_courses"]);
        echo '<script>window.location="index.php"</script>';
            }
        }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>FFCS planner -VIT UNIVERSITY</title>
    <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=Edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
        <meta name="author" content="unanymous" />
        <meta name="subject" content="Education" />
        <meta name="Description" content="Create a best timetable for yourself." />
        <meta name="Keywords" content="VIT,University,Vellore,FFCS,course,registration,timetable,visualize,ffcs" />
        <meta name="distribution" content="Global" />
        <meta name="country" content="India" />
        <meta name="theme-color" content="#9C27B0" />
        <meta property="og:title" content="FFCS" />
        <meta property="og:type" content="website" />
        <meta property="og:url" content="http://ffcs.great-site.net/" />
        <meta property="og:image" content="" />
        <meta property="og:description" content="Create a best timetable for yourself." />
        <meta property="og:site_name" content="FFCS-Planner" />
      <link rel="icon"  href="logo.png" type="image/x-icon">
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.4.1/html2canvas.min.js"></script>
	<link rel="stylesheet" type="text/css" href="fstyle.css">
</head>
<body>
    <div class="container" style="position: relative;top:60px;">
        <div class="text-center fw-bold text-primary" style="padding-bottom: 30px;font-size: 38px;">
                    Welcome to FFCS planner
        </div>
            <div class="card mb-4">
                <div class="card-header text-center fw-bold">
                    Search panel
                </div>
                <div class="card-body">
                    <form id="slot-sel-area" method="POST" class="container">
                        <div class="row gy-3">
                            <div class="col-lg-9 col-12">
                                <label>Course</label>
                                <?php
                                $query = "SELECT DISTINCT code,title FROM winterjr";
                                $result = mysqli_query($connect, $query);
                                ?>
                                <datalist id="courses">
                                    <?php while($row = mysqli_fetch_array($result)) { ?>
                                        <option value="<?php echo $row['code']; ?>"><?php echo $row['code']; ?>-<?php echo $row['title']; ?></option>
                                    <?php } $query = "SELECT DISTINCT faculty FROM winter";
                                $result = mysqli_query($connect, $query); ?>
                                    <?php while($row = mysqli_fetch_array($result)) { ?>
                                        <option value="<?php echo $row['faculty']; ?>"><?php echo $row['faculty']; ?></option>
                                    <?php } ?>
                                </datalist>
                                <input type="text" name="search" class="form-control" placeholder="Course name / Course code / Faculty" autocomplete="off" list="courses">
                            </div>
                            <div class="col-lg-3">
                                <br>
                                <input type="submit" name="display" class="btn btn-success" style="display:align-items:center;" value="SUBMIT"/>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-12">
                                <blockquote class="blockquote mt-1">
                                    <p class="text-black-50 fs-6">
                                        Search, select then submit to display result
                                    </p>
                                </blockquote>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
            <br />
            <div class="row gy-3 mb-2 mx-3 pt-5 mt-5">
            <div class="col-12 text-danger font-weight-bold font-italic" style="font-size:20px;">Search result</div>
            </div>
            <div class="table-responsive mx-4">
                <table class="table table-striped" style="text-align: center;">
                    <thead>
                    <tr class="table-info">
                        <th class="col" width="auto">code</th>
                        <th class="col" width="auto">title</th>
                        <th class="col" width="auto">Credits</th>
                        <th class="col" width="auto">slot</th>
                        <th class="col" width="auto">faculty</th>
                        <th class="col" width="auto">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(isset($_POST['display'])){
                    $code = $_POST['search'];
                    $_SESSION['code']=$_POST['search'];
                    }
                if(isset($_SESSION['code'])){
                $codex=$_SESSION['code'];
                $query = "SELECT * FROM winterjr WHERE code='$codex' OR faculty='$codex'";
                $result = mysqli_query($connect, $query);
                if(mysqli_num_rows($result) > 0)
                {
                    while($row = mysqli_fetch_array($result))
                    {
                ?>
                    <tr>
                        <td><?php echo $row["code"]; ?></td>
                        <td><?php echo $row["title"]; ?></td>
                        <td><?php echo $row["credits"]; ?></td>
                        <td><?php echo $row["slot"]; ?></td>
                        <td><?php echo $row["faculty"]; ?></td>
                        <td><a href="index.php?add=<?php echo $row['id'];?>"><button class="btn btn-primary">REGISTER</button></td>
                    </tr>

                    <?php
                    }
                }
                }
                    ?>
                    </tbody> 
                </table>
            </div>
            <br>
            <div class="row gy-3 mb-2 mx-3">
            <div class="col-12 text-primary font-weight-bold font-italic d-none d-lg-block" style="font-size:20px;">Time table  <a id="dlink" href="#" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><i class="bi bi-download"></i> Download timetable</a>
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
      <a id="tlink" href="#" class="btn btn-primary my-3"><i class="bi bi-camera-fill"></i> Capture Time Table</a><br>
      <a id="flink" href="#" class="btn btn-primary my-3"><i class="bi bi-camera-fill"></i> Capture Registered Courses</a>
      </div>
    </div>
  </div>
</div>
            </div>
            <div class="col-12 text-primary font-weight-bold font-italic d-sm-block d-xs-block d-lg-none" style="font-size:20px;">Time table<br></div>
            <div class="col-12 d-sm-block d-xs-block d-lg-none"><strong>Note: </strong>Use large screens to download the timetable</div>
            </div>
            <div id="timetable" class="table-responsive-xl text-center noselect mx-4">
            <table class="table table-bordered">
                <tr style="display:none;" id="message" class="screenshot_msg table-success">
                    <th colspan="16">FFCS Planner: <a href="http://ffcs.great-site.net/" style="text-decoration:none;">http://ffcs.great-site.net/</a></th>
                </tr>
                <tr>
                    <td class="ColumnOneDays" style="background-color: silver!important;font-weight: bold;">THEORY <br />HOURS</td>
                    <td class="TheoryHours">
                        08:00 AM <br />to <br />08:50 AM
                    </td>
                    <td class="TheoryHours">
                        09:00 AM <br />to <br />09:50 AM
                    </td>
                    <td class="TheoryHours">
                        10:00 AM <br />to <br />10:50 AM
                    </td>
                    <td class="TheoryHours">
                        11:00 AM <br />to <br />11:50 AM
                    </td>
                    <td class="TheoryHours">
                        12:00 PM <br />to <br />12:50 PM
                    </td>
                    <td class="TheoryHours" style="background-color: #ccf!important;"></td>
                    <td width="8px" rowspan="7" class="ColumnOneDays">
                        <br><br><br><br><br><br><br>
                        <strong>L <br />U <br />N <br />C <br />H</strong>
                    </td>
                    <td class="TheoryHours">
                        02:00 PM <br />to <br />02:50 PM
                    </td>
                    <td class="TheoryHours">
                        03:00 PM <br />to <br />03:50 PM
                    </td>
                    <td class="TheoryHours">
                        04:00 PM <br />to <br />04:50 PM
                    </td>
                    <td class="TheoryHours">
                        05:00 PM <br />to <br />05:50 PM
                    </td>
                    <td class="TheoryHours">
                        06:00 PM <br />to <br />06:50 PM
                    </td>
                    <td class="TheoryHours">
                        07:00 PM <br />to <br />07:50 PM
                    </td>
                </tr>
                <tr>
                    <td class="ColumnOneDays">LAB <br />HOURS</td>
                    <td class="LabHours">08:00 AM <br />to <br />08:45 AM</td>
                    <td class="LabHours">08:46 AM <br />to <br />09:30 AM</td>
                    <td class="LabHours">10:00 AM <br />to <br />10:45 AM</td>
                    <td class="LabHours">10:46 AM <br />to <br />11:30 AM</td>
                    <td class="LabHours">11:31 AM <br />to <br />12:15 AM</td>
                    <td class="LabHours">12:16 AM <br />to <br />01:00 PM</td>
                    <td class="LabHours">02:00 PM <br />to <br />02:45 PM</td>
                    <td class="LabHours">02:46 PM <br />to <br />03:30 PM</td>
                    <td class="LabHours">04:00 PM <br />to <br />04:45 PM</td>
                    <td class="LabHours">04:46 PM <br />to <br />05:30 PM</td>
                    <td class="LabHours">05:31 PM <br />to <br />06:15 PM</td>
                    <td class="LabHours">06:16 PM <br />to <br />07:00 PM</td>
                </tr>
                <tr>
                    <td class="ColumnOneDays" width="155px;">MON</td>
                        <td class="TimetableContent" width="155px;">
                        A1 / L1
                        <?php $t=0; for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="A1"||$slot[$j]=='L1'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                        </td>
                    <td class="TimetableContent" width="155px;">
                        F1 / L2
                        <?php $a="F1";$t=0; for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="F1"||$slot[$j]=='L2'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent" width="155px;">
                        D1 / L3
                        <?php $a="D1";$t=0; for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="D1"||$slot[$j]=='L3'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent" width="155px;">
                        TB1 / L4
                        <?php $a="TB1";$t=0; for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TB1"||$slot[$j]=='L4'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent" width="155px;">
                        TG1 / L5
                        <?php $a="TG1";$t=0; for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TG1"||$slot[$j]=='L5'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent" width="155px;">
                    L6
                    <?php $a="L6";$t=0; for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=='L6'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent" width="155px;">
                        A2 / L31
                        <?php $a="A2";$t=0; for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="A2"||$slot[$j]=='L31'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent" width="155px;">
                        F2 / L32
                        <?php $a="F2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="F2"||$slot[$j]=='L32'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent" width="155px;">
                        D2 / L33
                        <?php $a="D2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="D2"||$slot[$j]=='L33'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent" width="155px;">
                        TB2 / L34
                        <?php $a="TB2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TB2"||$slot[$j]=='L34'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent" width="155px;">
                        TG2 / L35
                        <?php $a="TG2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TG2"||$slot[$j]=='L35'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent" width="155px;">
                        V3 / L36
                        <?php $a="V3";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="V3"||$slot[$j]=='L36'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                </tr>
                <tr>
                    <td class="ColumnOneDays">TUE</td>
                    <td class="TimetableContent">
                        B1 / L7
                        <?php $a="B1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="B1"||$slot[$j]=='L7'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        G1 / L8
                        <?php $a="G1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="G1"||$slot[$j]=='L8'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        E1 / L9
                        <?php $a="E1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="E1"||$slot[$j]=='L9'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        TC1 / L10
                        <?php $a="TC1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TC1"||$slot[$j]=='L10'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        TAA1 / L11
                        <?php $a="TAA1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TAA1"||$slot[$j]=='L11'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                    L12
                    <?php $a="L12";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="L12"){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        B2 / L37
                        <?php $a="B2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="B2"||$slot[$j]=='L37'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        G2 / L38
                        <?php $a="G2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="G2"||$slot[$j]=='L38'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        E2 / L39
                        <?php $a="E2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="E2"||$slot[$j]=='L39'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        TC2 / L40
                        <?php $a="TC2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TC2"||$slot[$j]=='L40'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        TAA2 / L41
                        <?php $a="TAA2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TAA2"||$slot[$j]=='L41'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        V4 / L42
                        <?php $a="V4";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="V4"||$slot[$j]=='L42'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                </tr>
                <tr>
                    <td class="ColumnOneDays">WED</td>
                    <td class="TimetableContent">
                        C1 / L13
                        <?php $a="C1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="C1"||$slot[$j]=='L13'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        A1 / L14
                        <?php $a="A1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="A1"||$slot[$j]=='L14'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        F1 / L15
                        <?php $a="F1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="F1"||$slot[$j]=='L15'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        V1 / L16
                        <?php $a="V1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="V1"||$slot[$j]=='L16'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        V2
                        <?php $a="V2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="V2"){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent"></td>
                    <td class="TimetableContent">
                        C2 / L43
                        <?php $a="C2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="C2"||$slot[$j]=='L43'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        A2 / L44
                        <?php $a="A2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="A2"||$slot[$j]=='L44'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        F2 / L45
                        <?php $a="F2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="F2"||$slot[$j]=='L45'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        TD2 / L46
                        <?php $a="TD2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TD2"||$slot[$j]=='L46'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        TBB2 / L47
                        <?php $a="TBB2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TBB2"||$slot[$j]=='L47'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        V5 / L48
                        <?php $a="V5";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="V5"||$slot[$j]=='L48'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    </tr>
                <tr>
                    <td class="ColumnOneDays">THU</td>
                    <td class="TimetableContent">
                        D1 / L19
                        <?php $a="D1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="D1"||$slot[$j]=='L19'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        B1 / L20
                        <?php $a="B1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="B1"||$slot[$j]=='L20'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        G1 / L21
                        <?php $a="G1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="G1"||$slot[$j]=='L21'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        TE1 / L22
                        <?php $a="TE1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TE1"||$slot[$j]=='L22'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        TCC1 / L23
                        <?php $a="TCC1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TCC1"||$slot[$j]=='L23'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">L24
                    <?php $a="L24";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=='L24'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        D2 / L49
                        <?php $a="D2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="D2"||$slot[$j]=='L49'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        B2 / L50
                        <?php $a="B2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="B2"||$slot[$j]=='L50'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        G2 / L51
                        <?php $a="G2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="G2"||$slot[$j]=='L51'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?> 
                    </td>
                    <td class="TimetableContent">
                        TE2 / L52
                        <?php $a="TE2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TE2"||$slot[$j]=='L52'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        TCC2 / L53
                        <?php $a="TCC2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TCC2"||$slot[$j]=='L53'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        V6 / L54
                        <?php $a="V6";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="V6"||$slot[$j]=='L54'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                </tr>
                <tr>
                    <td class="ColumnOneDays">FRI</td>
                    <td class="TimetableContent">
                        E1 / L25
                        <?php $a="E1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="E1"||$slot[$j]=='L25'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        C1 / L26
                        <?php $a="C1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="C1"||$slot[$j]=='L26'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        TA1 / L27
                        <?php $a="TA1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TA1"||$slot[$j]=='L27'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        TF1 / L28
                        <?php $a="TF1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TF1"||$slot[$j]=='L28'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        TD1 / L29
                        <?php $a="TD1";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TD1"||$slot[$j]=='L29'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">L30
                    <?php $a="L30";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=='L30'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        E2 / L55
                        <?php $a="E2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="E2"||$slot[$j]=='L55'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        C2 / L56
                        <?php $a="C2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="C2"||$slot[$j]=='L56'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        TA2 / L57
                        <?php $a="TA2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TA2"||$slot[$j]=='L57'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        TF2 / L58
                        <?php $a="TF2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TF2"||$slot[$j]=='L58'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        TDD2 / L59
                        <?php $a="TDD2";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="TDD2"||$slot[$j]=='L59'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    <td class="TimetableContent">
                        V7 / L60
                        <?php $a="V7";$t=0;for($i=0;$i<sizeof($_SESSION["registered_courses"]);$i++){$slot = preg_split('/[+\s:]/',$_SESSION["registered_courses"][$i]["item_slot"]);for($j=0;$j<sizeof($slot);$j++){if($slot[$j]=="V7"||$slot[$j]=='L60'){$t += 1; if($t==1){?>
                        <br>
                        <p class="btn-success" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p><?php } else{ ?>
                        <br>
                        <p class="btn-danger" style="font-weight: bold;"><?php echo $_SESSION["registered_courses"][$i]["item_code"]; ?>-<?php echo $_SESSION["registered_courses"][$i]["item_venue"]; ?></p>
                        <?php }}}}?>
                    </td>
                    </tr>
                    <tr style="display:none;" id="fmessage" class="table table-success">
                    <th colspan="16">Made with <i class="bi bi-suit-heart-fill text-danger"></i> for VITians</th>
                    </tr>
            </table>
        </div>
    <br />
            <div class="row gy-3 mb-2 mx-3">
            <div class="col-lg-11 col-10 text-primary font-weight-bold font-italic" style="font-size:20px;">Registered Courses</div>
            </div>
                <div id="ftable" class="table-responsive mx-4">
                <table class="table table-striped table-hover" style="text-align: center;">
                    <thead>
                    <tr class="table-success">
                        <th class="col" width="auto">code</th>
                        <th class="col" width="auto">title</th>
                        <th class="col" width="auto">Credits</th>
                        <th class="col" width="auto">slot</th>
                        <th class="col" width="auto">faculty</th>
                        <th class="col" width="auto" id="del">Action</th>
                    </tr>
                    </thead>
                    <tbody style="background:white;">
                    <?php
                    $tcredits=0;
                    if(!empty($_SESSION["registered_courses"]))
                    {
                        foreach($_SESSION["registered_courses"] as $keys => $values)
                        {
                    ?>
                    <tr>
                        <td><?php echo $values["item_code"]; ?></td>
                        <td><?php echo $values["item_title"]; ?></td>
                        <td><?php echo $values["item_credits"];$tcredits+=$values["item_credits"]; ?></td>
                        <td><?php echo $values["item_slot"]; ?></td>
                        <td><?php echo $values["item_faculty"]; ?></td>
                        <td id="delta"><a href="index.php?delete=<?php echo $values['item_id'];?>"><i class="bi bi-trash-fill"></i></a></td>
                    </tr>
                    <?php
                    }
                }
                    ?>
                    <tr class="table-success">
                    <td colspan="6"><h5>Total credits registered: <?php echo $tcredits; ?></h5></td>
                    </tr>
                    </tbody>
                </table>
            </div>
    <div class="container-fluid text-center">
            <span>Made with <i class="bi bi-suit-heart-fill text-danger"></i> for VITians</span>
    </div>
    <script type="text/javascript" src="https://github.com/niklasvh/html2canvas/releases/download/0.5.0-alpha1/html2canvas.js"></script>
    <script>
    function convertToImage() {
        document.getElementById("message").style.display="table-row";
        document.getElementById("fmessage").style.display="table-row";
            html2canvas(document.getElementById("timetable"), {
                onrendered: function(canvas) {
                    var img = canvas.toDataURL("image/jpeg");
                    document.getElementById("tlink").href=img;
                    document.getElementById("tlink").download="timetable.jpeg";
                    document.getElementById("wabutton").href='whatsapp://send?text='+encodeURIComponent(img);
                    }
            });
            document.getElementById("message").style.display="none";
            document.getElementById("fmessage").style.display="none";
         }        
         var convertBtn = document.getElementById("dlink");
         convertBtn.addEventListener('click', convertToImage);
    </script>
    <script>
    function toImage() {
        var e=document.getElementById("del");
        for (var i = 0; i < e.length; i++) {
            e[i].style.display = "none";
        }
        var f=document.getElementById("delta");
        for (var i = 0; i < f.length; i++) {
            f[i].style.display = "none";
        }
            html2canvas(document.getElementById("ftable"), {
                onrendered: function(canvas) {
                    var img = canvas.toDataURL("image/jpeg");
                    document.getElementById("flink").href=img;
                    document.getElementById("flink").download="registeredcourses.jpeg";
                    },
            });
        var e=document.getElementById("del");
        for (var i = 0; i < e.length; i++) {
            e[i].style.display = "block";
        }
        var f=document.getElementById("delta");
        for (var i = 0; i < f.length; i++) {
            f[i].style.display = "block";
        }
    }
            var convertBtn = document.getElementById("dlink");
         convertBtn.addEventListener('click', toImage);
    </script>
    
</body>
</html>