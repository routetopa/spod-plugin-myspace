SPODPR = {};

SPODPR.addTextLinkCard = function (e)
{
    var cardData = {
        comment : e.detail.data.comment,
        content :  e.detail.data.type == 'text' ? e.detail.data.text : e.detail.data.link,
        title   : e.detail.data.title,
        type    : e.detail.data.type
    };

    $.ajax({
        type: 'post',
        url: SPODPR.ajax_add_text_link_card,
        data: cardData,
        dataType: 'JSON',
        success: function(data){
            previewFloatBox.close();
            add_card(cardData, data.id);
        },
        error: function( XMLHttpRequest, textStatus, errorThrown ){
            OW.error(textStatus);
        },
        complete: function(){}
    });

};

$(document).ready(function () {

    document.addEventListener('paper-card-controllet_details-clicked', function(e) {

        SPODPR.ControlletPresets =
        {
            'selected-fields'   : e.detail.data.getAttribute("fields"),
            'selected-datalet'  : e.detail.data.getAttribute("datalet").replace("-datalet", ""),
            'datalet-preset'    : e.detail.data.getAttribute("preset")
        };

        open_ode();

    });

    document.addEventListener('create-card-controllet_button-clicked', function(e) {
        previewFloatBox.close();
    });

    document.addEventListener('paper-card-controllet_delete-clicked', function(e) {

        var id   = e.detail.data.getAttribute("card-id");
        var type = e.detail.data.getAttribute("card-type");

        var deleteCard = {"id":id, "type":type};

        $.ajax({
            type: 'post',
            url: SPODPR.ajax_delete_card,
            data: deleteCard,
            dataType: 'JSON',
            success: function(data){
                remove_card(e.detail.data);
            },
            error: function( XMLHttpRequest, textStatus, errorThrown ){
                OW.error(textStatus);
            },
            complete: function(){}
        });

    });

    document.addEventListener('create-card-controllet_add-clicked', function(e){
        SPODPR.addTextLinkCard(e);
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