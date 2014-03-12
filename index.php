<?php 

include("header.php");

//$vocabulary = parse_ini_file("vocabulary.ini", true);

$userSettings = getCurrentUserSettings();
$userFirstNames = getClassUserFirstNames();

$interval = $userSettings->practiceInterval;
$itemsPerInterval = $userSettings->practiceItemsCount;

if(isset($_GET["interval"])) $interval = $_GET["interval"];
if(isset($_GET["items_per_interval"])) $itemsPerInterval = $_GET["items_per_interval"];

$groups = dbQuery("SELECT * FROM `group` ORDER BY created_at DESC");

$vocabulary = null;
$currentGroup = null;

if(!isset($_GET["groupId"]) || $_GET["groupId"] == "newest")
{
    $vocabulary = dbQuery("SELECT * FROM vocabulary ORDER BY created_at DESC LIMIT ".($itemsPerInterval*5)."");
}
else
{
    $vocabulary = dbQuery("SELECT * FROM vocabulary WHERE group_id = '".$_GET["groupId"]."' ORDER BY cz ASC");
}

?>

<div style="float:right;"><i>Next Practice in: <b><span id="countDownNextPractice"><?php echo $interval; ?></span> Mins</b></i></div>

<h2>Directions</h2>
<p>Set your interval below and select a group / latest vocabulary. Take the loaded URL and add it as your browsers start-up page, or bookmark the page.</p>

<?php include("intervalSettings.php"); ?>


<h2>Info</h2>

<a href="#" onclick="$('#thatGrammerThing').toggle();return false;" class="btn btn-success" style="">What was that grammer thing?</a>

<?php include("grammerThing.php"); ?>

<h2>
    Groups
    <a href="groups.php" class="btn btn-primary" style="float:right;">Manage Groups</a>
</h2>

<p>Groups are "word containers". Click Manage Groups to create new Groups and to add vocabulary to them.</p>
<p>Select a group that you would like to practice.</p>
<p>
    Or you can practice the 
    <a class="btn btn-default" href="index.php?groupId=newest">
        Latest added vocabulary
    </a>
</p>
<br />

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
            <?php if(isset($_GET["groupId"]) && $group["id"] == $_GET["groupId"]): ?>
                <?php $currentGroup = $group; ?>        
            <?php endif; ?>
            <tr>
                <td>
                    <a href="index.php?groupId=<?php echo urlencode($group["id"]); ?>"><?php echo $group["name"]; ?></a><br />
                </td>            
                <td><?php echo $group['comments']; ?></td>
                <td><?php echo date("d-M-Y", strtotime($group['created_at'])); ?></td>
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

<table class="table table-striped" id="wordsList">
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
        <?php $wordCount = 0; ?>
        <?php while($word = mysql_fetch_array($vocabulary)) { ?>
            <script type="text/javascript">vocabulary["<?php echo $word['id'] ?>"] = new Array("<?php echo $word['en'] ?>", "<?php echo $word['cz'] ?>", "<?php echo $word['comments'] ?>", "<?php echo $vocabularyType[$word['type']]; ?>");</script>
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
    
    var countDownNextPractice = <?php echo $interval; ?>;
    
    setInterval(function(){
        countDownNextPractice--;
        $("#countDownNextPractice").html(countDownNextPractice);
    }, 60000);
    
    function practice()
    {
        countDownNextPractice = <?php echo $interval; ?>;
        
        $("#wordsList").hide();
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
            
            <span style="float:right;" id="lbAlertModalCountDown"></span>
            <h4 class="modal-title" id="lbAlertModalTitle">Practice Time</h4>
        </div>
        <div class="modal-body">
            <h1 id="ctAlertCz"></h1>
            <a href="#" onclick="$('#ctAlertHelp').show('fast');return false;" class="btn btn-danger btn-sm">I don't get it!</a>
            <div id="ctAlertHelp" style="display:none;">
                <h3><i>English:</i> <span id="ctAlertEn"></span></h3>
                <div style="font-weight: bold;">Type: <span id="ctAlertType"></span></div>
                <br />
                <div id="ctAlertComments"></div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" id="ctAlertClose" data-dismiss="modal" onclick="$('#wordsList').show();">Close</button>
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
    
    $("#lbAlertModalCountDown").html("<b>"+(countDown+1)+"</b>");
    
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