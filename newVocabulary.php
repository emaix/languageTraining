<?php include("header.php"); ?>

<?php 

if ($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $vocabularyGroupId = mysql_escape_string($_POST["vocabularyGroupId"]);
    $vocabularyCz = mysql_escape_string($_POST["vocabularyCz"]);
    $vocabularyEn = mysql_escape_string($_POST["vocabularyEn"]);
    $vocabularyType = mysql_escape_string($_POST["vocabularyType"]);
    $vocabularyComments = mysql_escape_string($_POST["vocabularyComments"]);
    
    dbExecute("INSERT INTO vocabulary (group_id, en, cz, type, comments) 
            VALUES ('$vocabularyGroupId', '$vocabularyEn', '$vocabularyCz', '$vocabularyType', '$vocabularyComments')");
}

$vocabulary = dbQuery("SELECT * FROM vocabulary WHERE group_id = '".$_GET["groupId"]."' ORDER BY created_at DESC");

?>

<a href="groups.php" class="btn btn-default pull-right">Go back</a>

<h1>New Vocabulary</h1>

<br /><br />

<div id="newVocabulary">
    <form action="newVocabulary.php?groupId=<?php echo $_GET["groupId"] ?>" method="POST">
        <input type="hidden" name="vocabularyGroupId" value="<?php echo $_GET["groupId"]; ?>" />
        <table width="90%">
            <tr>
                <td>Czech</td>
                <td><input type="text" name="vocabularyCz" style="width: 100%;" value="" /></td>
            </tr>
            <tr>
                <td>English</td>
                <td><input type="text" name="vocabularyEn" style="width: 100%;" value="" /></td>
            </tr>
            <tr>
                <td>Type</td>
                <td>
                    <select name="vocabularyType" style="width:100%;">
                        <option value="verb_ovat" />Verb -OVAT</option>
                        <option value="verb_at" />Verb -AT</option>
                        <option value="verb_et_et_it" />Verb -ET/-ĚT/-IT</option>
                        <option value="verb_irregular" />Verb Irregular</option>
                        <option value="verb_noun" />Noun</option>
                        <option value="verb_adjective" />Adjective</option>
                        <option value="unknown" />No idea!</option>
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
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        <?php while($word = mysql_fetch_array($vocabulary)) { ?>
        <tr>           
            <td><?php echo $word['cz']; ?></td>
            <td><?php echo $word['en']; ?></td>
            <td><?php echo $vocabularyType[$word['type']]; ?></td>
            <td><?php echo $word['comments']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
    
</table>

<?php include("footer.php"); ?>