var $ = require('jquery');
var Chart = require('chart.js');

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
    },
    initChart: function() {
        var ctx = document.getElementById('myChart').getContext('2d');
        console.log();
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: app.chartData.labels,
                fontSize: 18,
                datasets: [{
                    label: app.chartData.data[0].label,
                    data: app.chartData.data[0].data[0],
                    backgroundColor: app.chartData.data[0].backgroundColor
                }, {
                    label: app.chartData.data[1].label,
                    data: app.chartData.data[1].data[0],
                    backgroundColor: app.chartData.data[1].backgroundColor
                }]
            },
            options: {
                legend: {
                    labels: {
                        fontSize: 24
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            fontSize: 20
                        }
                    }]
                }
            }
        });
    }
};

module.exports = main;