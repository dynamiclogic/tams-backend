<html>
<head><title>View Assets</title>
<style>
body {
  font: normal medium/1.4 sans-serif;
}
table {
  border-collapse: collapse;
  width: 20%;
  margin-left: auto;
  margin-right: auto;
}
tr > td {
  padding: 0.25rem;
  text-align: center;
  border: 1px solid #ccc;
}
tr:nth-child(even) {
  background: #FAE1EE;
}
tr:nth-child(odd) {
  background: #edd3ff;
}
tr#header{
background: #c1e2ff;
}
td#sync{
background: #fff;
}
div.header{
padding: 10px;
background: #e0ffc1;
width:30%;
color: #008000;
margin:5px;
}
div.refresh{
margin-top:10px;
width: 5%;
margin-left: auto;
margin-right: auto;
}
div#norecord{
margin-top:10px;
width: 15%;
margin-left: auto;
margin-right: auto;
}
img{
height: 32px;
width: 32px;
}
</style>
<script>
var val= setInterval(function(){
location.reload();
},2000);
</script>
</head>
<body>
<center>
<div class="header">
Android SQLite and MySQL Sync - View Assets
</div>
</center>
<?php
    include_once 'db_functions.php';
    $db = new DB_Functions();
    $assets = $db->getAllAssets();
    if ($assets != false)
        $no_of_users = mysql_num_rows($assets);
    else
        $no_of_users = 0;
		
?>
<?php
    if ($no_of_users > 0) {
?>
<table>
<tr id="header"><td>id</td>
                <td>Name</td>
                <td>Description</td>
                <td>Latitude</td>
                <td>Longitude</td>
                <td>Created At</td>
                <td>Updated At</td>
                <td>Created By</td>
                <td>Updated By</td>
                <td>Active</td>
</tr>
<?php
    while ($row = mysql_fetch_array($assets)) {
?> 
<tr>
<td><span><?php echo $row["asset_id"] ?></span></td>
<td><span><?php echo $row["name"] ?></span></td>
<td><span><?php echo $row["description"] ?></span></td>
<td><span><?php echo $row["latitude"] ?></span></td>
<td><span><?php echo $row["longitude"] ?></span></td>
<td><span><?php echo $row["created_at"] ?></span></td>
<td><span><?php echo $row["updated_at"] ?></span></td>
<td><span><?php echo $row["created_by"] ?></span></td>
<td><span><?php echo $row["updated_by"] ?></span></td>
<td id="sync"><span>
<?php 
if($row["deleted"]==0)
{ 
echo "<img src='img/green.png'/>"; 
}else { 
echo "<img src='img/white.png'/>";
} 
?></span></td>
</tr>
<?php } ?>
</table>
<?php }else{ ?>
<div id="norecord">
No records in MySQL DB
</div>
<?php } ?>
</body>
</html>
                          
    