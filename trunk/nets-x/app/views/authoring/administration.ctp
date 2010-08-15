<?php
$this->pageTitle = 'Administration'; 
$admin = '/'.Configure::read('Routing.admin').'/';
$role = $session->read('Player.role');
$roleText = ($role<ROLE_TUTOR)? 'author' : 'tutor';
$limitation = ($role<ROLE_TUTOR)? ' (You may only edit your own scenarios)' : '';
?>
<div class="padded">
<h1>Game administration (<?php print $roleText; ?>)</h1>
<?php print '<a href="'.$html->url('/').'"><span>back to game</span></a>'; // erstmal provisorischer link ?>
<table border="0" width="80%" cellspacing="4">

<?php if ($role>=ROLE_TUTOR){ ?>
<tr>
   <td width="42">
   <?php print $html->image('icons/'.ICON_GLOBAL, array(
                'title'=>'Global administration',
                'alt'=>'Global administration',
            ));
   ?>
   </td>
   <td align="left" class="linklist">
   <ul>
   <?php print
   '<li>'.$html->link('Topics administration', $admin.'/topics/',
       array(
                'title'=>'Topics administration',
                'alt'=>'Topics administration',
            )
   ).'</li>';
   print
   '<li>'.$html->link('Hosts administration', $admin.'/hosts/',
       array(
                'title'=>'Hosts administration',
                'alt'=>'Hosts administration',
            )
   ).'</li>';
   print
   '<li>'.$html->link('Interface administration', $admin.'/settings/interfaces',
       array(
                'title'=>'Interface administration',
                'alt'=>'Interface administration',
            )
   ).'</li>';
   ?>
   </ul>
   </td>
</tr>
<?php } ?>

<tr>
   <td width="42">
   <?php print $html->image('icons/'.ICON_SCENARIOS, array(
                'title'=>'Scenarios administration',
                'alt'=>'Scenarios administration',
            ));
   ?>
   </td>
   <td align="left" class="linklist">
   <ul>
   <?php print
   '<li>'.$html->link('Scenario administration', $admin.'/scenarios/',
       array(
                'title'=>'Scenario administration',
                'alt'=>'Scenario administration',
            )
   ).$limitation.'</li>';
   ?>
   <?php 
   if ($role >= ROLE_TUTOR) {
       print
       '<li>'.$html->link('Running scenarios', $admin.'/game/',
           array(
                    'title'=>'Running scenarios',
                    'alt'=>'Running scenarios',
                )
       ).'</li>';
    }
    ?>
   </ul>
   </td>
</tr>

<tr>
   <td width="42">
   <?php print $html->image('icons/'.ICON_GAME, array(
                'title'=>'Adventure administration',
                'alt'=>'Adventure administration',
            ));
   ?>
   </td>
   <td align="left" class="linklist">
   <ul>
   <?php
   print
   '<li>'.$html->link('State Machine Editor (story + NPC administration)', $admin.'/adventure/smEditor/',
       array(
                'title'=>'State Machine Editor',
                'alt'=>'State Machine Editor',
            )
   ).'</li>';
   print
   '<li>'.$html->link('Administer questions', $admin.'/adventure_questions/',
       array(
                'title'=>'Administer questions',
                'alt'=>'Administer questions',
            )
   ).'</li>';
   print
   '<li>'.$html->link('Questions pending approval', $admin.'/adventure_questions/approvals',
       array(
                'title'=>'Questions pending approval',
                'alt'=>'Questions pending approval',
            )
   ).'</li>';
   ?>
   </ul>
   </td>
</tr>

<?php if ($role >= ROLE_TUTOR){ ?>
<tr>
   <td width="42">
   <?php print $html->image('icons/'.ICON_PLAYER, array(
                'title'=>'Player administration',
                'alt'=>'Player administration',
            ));
   ?>
   </td>
   <td align="left" class="linklist">
   <ul>
   <?php
   print
   '<li>'.$html->link('Player administration', $admin.'/players/',
       array(
                'title'=>'Player administration',
                'alt'=>'Player administration',
            )
   ).'</li>';
   print
   '<li>'.$html->link('System accounts administration', $admin.'/systemaccounts/',
       array(
                'title'=>'System accounts administration',
                'alt'=>'System accounts administration',
            )
   ).'</li>';
   ?>
   </ul>
   </td>
</tr>

<tr>
   <td width="42">
   <?php print $html->image('icons/'.ICON_WIKI, array(
                'title'=>'Wiki administration',
                'alt'=>'Wiki administration',
            ));
   ?>
   </td>
   <td align="left" class="linklist">
   <ul>
   <?php
   print
   '<li>'.$html->link('Administer wiki articles', $admin.'/wiki/',
       array(
                'title'=>'Administer wiki articles',
                'alt'=>'Administer wiki articles',
            )
   ).'</li>';
   print
   '<li>'.$html->link('Articles pending approval', $admin.'/wiki/approvals',
       array(
                'title'=>'Articles pending approval',
                'alt'=>'Articles pending approval',
            )
   ).'</li>';
   ?>
   </ul>
   </td>
</tr>

<tr>
   <td width="42">
   <?php print $html->image('icons/'.ICON_ASSESSMENTS, array(
                'title'=>'Exams administration',
                'alt'=>'Exams administration',
            ));
   ?>
   </td>
   <td align="left" class="linklist">
   <ul>
   <?php
   print
   '<li>'.$html->link('Administer assessment questions', $admin.'/assessments/',
       array(
                'title'=>'Administer assessment questions',
                'alt'=>'Administer assessment questions',
            )
   ).'</li>';
   print
   '<li>'.$html->link('Assessments pending approval', $admin.'/assessments/approvals',
       array(
                'title'=>'Assessments pending approval',
                'alt'=>'Assessments pending approval',
            )
   ).'</li>';
   ?>
   </ul>
   </td>
</tr>

<tr>
   <td width="42">
   <?php print $html->image('icons/'.ICON_DEBUGMODE, array(
                'title'=>'Switch to Debugmode',
                'alt'=>'Switch to Debugmode',
            ));
   ?>
   </td>
   <td align="left" class="linklist">
   <ul>
   <?php
   print
   '<li>'.$html->link('Switch the debug mode', $admin.'/settings/toggledebug',
       array(
                'title'=>'Switch the debug mode',
                'alt'=>'Switch the debug mode',
            )
   ).'</li>';
   ?>
   </ul>
   </td>
</tr>

<?php } ?>

</table>
</div>