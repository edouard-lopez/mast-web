var touch_host = function () {
    var tun = $('.tunnel')
        $.each(tun, function (tunnel) {
            var currentThis = $(this);
            var tunnelContents = currentThis.data('tunnel');
            var ch_str = '';
            if ( !($("div:first h2:first.collapsed", currentThis)[0])) {
                // only if channels are visible
                ch_str = $.map(tunnelContents.channels, function (channel,i) {
                        var key = channel.remoteHost+':'+channel.remotePort+':'+channel.localPort;
                        $('#x'+MD5(key))
                            .removeClass('glyphicon-ok glyphicon-exclamation-sign')
                            .addClass('glyphicon-transfer status-in-progress')
                            .attr('data-original-title', 'Test in progress...');
                        return ','+key;
                    }).join();
            }
            $.getJSON('./resources/ajax/touch-host.php?hosts='+tunnelContents.remoteHost+':'+tunnelContents.remotePort+ch_str,
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
    $('.container-fluid div div h2')
        .addClass('collapsed');
    // console.log ('start', $('.container-fluid div div h2'));
    setInterval(touch_host ,20*1000);
});