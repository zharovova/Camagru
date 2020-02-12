<head>
    <title>Camagru | Settings</title>
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<?php
if (!isset($_SESSION['login']) and !isset($_SESSION['password']))
        header ('Location: ../main');
?>
<div id="container_1">
  <div id="container_2">
    <div id="left_column">
    <p style="font-weight: bold"><a href="../settings">Settings</a><p><br>
    <h4><a href="../settings">Change username</a></h4>
    <h5><a href="../settings/changeemail">Change e-mail</a></h5>
    <h5><a href="../settings/changepassword">Change password</a></h5>
    </div>
    <div id="right_column">
    <form method="post" action="/settings/changelogin">
            username <input type="text" name="login_new" placeholder="<?php echo $_SESSION['login'] ?>" value="" required="required"><br><br>
            <input type="submit" name="submit" value="submit"><br><br>
            </form>
        <?php
        if (isset($_SESSION['message'])) {
                echo '<p id="msg"> ' . $_SESSION['message'] . ' </p>';
        }
        unset($_SESSION['message']); 
        ?>
    </div>
    <div class="clear"></div>
  </div>
</div>
</body>
</html>