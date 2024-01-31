<?php
 
    require("include.php");
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
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
            background-color: black;
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        * {
  box-sizing: border-box;
}

#myInput {
  background-image: url('/css/searchicon.png');
  background-position: 10px 10px;
  background-repeat: no-repeat;
  width: 100%;
  font-size: 16px;
  padding: 12px 20px 12px 40px;
  border: 1px solid #ddd;
  margin-bottom: 12px;
}

#myTable {
  border-collapse: collapse;
  width: 100%;
  border: 1px solid #ddd;
  font-size: 18px;
}

#myTable th, #myTable td {
  text-align: left;
  padding: 12px;
}

#myTable tr {
  border-bottom: 1px solid #ddd;
}

#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
}

</style>
</head>
<body>
  
  <div class="row">
    <div class="col-md-8 offset-md-2" style="background-color: white; padding: 20px; "> 

<?php
$id=$_GET['id'];

$query="select * from tickets where id=$id";

$result1 = mysqli_query($con, $query);

foreach ($result1 as $key){
?>
          <h2>TICKET NO : <?php echo $key['id'] ?></h2>
<table id="myTable">
  <tr class="header">
    <th style="width:5%;">No</th>
    <th style="width:35%;">QR CODE</th>
      <th style="width:20%;">Date</th>
       <th style="width:20%;">Consumed By</th>
       <th style="width:20%;">ID No</th>
  </tr>
<tr>
    <td><?php echo $key['id'] ?></td>
    <td><img src="generate.php?text=<?php echo $key['GUID']?>?>" height="300" width="300" alt=""></td>
    <td><?php echo $key['consumed_date'] ?></td>
    <td><?php echo $key['consumed_by'] ?></td>
    <td><?php echo $key['id_no'] ?></td>
  </tr>
 <?php
 
}
 ?>
</table>
    </div>
  </div>
</body>
</html>

