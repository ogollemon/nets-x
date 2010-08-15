<div class="padded">
<h1>My contribution to the game:</h1>
<?php print '<a href="'.$html->url('/').'"><span>back to game</span></a>'; // erstmal provisorischer link ?>
<table border="0" width="100%" cellspacing="2">
   <tr>
      <th align="center" width="33%" class="rightborder">
      <table width="100%">
         <tr>
         <th>
         <?php print $html->image('icons/'.ICON_WIKI); ?>        
         </th>
         <td class="linklist">
            <ul>
               <li><?php print $html->link( 'Submit a new article', '/wiki/add/'); ?></li>
               <li><?php print $html->link( 'Edit an existing article', '/wiki/index/'); ?></li>
            </ul>
         </td>
         </tr>
      </table>
      </th>
      
      <th align="center"  width="33%" class="rightborder">
      <table width="100%">
         <tr>
         <th>
         <?php print $html->image('icons/'.ICON_ASSESSMENTS); ?>        
         </th>
         <td class="linklist">
            <ul>
               <li><?php print $html->link( 'Submit an assessment', '/assessments/add'); ?></li>
            </ul>
         </td>
         </tr>
      </table>
      </th>
      
      <th align="center">
      <table width="100%">
         <tr>
         <th>
         <?php print $html->image('icons/'.ICON_GAME); ?>        
         </th>
         <td class="linklist">
            <ul>
               <li><?php print $html->link( 'Submit a question', '/adventure_questions/add/'); ?></li>
            </ul>
         </td>
         </tr>
      </table>
      </th>
   </tr>
   
   
   <tr>
      <td class="rightborder" style="vertical-align:top;">
        <div class="linklist">
        <h3>articles pending approval:</h3>
        <ul>
        <?php
        foreach ($articles as $article){
           $title = (strlen($article['title'])>25)? substr($article['title'],0,25).'...' : $article['title'];
           $aid = $article['id'];
           print '<li>'.$html->link(
                $title,
                '#',
                array(
                    'onClick'=>'javascript:toggleFold(\'article_'.$aid.'\');return false;',
                    'alt'=>$article['title'],
                    'title'=>$article['title']
                )
           ).'</li>';
           print '<div id="article_'.$aid.'" style="display:none;">';
           print '<fieldset class="grey"><legend>Tutor&acute;s remark:</legend>';
           print $article['remark'].'<br />';
           print $html->link('edit this article', '/wiki/edit/'.$aid);
           print '</fieldset></div>'; 
        }
        ?>
        </ul>
        </div>
      </td>
      
      
      <td style="border-right:1px solid #666;vertical-align:top;">
        <div class="linklist">
        <h3>Assessments pending approval:</h3>
        <ul>
        <?php
        foreach ($assessments as $assessment){
           $title = (strlen($assessment['text'])>25)? substr($assessment['text'],0,25).'...' : $assessment['text'];
           $aid = $assessment['id'];
           print '<li>'.$html->link(
                $title,
                '#',
                array(
                    'onClick'=>'javascript:toggleFold(\'assessment_'.$aid.'\');return false;',
                    'alt'=>$assessment['text'],
                    'title'=>$assessment['text']
                )
           ).'</li>';
           print '<div id="assessment_'.$aid.'" style="display:none;">';
           print '<fieldset class="grey"><legend>Tutor&acute;s remark:</legend>';
           print $assessment['remark'].'<br />';
           print $html->link('edit this assessment', '/assessments/edit/'.$aid);
           print '</fieldset></div>'; 
        }
        ?>
        </ul>
        </div>
      </td>
      
      
      <td style="vertical-align:top;">
        <div class="linklist">
        <h3>Questions pending approval:</h3>
        <ul>
        <?php
          //debug($questions);
          foreach ($questions as $question){
	           $title = (strlen($question['text'])>25)? substr($question['text'],0,25).'...' : $question['text'];
	           $aid = $question['id'];
	           print '<li>'.$html->link(
	                $title,
	                '#',
	                array(
	                    'onClick'=>'javascript:toggleFold(\'question_'.$aid.'\');return false;',
	                    'alt'=>$question['text'],
	                    'title'=>$question['text']
	                )
	           ).'</li>';
	           print '<div id="question_'.$aid.'" style="display:none;">';
	           print '<fieldset class="grey"><legend>Tutor&acute;s remark:</legend>';
	           print $question['remark'].'<br />';
	           print $html->link('edit this question', '/adventure_questions/edit/'.$aid);
	           print '</fieldset></div>'; 
        }
        ?>
        </ul>
        </div>
      </td>
   </tr>
</table>
</div>