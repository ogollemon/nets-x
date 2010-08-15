<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('topics', $admin.'topics/', array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>

<div class="padded">
<?php
//debug($data);exit;
print '<table border="0" width="100%">';

print '<tr><td align="right"><strong>add a new topic</strong></td>';
print '<td width="50" align="center">';
print $html->link($html->image('icons/'.ICON_ADD,array('style'=>'border:0px;')), 'edit/new',
       array(
                'title'=>'add a new topic',
                'alt'=>'add a new topic',
            )
        ,null,false);
print '</td></tr>';

print '<tr><td colspan="3" align="center">';

print '<table border="0" width="100%">';
   print '</tr>';
   $i = 0;
   foreach ($data as $topic){
       print '<tr><td align="center">&nbsp;</td></tr>';
       print '<tr><td align="center">';
       //now the table with the scenarios:
       print '<table border="0" width="100%">
       <th><h2>'.$topic['Topic']['name'].'</h2></th>
       <th width="220">action</th>';
       //debug($topic);exit;
     	
           $class = ($i%2 == 0)? 'even' : 'odd';
           print '<tr class="'.$class.'">';
           print '<td>'.$topic['Topic']['description'].'</td>';
           print '<td align="center">';
           print $html->link($html->image('icons/'.ICON_EDIT,array('style'=>'border:0px;')), 'edit/'.$topic['Topic']['id'],
                array(
                   'title'=>'edit topic',
                   'alt'=>'edit topic',
               )
           ,null,false);
           print '&nbsp;&nbsp;';
           print $html->link($html->image('icons/'.ICON_DELETE,array('style'=>'border:0px;')), 'delete/'.$topic['Topic']['id'],
                array(
                   'title'=>'delete topic, scenarios, and exams',
                   'alt'=>'delete topic',
               )
           ,'Do you really want to delete this topic?',false);
		         		 
           print '</td></tr>';
     
       print '</table></td></tr>';
       $i++;
   }
   
   print '</td></tr>';
print '</table>';

print '</td></tr></table>';

?>

<script type="text/javascript">
//<![CDATA[

    //listen to status of the radio buttons
    //1. the general resource option
    Element.observe(
        'keepScenarios',
        'click',
        function(event){ 
        //alert(Event.element(event).checked);  
        	if(!Event.element(event).checked){         
            	alert('Warning: the scenarios which belong to the topic will also be erased if the delete button is clicked!');
            }
        }
    );

//]]>
</script>
</div>