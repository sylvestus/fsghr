<?php
require("include.php");
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Generate QR Code</title>
	 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <style>
        body, html {
            height: 100%;
            width: 100%;
        }
        .bg {
            background-image: url("images/bg.jpg");
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>
<body>
<div class="container" id="panel">
        <br><br><br>
        <div class="row">
            <div class="col-md-6 offset-md-3" style="background-color: white; padding: 20px; box-shadow: 10px 10px 5px #888;">
                <div class="panel-heading">
                    <h1>Generate QR-code in PHP</h1>
                </div>
                <hr>
                <form action="show.php" method="get">
                    <?php
                    global $var;
                    for($i=1;$i<2;$i++){
                        $var=  GUID();
                    }
                    ?>
                    <input type="text" autocomplete="off" hidden class="form-control" name="text" style="border-radius: 0px; " placeholder="Text..." value="<?php echo "$var"?>">
                    <br>
                     <input type="text" autocomplete="off" class="form-control" name="name" style="border-radius: 0px; " placeholder="Enter Name..." value="">
                     <br> <input type="text" autocomplete="off" class="form-control" name="idno" style="border-radius: 0px; " placeholder="Enter ID No..." value="">
                    <br><input type="submit" class="btn btn-md btn-danger btn-block" name="save" value="Generate">
                    <br> <input class="btn btn-md btn-primary btn-block" name="refresh" onClick="window.location.reload()" value="refresh">
            </div>
        </div>
    </div>
</body>
</html>