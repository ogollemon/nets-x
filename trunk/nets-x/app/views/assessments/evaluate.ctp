<h2>Assessment evaluation:</h2>


<?php
$data = $_POST;
//debug($data);

print '<p>You completed '.$result['percent'].'% of the test.</p>';
if ($result['percent'] > 50){
    print '<p>Congratulations, you passed with '.$result['player'].'/'.$result['total'].' points!</p>';
} else {
    print '<p>You suck! Go learn some more.</p>';
}
?>