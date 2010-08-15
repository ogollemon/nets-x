<?php 
$this->layout = false;
print $this->element('pda_loading', array('id'=>'loading_article'));
?>

<div id="article_body" style="display:block;">
   <table border="0" width="100%">
   <tr>
   <td><h3><?php print $data['Article']['title']; ?></h3></td>
   <td width="24">
   <?php
   if ($isEditable){
      if ($data['Article']['editedBy']>0 && $session->read('Player.id')!=$data['Article']['editedBy']) {
         $editLink = $html->image('icons/'.ICON_WARNING, array('alt'=>'This article is pending approval.','title'=>'This article is pending approval.'));
      } else {
         $editLink = $html->link(
         $html->image('icons/'.ICON_EDIT),
         'edit/'.$data['Article']['id'],
         null,
         null,
         false
         );
      }
   } else {
      $editLink = '&nbsp;';
   }
   print $editLink;
   ?>
   </td>
   </tr>
   </table>
   
   <div id="contentItemFulltextLayer" style="opacity:#99999;">
   <?php
   	print '<br />'; 
   	print $data['Article']['text']; 
   ?>
   </div>
</div>