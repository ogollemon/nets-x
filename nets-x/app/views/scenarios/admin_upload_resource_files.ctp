<?php 
//debug($data);exit;
//debug($shell_params);exit;
    //general resource files for the scenario

    print '<fieldset style="background:#CCC;"><legend><strong>general resource files for the scenario:</strong></legend>';
    print '<table width="100%" border="0">';

    print $form->create('Attachment',array('type'=>'file', 'method'=>'post', 'id' => 'form', 'action'=>'uploadResourceFiles/' . $scenario_id));
    print '<tr><td valign="top"><label>File:</label><br /><input type="file" name="userfile"></td>
    <td>'.$form->submit('Upload file') . '</td></tr>';
    print '<tr><td>enter attachment explanation
    <br />'.$form->input('Attachment.explanation', array('label'=>false, 'value'=>''));
    print $form->hidden('MAX_FILE_SIZE', array('name'=>'MAX_FILE_SIZE', 'value'=>2000000)).'</td></tr>';
    print '<tr><td>'.$form->hidden('ParameterValue.value', array('label'=>'none', 'value'=>0)).'</form></td></tr>';
    print '</table></fieldset>'."\n\n";

    for($i=0; $i<sizeof($shell_params); $i++){
        print '<fieldset style="background:#EEC;"><legend><strong>'.$shell_params[$i].'</strong></legend>';
        print '<table width="100%" border="0">';

        print $form->create('Attachment',array('type'=>'file', 'method'=>'post', 'id' => 'form' . $i, 'action'=>'uploadResourceFiles/' . $scenario_id));

        print '<tr><td valign="top"><label>File:</label><br /><input type="file" name="userfile"></td>
        <td rowspan="2">'.$form->submit('Upload file').'</td></tr>';
        print '<tr><td>enter attachment explanation<br />'.$form->input('Attachment.explanation', array('label'=>false, 'value'=>''));
        print $form->hidden('MAX_FILE_SIZE', array('name'=>'MAX_FILE_SIZE', 'value'=>2000000)).'</td></tr>';
        print '<tr><td><label>associate with parameter value:</label><br />'.$form->select('ParameterValue.value', $parameterValues[$i], null, array('label'=>'none')).'</form></td></tr>';
        print '</table></fieldset>'."\n\n";
    }

    print $html->link('Show Scenario Overview','index');

?>