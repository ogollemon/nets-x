<?php  
//debug($playedScenarios);
$this->layout = false; // because this is only called via ajax!
print '<table border="0">';

foreach($playedScenarios as $playedScenario){
print '<tr><td>&bull; ' . $playedScenario['PlayersScenario']['name'] . '</td></tr>';
}
print '</table>';
?>
