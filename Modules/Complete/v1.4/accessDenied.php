<?php
    session_start();
    if( isset($_SESSION['admintemp']) || isset($_SESSION['usertemp']) )
    {
        echo '
<center>
<br/><br/><br/><br/>
<font size="30" color="green">Please login again using the new information.</font>
<br/><br/><br/><br/>
<a href="login.php" ><img src="images/goback.png"/></a>
</center><!--';
    }
?>
<center>
<br/><br/><br/><br/>
<font size="30" color="red">Access Denied.</font>
<br/><br/><br/><br/>
<a href='login.php' ><img src='images/goback.png'/></a>
</center>