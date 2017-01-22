var $ = require('jquery');

var main = {
    init: function() {

    },
    initHistoryLoad: function () {
        $("#load").on('click',function() {
            var lastId = $(".last-id").last().val();
            var user = $(this).attr('data-user');

            $.ajax({
                type: "POST",
                url: app.uploadHistoryUrl,
                data: {
                    lastId: lastId,
                    user: user,
                    _token: window.Laravel.csrfToken
                },
                success: function (data) {
                    console.log(data);
                    if (data.template) {
                        $(data.template).hide().insertBefore('.insert-before').fadeIn(500);
                    } else {
                        $("#load").css('color','lightgray');
                        $("p.load-more__message").hide().html('No more results').fadeIn(500);
                    }
                },
                error: function (data) {
                    alert("Something is wrong! Inform developer please!");
                    console.log(data);
                }
            });
        });
    }
};

module.exports = main;