<?php
$playerLink = $ajax->link(
            '<span>my PDA</span>',
            '',
            array(
               'url' => '/players/',
               'update'=>'pda_screen',
               'complete'=>'Element.hide(\'flashLayer\');Element.show(\'pda\');',
            ),
            null,
            false
        );

print '<ul>';
if(!($session->check('Player'))){ // User Menu if not logged in
   
    print '<li><a href="'.$html->url('/').'register"><span>register</span></a></li>';
    print '<li><a href="'.$html->url('/').'login"><span>login</span></a></li>';
    
} else { // player is logged in
   
    print '<li><a href="'.$html->url('/').'logout"><span>logout</span></a></li>';

    //only show this link if admin rights:
    if ($session->read('Player.role') >= ROLE_AUTHOR){
        print '<li><a href="'.$html->url('/').Configure::read('Routing.admin').'"><span>admin</span></a></li>';
    }
    print '<li><a href="'.$html->url('/').'authoring"><span>authoring</span></a></li>';
}
print '</ul>';
?>

