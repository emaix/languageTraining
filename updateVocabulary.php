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
    
    dbExecute("UPDATE vocabulary SET 
                cz='$vocabularyCz', 
                en='$vocabularyEn', 
                type='$vocabularyTyp', 
                verification='$vocabularyVerificatio',
                comments='$vocabularyComments',
                updated_by='".$currentUser["id"]."',
                updated_at='".date("Y-m-d H:i:s")."'
            WHERE id='".$_GET["vocabularyId"]."'
            ");
}

$vocabulary = dbQuery("SELECT * FROM vocabulary WHERE id = '".$_GET["vocabularyId"]."'");

$word = mysql_fetch_array($vocabulary);

?>

<a href="newVocabulary.php?groupId=<?php echo $word["group_id"]; ?>" class="btn btn-default pull-right">Go back</a>

<h1>Update Vocabulary</h1>

<br /><br />

<div id="newVocabulary">
    <form action="updateVocabulary.php?vocabularyId=<?php echo $_GET["vocabularyId"]; ?>" method="POST">
        <input type="hidden" name="vocabularyGroupId" value="<?php echo $_GET["vocabularyId"]; ?>" />
        <table width="90%">
            <tr>
                <td>Czech</td>
                <td><input type="text" name="vocabularyCz" style="width: 100%;" value="<?php echo $word["cz"]; ?>" /></td>
            </tr>
            <tr>
                <td>English</td>
                <td><input type="text" name="vocabularyEn" style="width: 100%;" value="<?php echo $word["en"]; ?>" /></td>
            </tr>
            <tr>
                <td>Type</td>
                <td>
                    <select name="vocabularyType" id="vocabularyType" style="width:100%;">
                        <?php foreach($vocabularyType as $vocabKey => $vocabName): ?>
                        <option value="<?php echo $vocabKey; ?>" /><?php echo $vocabName; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <script type="text/javascript">
                        $("#vocabularyType").val("<?php echo $word["type"]; ?>");
                    </script>
                </td>
            </tr>
            <tr>
                <td>Verification</td>
                <td>
                    <select name="vocabularyVerification" id="vocabularyVerification" style="width:100%;">
                        <?php foreach($vocabularyVerification as $key => $value): ?>
                        <option value="<?php echo $key; ?>" /><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <script type="text/javascript">
                        $("#vocabularyVerification").val("<?php echo $word["verification"]; ?>");
                    </script>
                </td>
            </tr>
            <tr>
                <td>Comments</td>
                <td><textarea name="vocabularyComments" style="width: 100%;height: 100px;"><?php echo $word["comments"]; ?></textarea></td>
            </tr>
            <tr><td><br /></td></tr>
            <tr>
                <td></td>
                <td align="right"><input type="submit" class="btn btn-primary" value="Update Vocabulary Now!" /></td>
            </tr>
        </table>
    </form>
    <hr width="100%" />
</div>

<?php include("footer.php"); ?>