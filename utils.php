<?php

$vocabularyType = array();

$vocabularyType["verb_ovat"] = "Verb -OVAT";
$vocabularyType["verb_at"] = "Verb -AT";
$vocabularyType["verb_et_et_it"] = "Verb -ET/-ĚT/-IT";
$vocabularyType["verb_irregular"] = "Verb Irregular";
$vocabularyType["verb_noun"] = "Noun";
$vocabularyType["verb_adjective"] = "Adjective";
$vocabularyType["unknown"] = "No idea!";

$searchResult = dbQuery("SELECT * FROM vocabulary ORDER BY cz DESC");

?>