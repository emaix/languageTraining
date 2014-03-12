<?php session_start(); ?>
<?php include_once("dbOpen.php"); ?>
<?php include_once("utils.php"); ?>

<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $email = $_POST["email"];
    $password = $_POST["password"];
    
    $user = dbQuery("SELECT * FROM `user` WHERE email = '".$email."'");
    $user = mysql_fetch_array($user);
    
    if($user["password"] == md5($password) || $user["password"] == "")
    {
        setIsAuthenticated(true);
        
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_firstname"] = $user["firstname"];
        
        ini_set("session.cookie_lifetime","28800"); //8 hours
        
        header("Location: index.php"); /* Redirect browser */
    }
    else
    {
        setIsAuthenticated(false);
    }
}

?>

<?php include("header.php"); ?>

<br /><br /><br /><br /><br />
<center>
    <form action="login.php" method="post">
        <h1>Doh, another login</h1>
        <table cellpadding="10px" cellspacing="10px">
            <tr>
                <td>Email</td>
                <td><input type="text" name="email" /></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="password" /></td>
            </tr>
            <tr><td><br /></td></tr>
            <tr>
                <td></td>
                <td align="right"><input type="submit" value="Let me in already!" class="btn btn-primary" /></td>
            </tr>
        </table>
    </form>
</center>

<br /><br /><br /><br /><br />
<br /><br /><br /><br /><br />
<br /><br /><br /><br /><br />

<?php include("footer.php"); ?>