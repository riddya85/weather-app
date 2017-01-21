var $ = require('jquery');

var main = {
    init: function() {

    },
    initHistoryLoad: function () {
        $("#test").on('click',function() {
            var lastId = $(".last-id").last().val();
            $.ajax({
                type: "POST",
                url: app.apploadUserHistoryUrl,
                data: {
                    lastId: lastId,
                    _token: window.Laravel.csrfToken
                },
                success: function (data) {
                    data.items.forEach(function(item) {
                        $('.insert-before').before("<p><a href='"+item.link+"' class='item-link'>"+item.name+"</a></p><hr style='width: 60%'/>");
                    });
                    $('.last-id').last().after("<input type='hidden' class='last-id' value='"+data.lastId+"'>");
                },
                error: function (data) {
                    console.log(data);
                }
            });
        });
    }
};

module.exports = main;