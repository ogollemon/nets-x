<?php
    print $form->create('AdventureNpc', array('action'=>'/'.Configure::read('Routing.admin').'adventure/editNpc'));
    //print $form->inputs( array('id','npcid','name','xml_data') );
    print $form->input('AdventureNpc.npcid', array('label'=>'NPC id:', 'type'=>'text', 'size' => '5', 'value'=>'', 'error' => array('required'=>'please enter an npc id (number).')));

    print $form->input('AdventureNpc.name', array('label'=>'Name:', 'type'=>'text', 'size' => '25', 'value'=>'', 'error' => array('required'=>'please enter a name.')));

    print $form->input('AdventureNpc.xml_data', array('label'=>'XML data:', 'type'=>'textarea', 'rows' => '20', 'cols' => '60',  'value'=>''));

    print $form->submit('Save');
    print $form->end();
?>

