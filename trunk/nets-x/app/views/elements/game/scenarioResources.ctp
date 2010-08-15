<?php
print '<fieldset>';
print '<legend class="big">Your resources for this scenario:</legend>';
print '<p>Here are the resources that you need to solve this scenario:</p>';
foreach($resources as $type){
   foreach($type as $id=>$resource){
      print '&raquo;&nbsp;'.$html->link($resource, '/resources/view/'.$id,
         array('target'=>'_blank')
      ).'<br />';
   }
}
print '</fieldset>';
print '<hr />';
?>