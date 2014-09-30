      <footer>
        <p>
            <?= date('Y') ?>,
            &copy; <?= $this->config->item('PROJECT.html') ?>
            under <a href="http://choosealicense.com/licenses/gpl-3.0/">GPLv3 license</a>.
        </p>
      </footer>
    </div> <!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="resources/js/vendor/jquery-1.11.0.min.js"><\/script>')</script>

        <script src="resources/js/vendor/bootstrap.min.js"></script>

        <script src="resources/js/main.js"></script>

        <script type="text/javascript">
                var testEach_Rm = function(){
                    var nodes = $('.remoteHost');
                    // console.log(nodes);
                    $.each( nodes, function( node ) {
                        var currentThis=$(this);
                        var rmNode = currentThis.data('rm');
                        // console.log(rmNode, './resources/ajax/touch-host.php?hosts='+rmNode['remoteHost']+':'+rmNode['remotePort']);

                        currentThis.removeClass('btn-success btn-info btn-warning btn-danger glyphicon-search glyphicon-remove-circle glyphicon-warning-sign glyphicon-ok-sign glyphicon-ok-circle');
                        currentThis.addClass('btn-default glyphicon-repeat');
                        $.getJSON('./resources/ajax/touch-host.php?hosts='+rmNode['remoteHost']+':'+rmNode['remotePort'],
                            function(json){
                                currentThis.removeClass('btn-default glyphicon-repeat');
                                currentThis.addClass(json[Object.keys(json)[0]]['status']);
                                currentThis.attr('title',Object.keys(json)[0]+'\nPing = '+json[Object.keys(json)[0]]['ping']+' ms\nTELNET = '+json[Object.keys(json)[0]]['telnet']+' ms\n');
                                // console.log(json);
                            });
                    });
                }
                setTimeout(testEach_Rm, 1000);
            $(document).ready( function(){
                setInterval(testEach_Rm ,30*1000);
            });
        </script>


    </body>
</html>
