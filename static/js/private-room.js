SPODPR = {};

SPODPR.addTextLinkCard = function (e)
{
    console.log(e);

    var cardData = {
        comment : e.detail.data.comment,
        content : e.detail.data.text,//link in caso di type link
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
            add_card(cardData);
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
        //console.log(e);
        previewFloatBox.close();
    });

    document.addEventListener('paper-card-controllet_delete-clicked', function(e) {
        console.log(e);
    });

});