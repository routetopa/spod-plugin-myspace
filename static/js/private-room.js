SPODPR = {};

/* ON ADD CARD */

    /* LINK and TEXT */
    SPODPR.openCardCreator = function (type)
    {
        var params = {type:type};
        previewFloatBox = OW.ajaxFloatBox('SPODPR_CMP_CardCreator', {type:params} , {top:'56px', width:'70vw', height:'70vh', iconClass: 'ow_ic_add', title: ''});
    };
    /* SILVER DECISIONS */
    SPODPR.openSilverDecisions = function ()
    {
        previewFloatBox = OW.ajaxFloatBox('SPODPR_CMP_SilverDecisionCreator', {} , {top:'56px', width:'calc(100vw - 112px)', height:'calc(100vh - 112px)', iconClass: 'ow_ic_add', title: ''});
    };
    /* DATALET */
    SPODPR.openOde = function ()
    {
        SPODPR.dataletOpened = undefined;
        SPODPR.cardOpened = undefined;
        ODE.pluginPreview = 'private-room';
        previewFloatBox = OW.ajaxFloatBox('ODE_CMP_Preview', {} , {top:'56px', width:'calc(100vw - 112px)', height:'calc(100vh - 112px)', iconClass: 'ow_ic_add', title: ''});
    };

/* ON ADD CARD */

SPODPR.dropdownTrigger = function ()
{
    if($("#addSD").css("opacity") == "0") {

        $("#addSD").addClass("opened");
        $("#addLink").addClass("opened");
        $("#addText").addClass("opened");
        $("#addDatalet").addClass("opened");
    } else {
        $("#addSD").removeClass("opened");
        $("#addLink").removeClass("opened");
        $("#addText").removeClass("opened");
        $("#addDatalet").removeClass("opened");
    }
}

SPODPR.textLinkCard = function (e)
{
    var cardData = {
        comment : e.detail.data.description,
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
        error: function( XMLHttpRequest, textStatus ){
            OW.error(textStatus);
        },
        complete: function(){}
    });
};

SPODPR.openModOde = function ()
{
    ODE.pluginPreview = 'private-room';
    previewFloatBox = OW.ajaxFloatBox('ODE_CMP_Preview', {component:'datalets-modifier-controllet'} , {top:'56px', width:'calc(100vw - 112px)', height:'calc(100vh - 112px)', iconClass: 'ow_ic_add', title: ''});
};

SPODPR.modifyCard = function (e)
{
    let cardId = e.target.parentElement.getAttribute('card-id');
    let cardType = e.target.parentElement.getAttribute('card-type');

    switch(cardType)
    {
        case 'datalet':
            let dataletId = e.target.parentElement.getAttribute('datalet-id');
            let dataletType = e.target.parentElement.getAttribute('datalet-type').replace("-datalet", "");
            let dataletPreset = e.target.parentElement.getAttribute('datalet-preset');

            SPODPR.cardOpened = cardId;
            SPODPR.dataletOpened = dataletId;
            ODE.pluginPreview = 'private-room';

            if(dataletType === "decision-tree")
            {
                let json_tree = JSON.parse(dataletPreset)["json-tree"];
                previewFloatBox = OW.ajaxFloatBox('SPODPR_CMP_SilverDecisionCreator', {json_tree:json_tree} , {top:'56px', width:'calc(100vw - 112px)', height:'calc(100vh - 112px)', iconClass: 'ow_ic_add', title: ''});
            }
            else
            {

                SPODPR.ControlletPresets =
                    {
                        'selected-datalet': dataletType,
                        'datalet-preset': dataletPreset
                    };

                SPODPR.openModOde();
            }
            break;

        case 'text':

        // .replace(/'/g, "&#39;");
            var title = $(e.target).next().next()[0].getAttribute('preview-title');
            var description = $(e.target).next().next()[0].getAttribute('preview-description');
            var text = $(e.target).next().next()[0].getAttribute('preview-content');


            var params = {
                type: cardType,
                title: title,
                comment: description,
                content: text,
                cardId: cardId
            };

            previewFloatBox = OW.ajaxFloatBox('SPODPR_CMP_CardCreator', {params:params}, {top:'56px',width:'70vw', height:'70vh', iconClass: 'ow_ic_add', title: ''});
            break;

        case 'link':
            var title = $(e.target).next().next()[0].getAttribute('preview-title');
            var description = $(e.target).next().next()[0].getAttribute('preview-description');
            var link = $(e.target).next().next()[0].getAttribute('preview-content');

            var params = {
                type: cardType,
                title: title,
                comment: description,
                link: link,
                cardId: cardId
            };

            previewFloatBox = OW.ajaxFloatBox('SPODPR_CMP_CardCreator', {params:params}, {top:'56px',width:'70vw', height:'70vh', iconClass: 'ow_ic_add', title: ''});
            break;

        default:
            break
    }
};

SPODPR.deleteCard = function (e)
{
    var cardId = e.target.parentElement.getAttribute('card-id');
    var cardType = e.target.parentElement.getAttribute('card-type');

    var dataletId = e.target.parentElement.getAttribute('datalet-id');

    if(confirm("Delete ?"))
    {
        var id = cardId;
        var type = cardType;
        var dataletId  = dataletId ? dataletId : '';

        var deleteCard = {"id": id, "type": type, "dataletId": dataletId};

        $.ajax({
            type: 'post',
            url: SPODPR.ajax_delete_card,
            data: deleteCard,
            dataType: 'JSON',
            success: function (data) {
                remove_card(cardId);
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                OW.error(textStatus);
            }
        });
    }
};

$(document).ready(function () {

    $('.card_container').masonry({
        // options
        itemSelector: '.card'
    });

    $('body').on('click', '.delete', function (e) {
        SPODPR.deleteCard(e);
    });

    $('body').on('click', '.modify', function (e) {
        SPODPR.modifyCard(e);
    });

    // $(".modify").on('click', SPODPR.modifyCard);
    // $(".delete").on('click', SPODPR.deleteCard);

    document.addEventListener('create-card-controllet_button-clicked', function(e) {
        previewFloatBox.close();
    });

    document.addEventListener('create-card-controllet_data', function(e){
        SPODPR.textLinkCard(e);
    });

    // document.addEventListener('search-panel-controllet_content-changed', function(e){
    //
    //     var cards = document.querySelectorAll('paper-card-controllet');
    //     for(var i=0; i < cards.length; i++)
    //     {
    //         var title   = cards[i].cardTitle;
    //         var comment = cards[i].comment;
    //         var type    = cards[i].cardType;
    //
    //         var searchFlag = title.indexOf(e.detail.searchKey) == -1 && comment.indexOf(e.detail.searchKey) == -1 && type.indexOf(e.detail.searchKey) == -1;
    //
    //         if(!searchFlag || e.detail.searchKey == "")
    //         {
    //             cards[i].style.display = "inline-block";
    //         }
    //         else
    //         {
    //             cards[i].style.display = "none";
    //         }
    //     }
    //
    //     $('.card_container').masonry();
    // });

    document.addEventListener('SilverDecisionsSaveEvent', function(e) {
        var json_tree = {"json-tree" : e.detail.replace("\n", "")};
        var data = {component:"decision-tree-datalet", data:"", fields:'', params:JSON.stringify(json_tree)};
        ODE.dataletParameters = data;
        ODE.privateRoomDatalet();
    });

});

function replace_text_link_card(data, id)
{
    var card = $("[card-id = " + id + "]");
    var mod_card = create_card(data, data.cardId, data.dataletId);

    card[0].setAttribute('preview-title', data.title);
    card[0].setAttribute('preview-description', data.comment);
    card[0].setAttribute('preview-content', data.content);
    card[0].innerHTML = mod_card.innerHTML;
}

function replace_datalet_card(data)
{
    var card = $("[card-id = " + data.cardId + "]");
    var mod_card = create_card(data, data.cardId, data.dataletId);

    card[0].setAttribute('datalet-preset', mod_card.getAttribute('datalet-preset'));
    card[0].innerHTML = mod_card.innerHTML;
}

function add_card(data, cardId, dataletId)
{
    var card = create_card(data, cardId, dataletId);
    $('.card_container').masonry().append(card).masonry('appended', card).masonry();

}

function remove_card(cardId)
{
    var card = $("[card-id = " + cardId + "]");
    $('.card_container').masonry('remove', card).masonry('layout');
}

function create_card(data, cardId, dataletId) {
    var card = document.createElement('div');
    card.setAttribute('class', 'card');
    card.setAttribute('card-id', cardId);
    card.setAttribute('card-type', data.type);

    var mod = document.createElement('div');
    mod.setAttribute('class', 'circle_button modify');
    card.appendChild(mod);

    var del = document.createElement('div');
    del.setAttribute('class', 'circle_button delete');
    card.appendChild(del);

    if (data["params"] != undefined) {

        var preview_datalet = document.createElement('preview-datalet');
        preview_datalet.setAttribute('datalet-id', dataletId);
        preview_datalet.setAttribute('datalet-type', data["component"]);
        //data["data"] to use cache
        var parameters = JSON.parse(data["params"]);
        for (var attr in parameters)
            preview_datalet.setAttribute(attr, parameters[attr]);

        card.appendChild(preview_datalet);
    }
    else {
        var preview_link = document.createElement('preview-link');
        preview_link.setAttribute('preview-type', data.type);
        preview_link.setAttribute('preview-title', data.title);
        preview_link.setAttribute('preview-description', data.comment);
        preview_link.setAttribute('preview-content', data.content);

        card.appendChild(preview_link);
    }

    return card;
}

