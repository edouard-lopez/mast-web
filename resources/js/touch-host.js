var touch_host = function () {
    var tun = $('.tunnel')
        $.each(tun, function (tunnel) {
            var currentThis = $(this);
            var tunnelContents = currentThis.data('tunnel');
            var ch_str = '';
            if ( !($("h4.collapsed", currentThis)[0])) {
                // seulement si les channels sont visible
                ch_str = $.map(tunnelContents.channels, function (channel,i) {
                        var key = channel.remoteHost+':'+channel.remotePort;
                        $('#x'+MD5(key))
                            .removeClass('glyphicon-ok glyphicon-exclamation-sign')
                            .addClass('glyphicon-transfer')
                            .attr('data-original-title', 'Test in progress...');
                        return ','+key;
                    }).join();
            }
            $.getJSON('./resources/ajax/touch-host.php?hosts='+tunnelContents.remoteHost+':'+tunnelContents.remotePort+ch_str,
                function (jsonTouch) {
                    console.log(jsonTouch);
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
    setInterval(touch_host ,15*1000);
});