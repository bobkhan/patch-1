<?php
include("../configs.php");
	mysql_select_db($server_adb);
	$check_query = mysql_query("SELECT gmlevel from account inner join account_access on account.id = account_access.id where username = '".strtoupper($_SESSION['username'])."'") or die(mysql_error());
    $login = mysql_fetch_assoc($check_query);
	if($login['gmlevel'] < 3)
	{
		die('
<meta http-equiv="refresh" content="2;url=GTFO.php"/>
		');
	}
	
  mysql_select_db($server_db) or die (mysql_error());
  $sql = mysql_query("SELECT id FROM news");
  //PAGINATION BEGIN
  $size=10; 
  $num_r = mysql_num_rows($sql);
  $num_p = ceil($num_r / $size);
  //Look for the number page, if not then first
  if (!isset($_GET['page']) || empty($_GET['page']) || $_GET['page'] < 1) {   //More control for 'go to' textbox
    $page=1;
  } 
  elseif ($_GET['page'] > $num_p){ //If overflow the show last page
    $page = $num_p;
  } 
  else{
    $page = $_GET['page'];  
  }
  $start = ($page - 1) * $size;  //the first result to show
  //PAGINATION END
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
		<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
		<title><?php echo $website['title']; ?> - <?php echo $admin['AP']; ?> - <?php echo $admin['Viewusers']; ?></title>
		<link href="css/styles.css" rel="stylesheet" type="text/css" media="all" />
		<link href="font/stylesheet.css" rel="stylesheet" type="text/css" media="all" />
		<script src="js/jquery.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/jquery.uniform.js" type="text/javascript" charset="utf-8"></script>
		<script src="js/tooltip.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript" src="js/DD_roundies_0.0.2a-min.js"></script>
		<script type="text/javascript" src="js/script-carasoul.js"></script>
		<link href="css/tooltip.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="css/uniform.defaultstyle3.css" type="text/css" media="screen" />  
</head>
<body class="bgc">
	<div id="admin">
    <div id="wrap">
      <div id="head">
        <?php include('header.php'); ?>
      </div>
    <!--Content Start-->
    <div id="content">
		  <img src="images/sepLine.png" alt="" class="sepline" />
    <div class="datalist"> 
	     <div class="heading">
        <h2><?php echo $admin['Viewusers']; ?></h2>

      </div>
      <div class="pagination">
        <?php
          if ($num_p > 1){
         if ($page > 1){echo '<a href="viewusers.php?page='.($page-1).'" style="color:#43ACFB;text-decoration:none;">Prev. </a>|';}
         if ($page > 2){echo '<a href="viewusers.php?page=1" style="color:#43ACFB;text-decoration:none;"> 1 </a>...';}
         echo $page;
         if ($page < $num_p-1){echo '...<a href="viewusers.php?page='.$num_p.'" style="color:#43ACFB;text-decoration:none;"> '.$num_p.' </a>';}
         if ($page < $num_p){echo '|<a href="viewusers.php?page='.($page+1).'" style="color:#43ACFB;text-decoration:none;"> Next</a>';}
         echo'
          <form method="get" action="">
            <input type="hidden" name="sort" value="'.$_GET['sort'].'">
            <input type="hidden" name="type" value="'.$_GET['type'].'">
            <input type="text" name="page" maxlength="4" class="pag"/>
            <input type="submit" value="Go">
          </form>'; 
         }
        ?> 
      </div>
      <ul id="lst">
        <li> 
			<p class="editHead2"><strong><?php echo $admin['Edit']; ?></strong></p>
			<p class="editHead2"><strong><?php echo $admin['Username']; ?></strong></p>
            <p class="title2"><strong><?php echo $admin['Name']; ?></strong></p>
            <p class="descripHead2"><?php echo $admin['Char']; ?></p>
            <p class="incHead"><?php echo $admin['Birth']; ?></p>
            <p class="ip"><?php echo $admin['ip']; ?></p>
        </li>
           <?php
            mysql_select_db($server_db) or die (mysql_error());
            $users = mysql_query("SELECT U.id,U.firstName,U.registerIp,U.birth,username FROM users U, $server_adb.account A 
            WHERE A.id = U.id ORDER BY id DESC LIMIT $start,$size");
            while ($usercheck = mysql_fetch_assoc($users)){
            mysql_select_db($server_cdb) or die (mysql_error());
            $chars = mysql_query("SELECT name FROM characters WHERE account = '".$usercheck['id']."'");
			      echo '
            <li> 
		<p class="edit2"><a href="editusers.php?id='.$usercheck['id'].'"><img src="images/editIco.png" alt="" /></a></p>
              <p class="edit2">'.$usercheck['username'].'</p>
	      <p class="title2">'.$usercheck['firstName'].'</p>
              <p class="descrip2">';
                while ($charcheck = mysql_fetch_assoc($chars)){
                  echo $charcheck['name'].', ';
                }
              echo '</p>
              <p class="inc">'.$usercheck['birth'].'</p>
              <p class="iplist">'.$usercheck['registerIp'].'</p>
              </li>';
            }?>
      </ul>
    </div>
    <img src="images/sepLine.png" alt="" class="sepline" />
             <!--  <div class="messages">
        <div><img src="images/warningIco.png" alt="" />
                  <p>Warning Message, Lorem ipsum dolor sit amet, consectetur adipiscing elit Pellentesque quis.</p>
                </div>
        <div><img src="images/infoIcon.png" alt="" />
                  <p>Information Message, Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                </div>
        <div><img src="images/success.png" alt="" />
                  <p>Success Message, Lorem ipsum dolor sit amet, Nam bibendum sagittis lobortis.consectetur.</p>
                </div>
        <div><img src="images/errorIco.png" alt="" />
                  <p>Error Message, Lorem ipsum dolor sit amet, Nam bibendum sagittis lobortis.consectetur.</p>
                </div>
      </div> -->
              <div id="calen">
        <div id="yuicalendar1"></div>
      </div>
            </div>
  </div>
          <div class="push"></div>
        </div>
<?php include("footer.php"); ?>
</body>
</html>
