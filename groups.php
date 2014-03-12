<?php include("header.php"); ?>

<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $groupName = mysql_escape_string($_POST["groupName"]);
    $groupComments = mysql_escape_string($_POST["groupComments"]);
    
    if($groupName != "")
        dbExecute("INSERT INTO `group` (name, comments) VALUES ('$groupName', '$groupComments')");
}

$groups = dbQuery("SELECT * FROM `group` ORDER BY created_at DESC");

?>

<a href="index.php" class="btn btn-default pull-right">Go back</a>

<h1>Groups</h1>

<a href="#" onclick="$('#newGroup').toggle('fast');" class="btn btn-default">Create new Group</a>

<br /><br />

<div id="newGroup" style="display:none;">
    <form action="groups.php" method="POST">
        <table width="90%">
            <tr>
                <td>Name</td>
                <td><input type="text" name="groupName" style="width: 100%;" value="" /></td>
            </tr>
            <tr>
                <td>Comments</td>
                <td><textarea name="groupComments" style="width: 100%;height: 100px;"></textarea></td>
            </tr>
            <tr><td><br /></td></tr>
            <tr>
                <td></td>
                <td align="right"><input type="submit" class="btn btn-primary" value="Create Now!" /></td>
            </tr>
        </table>
    </form>
    <hr width="100%" />
</div>

<h4>Existing groups</h4>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Comments</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php while($group = mysql_fetch_array($groups)) { ?>
        <tr>
            <td>
                <a href="newVocabulary.php?groupId=<?php echo $group['id']; ?>"><?php echo $group['name']; ?></a>
            </td>            
            <td>
                <?php echo $group['comments']; ?>
            </td>
            <td><?php echo date("d-M-Y", strtotime($group['created_at'])); ?></td>
        </tr>
        <?php } ?>
    </tbody>
    
</table>

<?php include("footer.php"); ?>