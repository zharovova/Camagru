<!DOCTYPE html>
    <html lang="en">
    <style>
        body {
            font-family: Arial;
            padding: 10px;
            background: #f1f1f1;
  	    }
        div {
            border-radius: 3px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            text-decoration: none;
        }
        form {
            margin: 10px;
        }
        a {
            text-decoration: none;
            color: rgb(82, 82, 82);
        }
        a:hover {
            font-weight: bold; 
        }
        #container {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            height: 100%;
            width: 100%;
            margin-top: 15%;
        }
        #one {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
            color: rgb(82, 82, 82);
            height: 80%;
            width: 20%;
            background: linear-gradient(20deg, #c2c2d6, #e6f9ff);
            padding: 1%;
            box-shadow: 0 6px 4px -4px rgba(0, 0, 0, .2);
        }
        #two {
            font-size: 9px;
            color: rgb(82, 82, 82);
            height: 20%;
            width: 20%;
            background: linear-gradient(20deg, #c2c2d6, #e6f9ff);
            padding: 1%;
            box-shadow: 0 6px 4px -4px rgba(0, 0, 0, .2);
        }
        #msg {
            padding: 3px;
            font-weight: bold;
            text-align: center;
            color: red;
            font-size: 11px;
        }
    </style>
    	<title>Camagru | Sign Up</title>
    <body>
      <div id="container">
        <div id="one"><a href="/main">CAMAGRU</a><br><br>
            <form method="post" action="/signup/create">
                <input type="text" name="email" placeholder="email" value="" required="required"><br><br>
                <input type="text" name="login" placeholder="login" value="" required="required"><br><br>
                <input type="password" name="password" placeholder="password" value="" required="required"><br><br>
                <input type="password" name="password_confirm" placeholder="repeat your password" value="" required="required"><br><br>
                <input type="submit" name="submit" value="Sign Up"><br>
       </form>
            <?php
            if (isset($_SESSION['message'])) {
                echo '<p id="msg"> ' . $_SESSION['message'] . ' </p>';
            }
            unset($_SESSION['message']);
            ?>
    </div>
    <br>
        <div id="two">
            ALREADY HAVE AN ACCOUNT? 
            <a href="/auth">LOG IN</a><br>
        </div>
    </div>
    </body>
    </html>