<?php 

include("header.php");

$vocabulary = parse_ini_file("vocabulary.ini", true);

$selectedLesson = false;
$interval = 60;
$itemsPerInterval = 6;

//if(isset($_GET["groupId"])) $selectedLesson = $_GET["groupId"];
if(isset($_GET["interval"])) $interval = $_GET["interval"];
if(isset($_GET["items_per_interval"])) $itemsPerInterval = $_GET["items_per_interval"];

$groups = dbQuery("SELECT * FROM groups ORDER BY created_at DESC");

$vocabulary = null;
$currentGroup = null;

if(isset($_GET["groupId"]))
{
    $vocabulary = dbQuery("SELECT * FROM vocabulary WHERE group_id = '".$_GET["groupId"]."' ORDER BY created_at DESC");
}

?>

<?php include("intervalSettings.php"); ?>

<br />

<a href="#" onclick="$('#thatGrammerThing').toggle();return false;" class="btn btn-success" style="float:right;">What was that grammer thing?</a>

<a href="groups.php" class="btn btn-primary" style="float:right;margin-right: 5px;">Manage Groups</a>

<?php include("grammerThing.php"); ?>

<h2>Groups</h2>

<br /><br />

<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th>Comments</th>
        </tr>
    </thead>
    <tbody>
        <?php while($group = mysql_fetch_array($groups)) { ?>
            <?php if(isset($_GET["groupId"]) && $group["id"] == $_GET["groupId"]): ?>
                <?php $currentGroup = $group; ?>        
            <?php endif; ?>
            <tr>
                <td>
                    <a href="index.php?groupId=<?php echo urlencode($group["id"]); ?>&interval=<?php echo $interval ?>&items_per_interval=<?php echo $itemsPerInterval ?>"><?php echo $group["name"]; ?></a><br />
                </td>            
                <td><?php echo $group['comments']; ?></td>
            </tr>
        <?php } ?>
    </tbody>
    
</table>
    
<br />

<script type="text/javascript">
    var vocabulary = new Array();
</script>

<?php if($vocabulary): ?>

<h4><b><?php echo $currentGroup["name"]; ?></b></h4>

<a href="#" onclick="practice();return false;" class="btn btn-info">Practice now</a>

<script type="text/javascript">
    
    var vocabulary = new Array();
    
</script>

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
        <?php $wordCount = 0; ?>
        <?php while($word = mysql_fetch_array($vocabulary)) { ?>
            <script type="text/javascript">vocabulary["<?php echo $word['id'] ?>"] = new Array("<?php echo $word['en'] ?>", "<?php echo $word['cz'] ?>", "<?php echo $word['comments'] ?>", "<?php echo $vocabularyType[$word['type']]; ?>");</script>
            <tr>           
                <td><?php echo $word['cz']; ?></td>
                <td><?php echo $word['en']; ?></td>
                <td><?php echo $vocabularyType[$word['type']]; ?></td>
                <td><?php echo $word['comments']; ?></td>
            </tr>
            <?php $wordCount++; ?>
        <?php } ?>
    </tbody>
    
</table>

<?php 

//if($itemsPerInterval > $wordCount) $itemsPerInterval = $wordCount;

?>

<?php else: ?>

<h4>Select a Group!</h4>

<?php endif; ?>
    

<script type="text/javascript">
        
    setInterval(function(){
        practice();
    }, <?php echo $interval*60 ?>000);
    
    function practice()
    {
        alert("It's Czech Time!!!");
        ctAlert(<?php echo $itemsPerInterval ?>);
    }
    
    function getRandomWord()
    {
        var nextRandom = 0;
        
        var counter = 0;
        nextRandom = Math.floor(Math.random() * <?php echo $wordCount ?>);
        for(var vocabularyId in vocabulary)
        {
            if(counter == nextRandom)
            {
                return vocabulary[vocabularyId];
            }       

            counter++;
        }
    }
</script>

<div class="modal fade" id="ctAlertModalContainer">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            
            <h4 class="modal-title" id="lbAlertModalTitle">Practice Time</h4>
        </div>
        <div class="modal-body">
            <h1 id="ctAlertCz"></h1>
            <a href="#" onclick="$('#ctAlertHelp').show('fast');return false;" class="btn btn-danger btn-sm">I don't get it!</a>
            <div id="ctAlertHelp" style="display:none;">
                <h3><i>English:</i> <span id="ctAlertEn"></span></h3>
                <div id="ctAlertType" style="font-weight: bold;"></div>
                <br />
                <div id="ctAlertComments"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="ctAlertClose" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="ctAlertNextWord">Next Please</button>
        </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script type="text/javascript">
function ctAlert(countDown)
{
    $("#ctAlertClose").hide();
    $("#ctAlertNextWord").show();
    
    displayNextWord(countDown);
    
    $('#ctAlertModalContainer').modal();
}

function displayNextWord(countDown)
{
    countDown--;
    
    var word = getRandomWord();
    
    $("#ctAlertHelp").hide();
    
    $("#ctAlertEn").html(word[0]);
    $("#ctAlertCz").html(word[1]);
    $("#ctAlertType").html(word[3]);
    $("#ctAlertComments").html(word[2]);
    
    if(countDown > 0)
    {
        $("#ctAlertNextWord").attr("onclick", "displayNextWord("+countDown+");return false;");
    }
    else
    {
        $("#ctAlertClose").show();
        $("#ctAlertNextWord").hide();
    }
}
</script>

<?php include("footer.php"); ?>