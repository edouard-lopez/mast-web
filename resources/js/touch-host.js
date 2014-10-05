var touch_host = function () {
    var tun = $('.tunnel')
        $.each(tun, function (tunnel) {
            var currentThis = $(this);
            var tunnelContents = currentThis.data('tunnel');
            var ch_str = $.map(tunnelContents.channels, function (channel,i) {
                    var key = channel.remoteHost+':'+channel.remotePort;
                    $('#x'+MD5(key))
                        .removeClass('glyphicon-ok glyphicon-exclamation-sign status-danger')
                        .addClass('glyphicon-transfer status-in-progress')
                        .attr('data-original-title', 'Test in progress...');
                    return key;
                }).join(',');

            ch_str = tunnelContents.remoteHost+':'+tunnelContents.remotePort+','+ch_str;
            // console.log('./resources/ajax/touch-host.php?hosts='+ch_str);
            $.getJSON('./resources/ajax/touch-host.php?hosts='+ch_str,
                function (jsonTouch) {
                    // console.log(jsonTouch);
                    $.each(jsonTouch, function(key, value) {
                        $('#x'+MD5(key))
                            .attr('class', value.status)
                            .attr('data-original-title', 'ping: '+value.ping+' ms<br> telnet: '+value.telnet+' ms');
                });
            });
        });
};

$(document).ready( function(){
    touch_host();
    setInterval(touch_host ,10*1000);
});