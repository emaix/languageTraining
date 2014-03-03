<?php

$link = mysql_connect('localhost', 'czech', 'BDXRMfCVUAAmKnVS');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}

mysql_select_db("czech", $link);

function dbQuery($sql)
{
    global $link;
    
    if (!$result = mysql_query($sql, $link))
    {

        die('Error: ' . mysql_error());

    }
    
    return $result;
}

function dbExecute($sql)
{
    global $link;
    
    if (!mysql_query($sql, $link))
    {

        die('Error: ' . mysql_error());

    }
    
    
}

?>
