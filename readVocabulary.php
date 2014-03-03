<?php

$data = parse_ini_file("vocabulary.ini");
$vocabularyDataFilename = "vocabularyCollection.data";

$vocabularyCollection = null;

if(!file_exists($vocabularyDataFilename))
{
    $vocabularyCollection = new VocabularyCollection();
}
else
{
    $vocabularyCollection = unserialize($vocabularyDataFilename);
}

$vocabularyCollection->refresh($data);
$serializedData = serialize($vocabularyCollection);

$fh = fopen($vocabularyDataFilename, 'w') or die("can't open file");
fwrite($fh, $serializedData);
fclose($fh);

class VocabularyCollection
{
    private $collection = array();
    
    public function refresh($data)
    {
        
        
        foreach($data as $inCzech => $inEnglish)
        {
            $vocabulary = new Vocabulary($inCzech, $inEnglish);
            
            array_push($this->collection, $vocabulary);
        }
    }
}

class Vocabulary
{
    private $numberOfDisplays = 0;
    private $inCzech = "";
    private $inEnglish = "";
    
    public function __construct($inCzech, $inEnglish)
    {
        $this->inCzech = $inCzech;
        $this->inEnglish = $inEnglish;
    }
}

?>
