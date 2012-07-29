<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('Assessments', $admin.'assessments/');
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
//debug($data);
?>
<div class="padded">
<h1>Assessment questions</h1>

<?php
//debug($data);exit;
foreach ($data as $i=>$exam){ 
$examLink = $html->link(
      $exam['Exam']['name'],
      '#',
      array(
          'onClick'=>'javascript:toggleFold(\'assessments_'.$exam['Exam']['id'].'\');return false;'              
      ),
      null,
      false
    );
?>
<fieldset><legend><?php print $examLink; ?></legend>
<div id="<?php print 'assessments_'.$exam['Exam']['id']; ?>" style="display:none;">
<table width="100%" border="0">
<tr style="background">
<th width="300" >title</th>
<th width="100">action</th>
</tr>

<?php
foreach ($exam['Assessment'] as $i=>$assessment){
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
      print $html->link($html->image('icons/'.ICON_EDIT,array('style'=>'border:0px;')), '/assessments/edit/'.$assessment['id'],
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