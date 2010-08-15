<?php 
// debug($data);exit;
// debug($params_evaluate);
// debug($params_cleanup);
// debug($params);
?>

<?php
print $form->create('Parameter', array('action'=>'edit/'.$scenario_id));

print '<table border="0" width="100%">';
print '<tr>';
//print htmlspecialchars(current($scripts));exit;
for ($i=0; $i<sizeof($scripts); $i++){
    $key=key($scripts);
    print '<td valign="top" style="border-style:solid; border-width:1px"><h2>'.$key.':</h2>'; 
    print $html->link($html->image('icons/24-message-info.png',array('style'=>'border:0px;')), '#',
             array(
                'onClick'=>'Effect.BlindDown(\'scripts_'.$i.'\');return false;',
                'title'=>'show shell script',
                'alt'=>'show shell script',
            )
        ,null,false);
    print '<div id="scripts_' . $i . '" style="display:none;">';
    print $html->link($html->image('icons/24-em-up.png',array('style'=>'border:0px;')), '#',
             array(
                'onClick'=>'javascript:Effect.BlindUp(\'scripts_'.$i.'\');return false;',
                'title'=>'hide shell script',
                'alt'=>'hide shell script',
            )
        ,null,false).'<br />';
    print '<span style="font-size:8px;">'.str_replace('\n','<br />',htmlspecialchars(current($scripts))).'</span></div></td>';
    next($scripts);
}

print '</tr></table>';

//debug($data);exit;
for($i=0; $i<sizeof($data['Parameter']); $i++){

    // prepare all parameter values in one string to be displayed in 
    // the textarea:
    $values = '';
    for ($j=0; $j<sizeof($data['Parameter'][$i]['ParameterValue']); $j++){
        $values .= $data['Parameter'][$i]['ParameterValue'][$j]['value'].chr(13).chr(10);
    }
    $values = substr($values, 0, -2);

    print '<fieldset style="background:#000;"><legend><strong>' .$data['Parameter'][$i]['name'].'</legend></strong>';

    print '<table width="100%" border="0" cellspacing="5" >';
    print '<tr>';
    print '<td valign="top" align="right" width="70">description: </td>';
    print '<td valign="top" width="300" colspan="4">'.$form->input($data['Parameter'][$i]['name'].'.description', array('label'=>false, 'id'=>$key,'value'=>$data['Parameter'][$i]['description'], 'size'=>50)).'</td>';
    print '</tr><tr>';
    print '<td align="right" valign="top">values:</td>';
    print '<td valign="top" width="300">'.$form->textarea($data['Parameter'][$i]['name'].'.values', array('label'=>false, 'id'=>$key,'value'=>$values, 'rows'=>7, 'cols'=>40)).'</td>';
    
    print '<td>&nbsp;</td>';
    // This is not needed right now. If needed, just uncomment!
    //print '<td valign="top" width="100">special characters to escape <br /> (separated by ";"): <br />' . $form->input($data['Parameter'][$i]['name'].'.special_chars', array('label'=>false, 'id'=>$key,'value'=>$data['Parameter'][$i]['special_chars'],'size'=>"10")).'</td>';
    print '<td valign="top" width="100">';
    $linked = $data['Parameter'];
    if (sizeof($linked)>1){ // linked parameters only make sense if > 1!
        print 'dependant parameters: <br />';
        for ($j=0; $j<sizeof($linked); $j++){
            $key2 = $linked[$j]['name'];
            if ($key2 != $data['Parameter'][$i]['name']){ //only link to other parameters
                $linkOptions = array('value'=>$linked[$j]['id']);
                if ($data['Parameter'][$i]['linked']==$linked[$j]['id']){
                    $linkOptions['checked'] = 'checked';
                }
                print $key2.':'.$form->checkbox($data['Parameter'][$i]['name'].'.linked]['.$linked[$j]['id'].']', $linkOptions).'<br />';
            }
            next($linked);
        }
    }
    print '</td>';

    $lockOptions = array(
        'id'=>'lock['.$data['Parameter'][$i]['name'].']',
        'value'=>'1');
    if ($data['Parameter'][$i]['lock']==1){
        $lockOptions['checked'] = 'checked';
    }
    print '<td valign="top"><div id="lock_" ' . $data['Parameter'][$i]['id'] . ' style="display:visible">lock:'.$form->checkbox($data['Parameter'][$i]['name'].'.lock', $lockOptions).'</div></td>';
    print '</tr>';
    print '</table>';

    print '</fieldset><br />';
}


print $form->submit('Save');

print '</form>';
?>
