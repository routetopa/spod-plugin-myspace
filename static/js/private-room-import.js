SPODPR = {};

SPODPR.leftTrigger = function ()
{
    if($(".search_input").css("opacity") == "0") {
        $(".search_input").addClass("opened");
    } else {
        $(".search_input").removeClass("opened");
    }
}

SPODPR.init = function ()
{
    $('.card_container').masonry({
        // options
        itemSelector: '.card'
    });

    $( "#search" ).on('keyup', function() {
        var filter = this.value.toUpperCase();
        var cards = document.querySelectorAll('.card');
        for(var i=0; i < cards.length; i++)
        {
            let title = cards[i].children[2].getAttribute("preview-title").toUpperCase();
            if(title.indexOf(filter) > -1)
                cards[i].style.display = "inline-block";
            else
                cards[i].style.display = "none";
        }

        $('.card_container').masonry();
    });

    $('.import_card_container').on('click', '.card', function (e) {
        var card = $(e.target).closest('.card')[0];
        var myEvent = new CustomEvent('my-space_card-selected', {detail: card});
        window.dispatchEvent(myEvent);
    });

};