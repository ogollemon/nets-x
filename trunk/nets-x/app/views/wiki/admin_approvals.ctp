<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('wiki approvals', $admin.'wiki/approvals');
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
//debug($data);
?>
<div class="padded">
<?php
//debug($topics);exit;
print '<h1>Overview of new/edited wiki articles</h1>';

print '<table border="0" width="100%" cellspacing="5" cellpadding="5">';
foreach ($data as $article){
    $isNew = ($article['Article']['approvedBy']==0);
    $iconStatus = ($isNew)?
        $html->image('icons/'.ICON_ARTICLE_NEW, array('alt'=>'new', 'title'=>'new')):    
        $html->image('icons/'.ICON_ARTICLE_DIRTY, array('alt'=>'edited', 'title'=>'edited'));
        
    $doneBy = ($isNew)? 'submitted by ' : 'edited by ';
    $origLink = $html->link(
      'Original',
      '#',
      array(
          'onClick'=>'javascript:toggleFold(\'article_original_'.$article['Article']['id'].'\');return false;'              
      ),
      null,
      false
    );
    
    $editedLink =  $html->link(
      'Edited',
      '#',
      array(
          'onClick'=>'javascript:toggleFold(\'article_edited_'.$article['Article']['id'].'\');return false;'            
      ),
      null,
      false
    );
    
    $actionsLink =  $html->link(
      'Actions',
      '#',
      array(
          'onClick'=>'javascript:toggleFold(\'article_actions_'.$article['Article']['id'].'\');return false;'            
      ),
      null,
      false
    );
    
    
   
   
   /* HEADLINE (Title) */
    print '<tr>
    <th width="24">'.$iconStatus.'</th>
    <th><h2>'.$article['Article']['title'].'</h2></th>
    <th width="100">'.$doneBy.'<i>'.$article['Article']['nick'].'</i><br />'.substr($article['Article']['modified'],0,10).'</th>
    </tr>';
   
    print '<tr>';
    
    
    print '<td colspan="3">';
    if (!$isNew){
       /* the original article */
       print '<fieldset><legend class="big">'.$origLink.'</legend>';
       print '<strong>Title: </strong>'.$article['Article']['title'].'<br />';
       print '<strong>Topic: </strong>'.$topics[$article['Article']['topic_id']].'<hr />';
       print '<div id="article_original_'.$article['Article']['id'].'" style="display:none;">';
       print $article['Article']['text'];
       print '<br />'.$html->link(
         'hide',
         '#',
         array(
             'onClick'=>'javascript:toggleFold(\'article_original_'.$article['Article']['id'].'\');return false;'              
         ),
         null,
         false
       );  
       print '</div>';
       print '</fieldset>';
    }
      
    /* the edited article */  
    print '<fieldset><legend class="big">'.$editedLink.'</legend>';
    print '<strong>Title: </strong>'.$article['Article']['edit_title'].'<br />';
    print '<strong>Topic: </strong>'.$topics[$article['Article']['edit_topic_id']].'<hr />';
    print '<div id="article_edited_'.$article['Article']['id'].'" style="display:none;">';
    print $article['Article']['edit_text'];
    print '<br />'.$html->link(
         'hide',
         '#',
         array(
             'onClick'=>'javascript:toggleFold(\'article_edited_'.$article['Article']['id'].'\');return false;'              
         ),
         null,
         false
       ); 
    print '</div>';
    print '</fieldset>';
    
   	
    /* The actions: */
   	print '<fieldset><legend class="big">'.$actionsLink.'</legend>';
   	print '<div id="article_actions_'.$article['Article']['id'].'" style="display:none;">';
    print '<table border="0" width="100%">';
    print '<tr><td>';    
    
    /*save remark*/
    print '<form id="Article_'.$article['Article']['id'].'" action="'.$html->url('saveRemark').'" method="post" style="margin:0px; padding:0px;">';
    print $form->hidden('Article.id', array('value'=>$article['Article']['id']));
    print $form->label('Article.remark','Remarks: ').'<br />';
    print $form->textarea('Article.remark', array('rows'=>5, 'cols'=>50, 'value'=>$article['Article']['remark']));
    print $form->submit('save remark', array('class'=>'btn'));
    print $form->end();
    print '</td></tr>';
	
	/*approve*/
    print '<tr><td width="24" align="center">';
    print '<form id="approve_'.$article['Article']['id'].'" action="'.$html->url('approve').'" method="post" style="margin:0px; padding:0px;">';
    print $form->hidden('Article.id', array('value'=>$article['Article']['id']));
    print $form->hidden('Article.nick', array('value'=>$article['Article']['nick']));
    print $form->hidden('Article.isNew', array('value'=>$isNew));//who will recieve the score?
    
    print $form->submit('icons/'.ICON_APPROVE,array(
        'style' =>'border:0px;',
        'title' =>'approve, publish and award score to player',
        'alt'   =>'approve, publish and award score to player',
    ));   
    print 'approve<br />';
    print $form->end();
    
    print '</td></tr></table>';
    print '</div>';
    print '</fieldset>'; /* End of article details */

    print '</td>';
    print '</tr>';
}

print '</table><br>';
?>
</div>