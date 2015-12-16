SPODPR = {};

SPODPR.textLinkCard = function (e)
{
    var cardData = {
        comment : e.detail.data.comment,
        content : e.detail.data.type == 'text' ? e.detail.data.text : e.detail.data.link,
        title   : e.detail.data.cardTitle,
        type    : e.detail.data.type,
        id      : e.detail.data.getAttribute("card-id") == null ? '' : e.detail.data.getAttribute("card-id")
    };

    $.ajax({
        type: 'post',
        url: SPODPR.ajax_text_link_card,
        data: cardData,
        dataType: 'JSON',
        success: function(data){
            previewFloatBox.close();
            if(cardData.id == "")
                add_card(cardData, data.id);
            else
                replace_text_link_card(cardData, data.id)
        },
        error: function( XMLHttpRequest, textStatus, errorThrown ){
            OW.error(textStatus);
        },
        complete: function(){}
    });

};

SPODPR.openOde = function ()
{
    SPODPR.dataletOpened = undefined;
    SPODPR.cardOpened = undefined;
    ODE.pluginPreview = 'private-room';
    previewFloatBox = OW.ajaxFloatBox('ODE_CMP_Preview', {text:'testo'} , {width:'90%', height:'85vh', iconClass: 'ow_ic_add', title: ''});
};

SPODPR.openModOde = function ()
{
    ODE.pluginPreview = 'private-room';
    previewFloatBox = OW.ajaxFloatBox('ODE_CMP_Preview', {text:'testo'} , {width:'90%', height:'85vh', iconClass: 'ow_ic_add', title: ''});
};

SPODPR.openCardCreator = function (type)
{
    var params = {type:type};
    previewFloatBox = OW.ajaxFloatBox('SPODPR_CMP_CardCreator', {type:params} , {width:'70%', height:'70vh', iconClass: 'ow_ic_add', title: ''});
};

$(document).ready(function () {

    document.addEventListener('paper-card-controllet_details-clicked', function(e) {

        switch(e.detail.data.getAttribute("card-type"))
        {
            case 'datalet' :
                SPODPR.cardOpened = e.detail.data.getAttribute("card-id");
                SPODPR.dataletOpened = e.detail.data.getAttribute("datalet-id");
                ODE.pluginPreview = 'private-room';

                SPODPR.ControlletPresets =
                {
                    'selected-fields': e.detail.data.getAttribute("fields"),
                    'selected-datalet': e.detail.data.getAttribute("datalet").replace("-datalet", ""),
                    'datalet-preset': e.detail.data.getAttribute("preset")
                };

                SPODPR.openModOde();
                break;

            case 'text'    :
                var params = {type:e.detail.data.getAttribute("card-type"),
                    title:e.detail.data.getAttribute("card-title"),
                    content:e.detail.data.$.content.textContent,
                    comment:e.detail.data.getAttribute("comment"),
                    cardId:e.detail.data.getAttribute("card-id")};

                previewFloatBox = OW.ajaxFloatBox('SPODPR_CMP_CardCreator', {params:params},
                    {width:'70%', height:'70vh', iconClass: 'ow_ic_add', title: ''});
                break;

            case 'link'    :
                var params = {type:e.detail.data.getAttribute("card-type"),
                    title:e.detail.data.getAttribute("card-title"),
                    link:e.detail.data.getAttribute("card-link"),
                    comment:e.detail.data.getAttribute("comment"),
                    cardId:e.detail.data.getAttribute("card-id")};

                previewFloatBox = OW.ajaxFloatBox('SPODPR_CMP_CardCreator', {params:params},
                    {width:'70%', height:'70vh', iconClass: 'ow_ic_add', title: ''});
                break;

            default        : break

        }

    });

    document.addEventListener('create-card-controllet_button-clicked', function(e) {
        previewFloatBox.close();
    });

    document.addEventListener('paper-card-controllet_delete-clicked', function(e) {

        if(confirm("Delete ?"))
        {
            var id = e.detail.data.getAttribute("card-id");
            var type = e.detail.data.getAttribute("card-type");

            var deleteCard = {"id": id, "type": type};

            $.ajax({
                type: 'post',
                url: SPODPR.ajax_delete_card,
                data: deleteCard,
                dataType: 'JSON',
                success: function (data) {
                    remove_card(e.detail.data);
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    OW.error(textStatus);
                },
                complete: function () {
                }
            });
        }

    });

    document.addEventListener('create-card-controllet_add-clicked', function(e){
        SPODPR.textLinkCard(e);
    });

    document.addEventListener('search-panel-controllet_content-changed', function(e){

        var cards = document.querySelectorAll('paper-card-controllet');
        for(var i=0; i < cards.length; i++)
        {
            var title   = cards[i].cardTitle;
            var comment = cards[i].comment;
            var type    = cards[i].cardType;

            var searchFlag = title.indexOf(e.detail.searchKey) == -1 && comment.indexOf(e.detail.searchKey) == -1 && type.indexOf(e.detail.searchKey) == -1;

            if(!searchFlag || e.detail.searchKey == "")
            {
                cards[i].style.display = "inline-block";
            }
            else
            {
                cards[i].style.display = "none";
            }
        }

        $('.grid').masonry();
    });

});