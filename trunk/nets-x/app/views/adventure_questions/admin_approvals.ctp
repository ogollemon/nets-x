<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('Question approvals', $admin.'adventureQuestions/approvals');
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
//debug($data);
?>
<div class="padded">
<h2>Overview of unpublished 2D adventure questions for NPCs</h2>

<table border="0" width="100%" cellspacing="5" cellpadding="5">
<?php //debug($data);exit; ?>
<?php foreach ($data as $data){ ?>
    <tr>
    <td width="24" align="center">
       <?php
       print $html->image('icons/'.ICON_PLAYER,array(
           'style'=>'border:0px;',
           'title'=>'submitted by: '.$data['AdventureQuestion']['nick'],
           'alt'=>'submitted by: '.$data['AdventureQuestion']['nick'])
       );
       ?>
       <br /><span style="font-size:10px;"><?php print $data['AdventureQuestion']['nick']; ?></span>
    </td>
    
    <td>
       <strong><?php print $data['AdventureQuestion']['text']; ?></strong>
       <fieldset><legend><?php
           print $html->link('Answers',
               '#',
               array(
                   'onClick'=>'javascript:toggleFold(\'answers_'.$data['AdventureQuestion']['id'].'\');return false;'
               )
           );
       ?></legend>
       <div id="answers_<?php print $data['AdventureQuestion']['id']; ?>" class="box" style="display:none;">
       <table border="0" cellspacing="2" cellpadding="2" width="100%">
           <?php
          foreach($data['AdventureAnswer'] as $answer){
              $correct = ($answer['is_true'])?
                  $html->image('icons/'.ICON_TRUE,array('alt'=>'true', 'title'=>'true')) :
                  $html->image('icons/'.ICON_FALSE,array('alt'=>'false', 'title'=>'false')) ;
              print '<tr><td class="even">'.$correct.' '.$answer['text'].'</td></tr>';
          }
          ?>
       </table>
       <table border="0" width="100%">
          <tr><td>
          <form id="AdventureQuestion_<?php print $data['AdventureQuestion']['id']; ?>" action="<?php print $html->url('saveRemark'); ?>" method="post" style="margin:0px; padding:0px;">
          <?php
          print $form->hidden('AdventureQuestion.id', array('value'=>$data['AdventureQuestion']['id']));
          print $form->label('AdventureQuestion.remark','remarks: ').'<br />';
          print $form->textarea('AdventureQuestion.remark', array('rows'=>5, 'cols'=>50, 'value'=>$data['AdventureQuestion']['remark']));
          print $form->submit('save remark', array('class'=>'btn'));
          print $form->end();
          ?>
          </td>
      
          <td width="24" align="center">
          <form id="approve_<?php print $data['AdventureQuestion']['id']; ?>" action="<?php print $html->url('approve'); ?>" method="post" style="margin:0px; padding:0px;">
          <?php
          print $form->hidden('AdventureQuestion.id', array('value'=>$data['AdventureQuestion']['id']));
          print $form->hidden('AdventureQuestion.nick', array('value'=>$data['AdventureQuestion']['nick']));
          print $form->submit('icons/'.ICON_APPROVE,array(
              'style' =>'border:0px;',
              'title' =>'approve, publish and award score to player',
              'alt'   =>'approve, publish and award score to player',
          ));
          print 'approve';
          print $form->end();
          ?>
          </td></tr>
       </table>
       </div>
       </fieldset>

    </td>
    
    
    <td width="50" style="font-size:10px;" align="center">
        <?php print str_replace(' ', '<br />',$data['AdventureQuestion']['modified']); ?>
    </td>
  </tr>
<?php } ?>
</table>
</div>