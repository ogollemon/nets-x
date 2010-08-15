<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('Adventure questions', $admin.'adventure_questions/');
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
//debug($data);
?>
<div class="padded">
<h1>Adventure questions</h1>

<?php
foreach ($data as $i=>$topic){ 
$topicLink = $html->link(
      $topic['Topic']['name'],
      '#',
      array(
          'onClick'=>'javascript:toggleFold(\'adventure_questions_'.$topic['Topic']['id'].'\');return false;'              
      ),
      null,
      false
    );
?>
<fieldset><legend><?php print $topicLink; ?></legend>
<div id="<?php print 'adventure_questions_'.$topic['Topic']['id']; ?>" style="display:none;">
<table width="100%" border="0">
<tr style="background">
<th width="300" >title</th>
<th width="100">action</th>
</tr>

<?php
foreach ($topic['AdventureQuestion'] as $i=>$assessment){
$trClass = ($i%2==0)? 'even' : 'odd';
?>
<tr class="<?php print $trClass; ?>">
   <td>
      <?php print $assessment['text']; ?>
   </td>
   
   <td width="96">
      <table border="0" width="100%">
      <tr>
      <td align="center"><?php
      if ($assessment['approvedBy']>0){
         $iconDisable = ICON_DISABLE;
         $statusText = 'disable';
         $status = 0;
      } else {
         $iconDisable = ICON_APPROVE;
         $statusText = 'enable';
         $status = '';
      }
      print $html->link($html->image('icons/'.$iconDisable), 'setApproved/'.$assessment['id'].'/'.$status,
                   array(
                      'title'=>$statusText,
                      'alt'=>$statusText,
                  )
              ,null,false);
      ?>
      </td>
      <td align="center"><?php
      print $html->link($html->image('icons/'.ICON_EDIT,array('style'=>'border:0px;')), 'edit/'.$assessment['id'],
                   array(
                      'title'=>'edit assessment',
                      'alt'=>'edit assessment',
                  )
              ,null,false);
      ?>
      </td>
      <td align="center"><?php
      print $html->link($html->image('icons/'.ICON_DELETE,array('style'=>'border:0px;')), 'delete/'.$assessment['id'],
                   array(
                      'title'=>'delete article',
                      'alt'=>'delete article',
                  )
              ,'Do you really want to delete this assessment question?',false);
      ?></td>
      </tr>
      </table>
   </td>

</tr>
<?php } //end of article foreach ?>

</table>
</div>
</fieldset>
<?php } //end of topic foreach ?>

</div>