<?php 

include("header.php");

$user = getCurrentUser();



if(isRequestMethod("post"))
{
    $userFirstname = mysql_escape_string($_POST["user_firstname"]);
    $userLastname = mysql_escape_string($_POST["user_lastname"]);
    $userEmail = mysql_escape_string($_POST["user_email"]);
    
    if(isset($_POST["user_password"]) && $_POST["user_password"] != "")
    {
        $userPassword = md5(mysql_escape_string($_POST["user_password"]));
    }
    else
    {
        $userPassword = $user["password"];
    }
    
    $userSettings["practiceItemsCount"] = mysql_escape_string($_POST["practiceItemsCount"]);
    $userSettings["practiceInterval"] = mysql_escape_string($_POST["practiceInterval"]);
    
    $updateSql = "UPDATE `user` SET 
        firstname = '$userFirstname',
        lastname = '$userLastname',
        email = '$userEmail',
        password = '$userPassword',
        settings = '".  json_encode($userSettings)."'
        WHERE id = '".$user["id"]."'
    ";
    
    dbExecute($updateSql);
}

$userSettings = getCurrentUserSettings();

?>

<h2>Settings</h2>

<form action="settings.php" method="post">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Name</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Firstname</td>
                <td><input type="text" value="<?php echo $user["firstname"]; ?>" name="user_firstname" /></td>
            </tr>
            <tr>
                <td>Lastname</td>
                <td><input type="text" value="<?php echo $user["lastname"]; ?>" name="user_lastname" /></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="text" value="<?php echo $user["email"]; ?>" name="user_email" /></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" name="user_password" value="" />
            </tr>
            <tr>
                <td>Practice items</td>
                <td><input type="text" name="practiceItemsCount" value="<?php echo isset($userSettings->practiceItemsCount) ? $userSettings->practiceItemsCount : "15"; ?>" /></td>
            </tr>
            <tr>
                <td>Practice interval</td>
                <td><input type="text" name="practiceInterval" value="<?php echo isset($userSettings->practiceInterval) ? $userSettings->practiceInterval : "30"; ?>" /></td>
            </tr>

        </tbody>

    </table>

    <input type="submit" class="btn btn-primary pull-right" value="Keep that!" />

</form>

<br /><br />

<?php include("footer.php"); ?>