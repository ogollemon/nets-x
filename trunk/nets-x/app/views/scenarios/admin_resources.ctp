<?php
$admin = '/'.Configure::read('Routing.admin').'/';
$html->addCrumb('admin', $admin);
$html->addCrumb('scenarios', $admin.'scenarios/');
$html->addCrumb($scenario['Scenario']['name'], $admin.'scenarios/edit/'.$scenario['Scenario']['id']);
$html->addCrumb('resources', $admin.'scenarios/resources/'.$scenario['Scenario']['id'], array('class'=>'active'));
print '<div class="breadcrumb">'.$html->getCrumbs('&nbsp;&raquo;&nbsp;').'</div>';
?>

<div class="padded">
<h1>Resources for <em><?php print $scenario['Scenario']['name']; ?></em></h1>
<?php 
//debug($scenario);

print '<fieldset><legend>Define the type of the resource file(s):</legend>';
        
$linkGeneral = $ajax->link('upload general scenario resource file(s)',
    '/resources/editGeneralResources/0/' . $scenario['Scenario']['id'],
    array(
        'update'=>'generalresource',
        'url'=>'/resources/editGeneralResources/0/' . $scenario['Scenario']['id'],
        'loading'=>'$("loadingMain").show();$("subDiv").hide();$("systemaccounts").hide();$("parametersets").hide();',
        'loaded'=>'$("generalresource").show();$("loadingMain").hide();',
        'alt'=> 'upload general scenario resource file(s)',
        'title'=> 'upload general scenario resource file(s)',
        'id'=> 'linkGeneral'
    )
);
$linkParameterset = $html->link('assign resource file(s) to parameter set',
    '#',
    array(
        'alt'=> 'assign resource file(s) to parameter set',
        'title'=> 'assign resource file(s) to parameter set',
        'id'=> 'linkParameterset',
        'onclick'=>'$("parametersets").show();$("subDiv").hide();$("systemaccounts").hide();$("generalresource").hide();'
    )
);
$linkSystemaccount = $html->link('assign resource file(s) to systemaccount',
    '#',
    array(
        'alt'=> 'assign resource file(s) to systemaccount',
        'title'=> 'assign resource file(s) to systemaccount',
        'id'=> 'linkSystemaccounts',
        'onclick'=>'$("subDiv").hide();$("systemaccounts").show();$("generalresource").hide();$("parametersets").hide();',
    )
);

$showParametersets = ($this->data['Resource']['resource_type'] == 0)? 'display:none;' : '';
$showSystemaccounts = ($this->data['Resource']['resource_type'] == 0)? 'display:none;' : '';
?>

<table border="0" width="100%">
  <tr>
    <td width="60%"><?php print $linkGeneral; ?></td>
  </tr>
<?php if (!empty($parametersets)){ ?>
  <tr>
    <td width="60%"><?php print $linkParameterset; ?></td>
  </tr>
<?php
}
if (!empty($systemaccounts)){
?>
  <tr>
    <td width="60%"><?php print $linkSystemaccount; ?></td>
  </tr>
<?php } ?>
  
  
    <tr>
    <td>   
    <div id="parametersets" style="display:none;">
    <?php
        if(empty($parametersets)){
            print "no parametersets defined for this scenario. please choose option: upload general resource.";
        } else {
            print '<fieldset><legend>choose a parameterset:</legend>';
            foreach ($parametersets as $id=>$set){
               $link = $ajax->link(
                   $set,
                   '/resources/editParametersetResources/'.$id.'/'.$scenario['Scenario']['id'],
                   array(
                       'update'=>'subDiv',
                       'url'=>'/resources/editParametersetResources/'.$id.'/'.$scenario['Scenario']['id'],
                       'loading' => '$("subDiv").hide();$("generalresource").hide();$("systemaccounts").hide();$("loadingMain").show();',
                       'loaded' => '$("loadingMain").hide();$("subDiv").show();',
                       'alt'=> $set,
                       'title'=> $set,
                       'id'=> 'paramUploadLink'.$id
                   )
               );
               print $link.'<br />';
            }
            print '</fieldset>';
        }
     ?>
     </div>  
        
    <div id="systemaccounts" style="<?php print $showSystemaccounts; ?>"> 
    <?php       
        if(empty($systemaccounts)){
            print "no systemaccounts defined. please choose another option. ";
        } else {
           print '<fieldset><legend>choose a systemaccount:</legend>';
            foreach ($systemaccounts as $id=>$account){
               $link = $ajax->link(
                   $account,
                   '/resources/editSystemaccountResources/'.$id.'/'.$scenario['Scenario']['id'],
                   array(
                       'update'=>'subDiv',
                       'url'=>'/resources/editSystemaccountResources/'.$id.'/'.$scenario['Scenario']['id'],
                       'loading' => '$("subDiv").hide();$("generalresource").hide();$("parametersets").hide();$("loadingMain").show();',
                       'loaded' => '$("loadingMain").hide();$("subDiv").show();',
                       'alt'=> $account,
                       'title'=> $account,
                       'id'=> 'paramUploadLink'.$id
                   )
               );
               print $link.'<br />';
            }
            print '</fieldset>';
        }
     ?>
    </div>   
   
    </td>
    </tr>         

<tr><td>
    <div id="loadingMain" style="width:100%;text-align:center;display:none;">
       <p><?php print $html->image(ICON_LOADING); ?></p>
       <p>loading...</p>
    </div>
    
<div id="generalresource" style="display:none">
<!-- The form with the general resource upload field. The AJAXed content comes from the edit Function -->
</div>

<div id="subDiv" style="display:none">
<!-- The parameter values list with the resource upload fields. The AJAXed content comes from the edit Function -->
</div>

</td>
</tr>
<tr><td>
<?php
//this reports back to the scenario controller
print $form->create('Scenario', array('action'=>'resources/'.$scenario['Scenario']['id']));
print $form->hidden('Scenario.complete', array('value'=>SCENARIO_RESOURCES));
print $form->submit('all resources have been uploaded', array('class'=>'btn'));
?>
</td></tr>
</table>
<?php
//print $form->submit('submit', array('class'=>'btn')); 
print $form->end();
print '</fieldset>';
print '</div>';                 
?>