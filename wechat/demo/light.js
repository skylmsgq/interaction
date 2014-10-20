var count = '';
var red = 0,
    green = 0,
    blue = 0;
var airShow = false;
var humidity = 0,
    pm = 0;

$(document).ready(function() {
    setTimeout(function() {
        setInterval(function() {
            $.ajax({
                url: 'air.php',
                type: 'POST',
                data: {},
                dataType: 'json',
                error: function() {},
                success: function(data) {
                    humidity = parseInt(data['humidity']);
                    pm = parseInt(data['pm']);
                    //humidity = 50;
                    //pm = 50;
                    if (pm > 500) pm = 500;
                    $('#humidity span').text(humidity);
                    $('#pm span').text(pm);
                    $('#humidityProgress').text(humidity);
                    $('#pmProgress').text(pm);
                    $('#humidityProgress').animate({
                        height: humidity + '%'
                    });
                    $('#humidityProgress').css('background-color', 'rgb(17, ' + (155 - humidity) + ', 176)');
                    $('#pmProgress').animate({
                        height: pm / 5 + "%"
                    });
                    if (pm > 0 & pm < 51) {
                        $('#pmProgress').css('background-color', '#54F861');
                    } else if (pm < 101) {
                        $('#pmProgress').css('background-color', '#EBF854');
                    } else if (pm < 151) {
                        $('#pmProgress').css('background-color', '#F8A954');
                    } else if (pm < 201) {
                        $('#pmProgress').css('background-color', '#F85454');
                    } else if (pm < 301) {
                        $('#pmProgress').css('background-color', '#7A1E7A');
                    } else {
                        $('#pmProgress').css('background-color', '#4B1822');
                    }
                }
            });
        }, 500);
    }, 100);

    setTimeout(function() {
        setInterval(function() {
            $.ajax({
                url: 'light.php',
                type: 'POST',
                data: {},
                dataType: 'json',
                error: function() {},
                success: function(data) {
                    count = data['count'];
                    if (count > 100) count = 100;
                    red = Math.round(17 + count * 1.95);
                    green = Math.round(75 - count * 0.25);
                    blue = Math.round(176 - count * 1.4);
                    $('#lightProgress').css('height', count + '%').text(count).css('background-color', 'rgba(' + red.toString() + ',' + green.toString() + ',' + blue.toString() + ',0.9)');
                }
            });
        }, 500);
    }, 100);

    $(window).keyup(function() {
        if (airShow) {
            $('#air').fadeOut('fast', function() {
                $('#light').fadeIn('fast', function() {
                    airShow = false;
                });
            });
        } else {
            $('#light').fadeOut('fast', function() {
                $('#air').fadeIn('fast', function() {
                    airShow = true;
                });
            });
        }
    });

});