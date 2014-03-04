<?php include("header.php"); ?>

<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $vocabularyGroupId = mysql_escape_string($_POST["vocabularyGroupId"]);
    $vocabularyCz = mysql_escape_string($_POST["vocabularyCz"]);
    $vocabularyEn = mysql_escape_string($_POST["vocabularyEn"]);
    $vocabularyType = mysql_escape_string($_POST["vocabularyType"]);
    $vocabularyComments = mysql_escape_string($_POST["vocabularyComments"]);
    
    dbExecute("UPDATE vocabulary 
            SET cz='$vocabularyCz', en='$vocabularyEn', type='$vocabularyType', comments='$vocabularyComments'
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
                        <option value="verb_ovat" />Verb -OVAT</option>
                        <option value="verb_at" />Verb -AT</option>
                        <option value="verb_et_et_it" />Verb -ET/-ĚT/-IT</option>
                        <option value="verb_irregular" />Verb Irregular</option>
                        <option value="verb_noun" />Noun</option>
                        <option value="verb_adjective" />Adjective</option>
                        <option value="unknown" />No idea!</option>
                    </select>
                    <script type="text/javascript">
                        $("#vocabularyType").val("<?php echo $word["type"]; ?>");
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