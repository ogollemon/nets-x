<?php
$data = $this->requestAction('/players/listall');

if (!empty($data)){

    print '<ul>';
    foreach ($data as $Player){
        $player = $Player['Player']['nick'];
        $htmloptions = ($player==$active)?array('class'=>'active'):array();
        $link = $ajax->link(
            $player,
            '',
            array(
               'url' => 'view/'. $player,
               'update'=>'pda_right_container',
               
            ),
            null,
            false
        );
        print '<li>'.$link;
    }
    print '</ul>';

} else {

    print 'There was an error retrieving the players.';

}
?>