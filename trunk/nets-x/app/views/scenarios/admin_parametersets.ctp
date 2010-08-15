<?php
$this->pageTitle = 'Administration | Scenario parametersets';
//debug($scenario);exit;
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('scenarios', $admin.'scenarios/');
$html->addCrumb($this->data['Scenario']['name'], $admin.'scenarios/edit/'.$this->data['Scenario']['id']);
$html->addCrumb('parametersets', $admin.'scenarios/parametersets/'.$this->data['Scenario']['id'], array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>
<div class="padded">
   <h1>Parametersets for <em><?php print $this->data['Scenario']['name']; ?></em></h1>
   <p>Here you can define sets of parameters (variables) in the scenario's shell scripts which logically belong together.
   For example if <b>$CAKE1</b> is a username and <b>$CAKE2</b> is the password that goes along with it,
   create a parameterset here and assign the two parameters to this set.</p>
   <p>This ensures that the parameter values belonging together are assigned to a player.</p>
   
   <?php if (sizeof($unassigned)>0) { ?>
   <div id="addSet">
      <fieldset id="unassignedParams" style="border:1px solid #C33;"><legend class="error">unassigned parameters:</legend>
         <table border="0" width="100%" cellpadding="2">
         <?php
         $addImg = $html->image('icons/'.ICON_ADD);
         $addLink = $ajax->link($addImg,'#addParamSet',array(
               'update' => 'addSet',
               'url' => $admin.'/parametersets/add/'.$this->data['Scenario']['id'],
               'loading' => 'Element.hide(\'addSet\');Element.show(\'loading\');return false;',
               'loaded' => 'Element.hide(\'loading\');Element.show(\'addSet\');return false;',
               'title'=>'create new parameterset',
               'alt'=>'create new parameterset',
               ),
               null,
               false
           );
           $i=0;
         foreach($unassigned as $id=>$name){
            $class = ($i%2==0)? 'even' : 'odd';
            print '<tr class="'.$class.'">
            <td width="100" align="right"><strong>'.$name.'</strong>&nbsp;</td>
            <td>'. $this->data['Parameter'][$id]['description'] .'</td>
            </tr>';
            $i++;
         }
         ?>
         </table>
      </fieldset>
   </div>
   <div id="loading" class="padded" style="display:none">
       <p align="center"><?php print $html->image(ICON_LOADING); ?></p>
   </div>
   <?php print $addLink; ?><strong> create a new parameterset</strong>
   
   <?php } else { ?>
        <p><h3>There are no Parameters to assign to sets.</h3></p><br />
   <?php } ?>
   
   <p>&nbsp;</p>
   <fieldset><legend class="big">Existing parametersets:</legend>
   <?php
   $i=0;
   foreach($this->data['Parameterset'] as $id=>$set){
   $delImg = $html->image('icons/'.ICON_DELETE);
         $delLink = $html->link($delImg,$admin.'/parametersets/delete/'.$set['id'],array(
               'title'=>'delete parameterset',
               'alt'=>'delete parameterset',
               ),
               'Do you really want to delete this parameterset?',
               false
           );
   $class = ($i%2==0)? 'even' : 'odd';
   ?>
        <table border="0" width="100%">
        <tr class="<?php print $class; ?>">
            <td align="right" width="200"><h3><?php print $set['name']; ?>:&nbsp;</h3></td>
            <td>
                <table width="100%" border="0">
                <?php
                foreach ($set['Parameter'] as $param) {
                	print '<tr><td align="right" width="100"><b>'.$param['name'].'&nbsp;</b></td><td>'.$param['description'].'</td></tr>';
                }
                ?>
                </table>
            </td>
            <td width="24"><?php print $delLink; ?></td>
        </tr>
        </table>
        <br />
   <?php } ?>
   </fieldset>
   
   <?php 
   //this reports back to the scenarios controller:
   if (sizeof($unassigned)==0){
      print $form->create('Scenario', array('action'=>'parametersets/'));
      print $form->hidden('Scenario.complete', array('value'=>SCENARIO_PARAMETERSETS));
      print $form->submit('all parametersets are defined', array('class'=>'btn'));
      print $form->end();
   } 
   ?>
</div>