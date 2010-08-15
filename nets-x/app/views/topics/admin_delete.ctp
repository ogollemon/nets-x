<?php ?>

<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('topics', $admin.'topics/', array('class'=>'active'));
$html->addCrumb($this->data['Topic']['name'], $admin.'topics/delete/'.$this->data['Topic']['id']);
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>

<div class="padded">
<?php
//debug($data);exit;
print '<table border="0" width="100%">';

print '<tr><td align="right">&nbsp;</td>';
print '<td width="50" align="center">&nbsp;';
print '</td></tr>';

print '<tr><td colspan="3" align="center">';

print '<table border="0" width="100%">';
   print '</tr>';
       print '<tr><td align="center"><h2>'.$data['Topic']['name'].'</h2></td></tr>';
       print '<tr><td align="center">';
       //now the table with the scenarios:
       print '<table border="1" width="100%">
       <th>Description</th>
       <th width="220">options</th>';
       //debug($topic);exit;
     	
          
           print '<tr class="even">';
           print '<td>'.$data['Topic']['description'].'</td>';
           print '<td align="center">';
    
           print '&nbsp;&nbsp;';          
           
           print '<div id="keepScenarios">';
           print $form->create('Topic', array('action'=>'delete/' . $data['Topic']['id']));
           print $form->input('Topic.KeepScenarios', array('type'=>'checkbox', 'label'=>false, 'checked'=>'checked'));
           
		   print 'keep scenarios</div>';
		   print '<br />';
		   print $form->submit('Delete', array('class'=>'btn'));      		 
           print '</td></tr>';
     
       print '</table></td></tr>';
 
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