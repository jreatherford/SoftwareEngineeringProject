<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
    <?php
        session_start();
        include_once 'schedule_output.php';
        build_schedule_table();
    ?>
    </br></br>
    <script>
        document.write('<a href="' + document.referrer + '"><img src="images/goback.png"/></a></a>');
</script>
    </body>
</html>