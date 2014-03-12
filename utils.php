<?php

$vocabularyType = array();

$vocabularyType["unknown"] = "Don't really know!";
$vocabularyType["verb_ovat"] = "Verb -OVAT";
$vocabularyType["verb_at"] = "Verb -AT";
$vocabularyType["verb_et_et_it"] = "Verb -ET/-ĚT/-IT";
$vocabularyType["verb_irregular"] = "Verb Irregular";
$vocabularyType["noun_masculin"] = "Noun (M)";
$vocabularyType["noun_feminen"] = "Noun (F)";
$vocabularyType["noun_neutral"] = "Noun (N)";
$vocabularyType["noun"] = "Noun (Can't figure it out)";
$vocabularyType["adverb"] = "Adverb";
$vocabularyType["adjective"] = "Adjective";
$vocabularyType["sentense"] = "Sentence";

$vocabularyVerification = array();

$vocabularyVerification["confirmed"] = "Yeah, I got it!";
$vocabularyVerification["unconfirmed"] = "Please check this someone!";
$vocabularyVerification["debate"] = "Up for discussion";
$vocabularyVerification["corrected"] = "Fixed by someone smart!";

$searchResult = dbQuery("SELECT * FROM vocabulary ORDER BY cz DESC");

function isAuthenticated()
{
    if(isset($_SESSION["isAuthorized"]) && $_SESSION["isAuthorized"] == true)
    {
        return true;
    }
    
    return false;
}

function setIsAuthenticated($value)
{
    $_SESSION["isAuthorized"] = $value;
}

function isRequestMethod($method)
{
    if ($_SERVER['REQUEST_METHOD'] === strtoupper($method))
    {
        return true;
    }
    
    return false;
}

function getCurrentUser()
{
    $user = dbQuery("SELECT * FROM `user` WHERE id = '".$_SESSION["user_id"]."'");
    $user = mysql_fetch_array($user);
    
    return $user;
}

function getCurrentUserSettings()
{
    $user = getCurrentUser();
    
    return json_decode($user["settings"]);
}

function getClassUserFirstNames()
{
    $currentUser = getCurrentUser();
    
    $users = dbQuery("SELECT * FROM `user` WHERE `class` = '".$currentUser["class"]."'");
    
    $userFirstNames = array();
    
    while($user = mysql_fetch_array($users))
    {
        $userFirstNames[$user["id"]] = $user["firstname"];
    }
    
    return $userFirstNames;
}

?>