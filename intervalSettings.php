<h2>Interval</h2>

<h4>
    <span class="label label-warning">
        <?php echo $itemsPerInterval; ?> words per <?php echo $interval; ?> Mins
    </span>
    <!--&nbsp;
    <a href="#" onclick="$('#intervalSettings').toggle('fast');" style="font-size: 14px;">Change </a>-->
</h4>
<!--
<div id="intervalSettings" style="display: none;">
        
    <form action="index.php" method="get">
        
        <input type="hidden" name="groupId" value="<?php echo isset($_GET["groupId"]) ? $_GET["groupId"] : ""; ?>" />
        
        <table>

            <tr>
                <td><i>Words</i></td>
                <td><i>Interval (Mins)</i></td>
                <td></td>
            </tr>
            <tr>
                <td><input type="text" name="items_per_interval" value="<?php echo $itemsPerInterval; ?>" /></td>
                <td><input type="text" name="interval" value="<?php echo $interval; ?>" /></td>
                <td><input type="submit" value="Change interval" class="btn btn-warning btn-sm" /></td>
            </tr>

        </table>
        
    </form>
    
</div>
-->
