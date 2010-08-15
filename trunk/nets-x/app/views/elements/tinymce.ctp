<?php ?>
<script type="text/javascript">

// Creates a new plugin class and a custom button
tinymce.create('tinymce.plugins.WikiLinkPlugin', {
    createControl: function(n, cm) {
        switch (n) {
        case 'wikilink':
            var c = cm.createMenuButton('wikilink', {
                title : 'link to another Article',
                image : '<?php print $html->url('/'); ?>js/tiny_mce/plugins/wikilink/img/wikilink.gif',
                icons : false,
                onclick: function(){
                    //make wikilinkLayer visible:
                    //var sel = tinyMCE.activeEditor.selection.getContent({format : 'text'});
//                    new Ajax.Updater('wikilinkLayer', '<?php print $html->url('/wiki/links/');?>', { method: 'post' });
                    Effect.BlindDown('wikilinkLayer');
                    return false;
                }
            });
            // Return the new menu button instance
            return c;
        }
        return null;
    }
});

// Register plugin with a short name
tinymce.PluginManager.add('wikilink', tinymce.plugins.WikiLinkPlugin);



    tinyMCE.init({
        plugins : 'wikilink',
        mode : "exact",
        width: "100%",
        height: "290px",
	    elements : "elm4",
        theme : "advanced",
      	theme_advanced_buttons1 : "bold,italic,underline,separator,bullist,numlist,undo,redo,wikilink,link,unlink,image",
      	theme_advanced_buttons2 : "",
      	theme_advanced_buttons3 : "",
      	theme_advanced_toolbar_location : "top",
      	theme_advanced_toolbar_align : "left",
      	theme_advanced_statusbar_location : "bottom",
      	extended_valid_elements : "a[name|href|target|title|onclick],img[class|src|border=0|alt|title|hspace|vspace|width|height|align|onmouseover|onmouseout|name],hr[class|width|size|noshade],font[face|size|color|style],span[class|align|style]",
        convert_urls : false,
        setup : function(ed) {
            ed.onNodeChange.add(function(ed, cm, n, co) {
                    cm.setDisabled('wikilink', co && n.nodeName != 'A');
                    cm.setActive('wikilink', n.nodeName == 'A' && !n.name);
            });
        }
    });
    
</script>