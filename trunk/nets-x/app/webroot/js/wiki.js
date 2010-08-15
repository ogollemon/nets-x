//
// This function ajax-updates the right PDA container with a wiki article
// with the provided id
//
function article(id, isEditable){
    Element.hide('article_body');
    Element.show('loading_article');
    if (isEditable==0) isEditable = '';
    new Ajax.Updater (
        'pda_right_container',
        '/nets-x/wiki/article/'+id+'/'+isEditable,
        {   
            asynchronous:true,
            evalScripts:true,
            requestHeaders:['X-Update', 'pda_right_container'],
            onComplete:function(){
                Elment.hide('loading_article');
                Element.show('article_body');
	        }
        }
    );
    //return true;
}

function newArticle(id, isEditable){
    Element.hide('article_body');
    Element.show('loading_article');
    if (isEditable==0) isEditable = '';
    //update the container in add.ctp with the function in the wiki controller
    new Ajax.Updater (
        'pda_right_container',
        '/nets-x/wiki/newArticle/' + isEditable,
        {   
            asynchronous:true,
            evalScripts:true,
            requestHeaders:['X-Update', 'pda_right_container'],
            onComplete:function(){
                Elment.hide('loading_article');
                Element.show('article_body');
	        }
        }
    );
    //return true;
}

//
// This function ajax-updates the right PDA container with a wiki article
// with the provided id
//
function adminLoadEditedArticle(id, isEditable){

    Element.hide('article_edited_'+ id);
    Element.show('loading_article_' + id);
    if (isEditable==0) isEditable = '';
    new Ajax.Updater (
        'article_container'+id,
        '/nets-x/wiki/editedArticle/'+id+'/'+isEditable,
        {   
            asynchronous:true,
            evalScripts:true,
            requestHeaders:['X-Update', 'article_container' + id],
            onComplete:function(){
                Element.hide('loading_article_' + id);
                Element.show('article_edited_' + id);
	        }
        }
    );
    //return true;
}

/* CUSTOM EFFECTS */

loadArticle = function(id, isEditable){
    article(id, isEditable);
    new Effect.Morph('pda_left_container',{style:'width:0px; padding:15px 0',duration:0.5,
         afterFinish: function(effect){
             Element.hide('pda_left_container');
             new Effect.Appear('showOverview', {duration:0.5});
         }
          });
    new Effect.Morph('pda_right_container',{style:'width:578px;',duration:0.6});
}

loadNewArticle = function(isEditable){
    newArticle(isEditable);
    new Effect.Morph('pda_left_container',{style:'width:0px; padding:15px 0',duration:0.5,
         afterFinish: function(effect){
             Element.hide('pda_left_container');
         }
          });
    Element.show('pda_right_container');
    new Effect.Morph('pda_right_container',{style:'width:578px;',duration:0.6});
}

adminLoadArticle = function(id, isEditable){
    article(id, isEditable);
    new Effect.Morph('pda_left_container',{style:'width:0px; padding:15px 0',duration:0.5,
         afterFinish: function(effect){
             Element.hide('pda_left_container');
             new Effect.Appear('showOverview', {duration:0.5});
         }
          });
    new Effect.Morph('pda_right_container',{style:'width:578px;',duration:0.6});
}

function showOverview(){
    Element.show('pda_left_container');
    new Effect.Fade('showOverview', {duration:0.5});
    new Effect.Morph('pda_left_container',{style:'width:260px; padding:15px', duration:0.6});
    new Effect.Morph('pda_right_container',{style:'width:270px;',duration:0.5});
}

function toggleFold(id){
    var opt = {duration:0.5};
    if ($(id).style.display=='none'){
        Effect.BlindDown(id, opt);
    } else {
        Effect.BlindUp(id, opt);
    }
}

/* END CUSTOM EFFECTS */

