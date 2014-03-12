<?php include("header.php"); ?>

<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $currentUser = getCurrentUser();
    
    $vocabularyGroupId = mysql_escape_string($_POST["vocabularyGroupId"]);
    $vocabularyCz = mysql_escape_string($_POST["vocabularyCz"]);
    $vocabularyEn = mysql_escape_string($_POST["vocabularyEn"]);
    $vocabularyTyp = mysql_escape_string($_POST["vocabularyType"]);
    $vocabularyVerificatio = mysql_escape_string($_POST["vocabularyVerification"]);
    $vocabularyComments = mysql_escape_string($_POST["vocabularyComments"]);
    
    dbExecute("INSERT INTO vocabulary (group_id, en, cz, type, verification, comments, added_by, updated_by, updated_at) 
            VALUES (
                '$vocabularyGroupId', 
                '$vocabularyEn', 
                '$vocabularyCz', 
                '$vocabularyTyp', 
                '$vocabularyVerificatio',
                '$vocabularyComments',
                '".$currentUser["id"]."',
                '".$currentUser["id"]."',
                '".date("Y-m-d H:i:s")."'
            )");
}

$userFirstNames = getClassUserFirstNames();

$vocabulary = dbQuery("SELECT * FROM vocabulary WHERE group_id = '".$_GET["groupId"]."' ORDER BY created_at DESC");

?>

<script type="text/javascript">
    $(document).ready(function(){
        $("#vocabularyCz").focus();
    });
</script>

<a href="groups.php" class="btn btn-default pull-right">Go back</a>

<h1>New Vocabulary</h1>

<br /><br />

<div id="newVocabulary">
    <form action="newVocabulary.php?groupId=<?php echo $_GET["groupId"] ?>" method="POST">
        <input type="hidden" name="vocabularyGroupId" value="<?php echo $_GET["groupId"]; ?>" />
        <table width="90%">
            <tr>
                <td>Czech</td>
                <td><input type="text" name="vocabularyCz" id="vocabularyCz" style="width: 100%;" value="" /></td>
            </tr>
            <tr>
                <td>English</td>
                <td><input type="text" name="vocabularyEn" style="width: 100%;" value="" /></td>
            </tr>
            <tr>
                <td>Type</td>
                <td>
                    <select name="vocabularyType" style="width:100%;">
                        <?php foreach($vocabularyType as $vocabKey => $vocabName): ?>
                        <option value="<?php echo $vocabKey; ?>" /><?php echo $vocabName; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Verification</td>
                <td>
                    <select name="vocabularyVerification" style="width:100%;">
                        <?php foreach($vocabularyVerification as $key => $value): ?>
                        <option value="<?php echo $key; ?>" /><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Comments</td>
                <td><textarea name="vocabularyComments" style="width: 100%;height: 100px;"></textarea></td>
            </tr>
            <tr><td><br /></td></tr>
            <tr>
                <td></td>
                <td align="right"><input type="submit" class="btn btn-primary" value="Create Vocabulary Now!" /></td>
            </tr>
        </table>
    </form>
    <hr width="100%" />
</div>

<h4>Words in this Group</h4>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Cz</th>
            <th>En</th>
            <th>Type</th>
            <th>Correct?</th>
            <th>Comments</th>
            <th>Added By</th>
            <th>Updated By</th>
            <th>Created / Updated At</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php while($word = mysql_fetch_array($vocabulary)) { ?>
        <tr>           
            <td><?php echo $word['cz']; ?></td>
            <td><?php echo $word['en']; ?></td>
            <td><?php echo $vocabularyType[$word['type']]; ?></td>
            <td nowrap><?php echo $vocabularyVerification[$word['verification']]; ?></td>
            <td><?php echo $word['comments']; ?></td>
            <td><?php echo $userFirstNames[$word["added_by"]]; ?></td>
            <td><?php echo $userFirstNames[$word["updated_by"]]; ?></td>
            <td><?php echo date("d-m-Y H:i", strtotime($word["created_at"])); ?> / <?php echo date("d-m-Y H:i", strtotime($word["updated_at"])); ?></td>
            <td align="right"><a href="updateVocabulary.php?vocabularyId=<?php echo $word["id"]; ?>" class="btn btn-default btn-sm">Update</a></td>
        </tr>
        <?php } ?>
    </tbody>
    
</table>

<?php include("footer.php"); ?>