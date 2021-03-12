<?php
	require_once("perpage.php");	
	require_once("dbcontroller.php");
	$db_handle = new DBController();
	
	$name = "";
	$email = "";
	
	$queryCondition = "";
	if(!empty($_POST["search"])) {
		foreach($_POST["search"] as $k=>$v){
			if(!empty($v)) {

				$queryCases = array("name","email");
				if(in_array($k,$queryCases)) {
					if(!empty($queryCondition)) {
						$queryCondition .= " AND ";
					} else {
						$queryCondition .= " WHERE ";
					}
				}
				switch($k) {
					case "name":
						$name = $v;
						$queryCondition .= "name LIKE '" . $v . "%'";
						break;
					case "email":
						$email = $v;
						$queryCondition .= "email LIKE '" . $v . "%'";
						break;
				}
			}
		}
	}
  

	$orderby = " ORDER BY id desc"; 
	$sql = "SELECT * FROM mock_test_tbl " . $queryCondition;
      

	$href = 'index.php';					
		
	$perPage = 2; 
	$page = 1;
	if(isset($_POST['page'])){
		$page = $_POST['page'];
	}
	$start = ($page-1)*$perPage;
	if($start < 0) $start = 0;
		
	$query =  $sql . $orderby .  " limit " . $start . "," . $perPage; 
     
     // print_r($query);exit();

	$result = $db_handle->runQuery($query);
	


	if(!empty($result)) {
		$result["perpage"] = showperpage($sql, $perPage, $href);
	}
?>
<html>
	<head>
	<title>Search and Pagination</title>
	<link href="style.css" type="text/css" rel="stylesheet" />
	</head>
	<body>
		
    <div id="toys-grid">      
			<form name="frmSearch" method="post" action="index.php">
			<div class="search-box">
			<p><input type="text" placeholder="Name" name="search[name]" class="demoInputBox" value="<?php echo $name; ?>"	/><input type="text" placeholder="Email" name="search[email]" class="demoInputBox" value="<?php echo $email; ?>"	/><input type="submit" name="go" class="btnSearch" value="Search"></p>
			</div>
			
			<table cellpadding="10" cellspacing="1">
        <thead>
					<tr>
          <th><strong>Name</strong></th>
          <th><strong>Email</strong></th>          
        
					
					</tr>
				</thead>
				<tbody>
					<?php
					if(!empty($result)) {
						foreach($result as $k=>$v) {
						  if(is_numeric($k)) {
					?>
          <tr>
					<td><?php echo $result[$k]["name"]; ?></td>
          <td><?php echo $result[$k]["email"]; ?></td>
					
					
					</tr>
					<?php
						  }
					   }
                    }
					if(isset($result["perpage"])) {
					?>
					<tr>
					<td colspan="6" align=right> <?php echo $result["perpage"]; ?></td>
					</tr>
					<?php } ?>
				<tbody>
			</table>
			</form>	
		</div>
	</body>
</html>