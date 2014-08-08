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
            testEach_Rm();
            $(document).ready( function(){
                setInterval(testEach_Rm ,30*1000);
            });
        </script>



        <script type="text/javascript">
        var nodesCode = $('.batCode')
            $.each( nodesCode, function( nodeCode ) {
                var currentThis=$(this);
                $(this).data('code', function(x){
                    var rmNode = currentThis.data('varconf');
                    console.log(rmNode,currentThis.data());
// afichage en blanc sur fond noir
var install_code = "\n\
# DOS – Batch XP+\n\
# Creaton du port GZ\n\
cscript C:\\Windows\\System32\\Printing_Admin_Scripts\\fr-FR\\prnport.vbs -a -o raw -h %vps% -r \"GZ_%vps%_%port%\" -n %port%\n\
# Creaton du port de secour en direct\n\
cscript C:\\Windows\\System32\\Printing_Admin_Scripts\\fr-FR\\prnport.vbs -a -o raw -h %imp% -r \"DIRECT_%imp%_%port%\"\n\
# Install du driver\n\
cscript C:\\Windows\\System32\\Printing_Admin_Scripts\\fr-FR\\Prndrvr.vbs -a -m \"MS Publisher Color Printer\"\n\
# Creation de l’objet imprimante\n\
cscript C:\\Windows\\System32\\Printing_Admin_Scripts\\fr-FR\\Prnmngr.vbs -a -p \"%name%\" -r \"GZ_%vps%_%port%\" -m \"MS Publisher Color Printer\"\n\
# ajout des infos : emplacement et commentaire\n\
cscript C:\\Windows\\System32\\Printing_Admin_Scripts\\fr-FR\\Prncnfg.vbs -t -p \"%name%\" -l \"%site%\" -m \"GZ par tunnel SSH (%UTC%)`n%imp% par le canal %port%\"\n\
";
                    return install_code
                        .replace(/%vps%/g, rmNode['vps'])
                        .replace(/%imp%/g, rmNode['imp'])
                        .replace(/%port%/g, rmNode['port'])
                        .replace(/%site%/g, rmNode['site'])
                        .replace(/%name%/g, rmNode['channelComment'])
                        .replace(/%UTC%/g, new Date().toString().slice(0,24));}()
                )

            $(this).click(function(){
                    alert($(this).data('code'));
            })
        });


        var nodesCode = $('.ps1Code')
            $.each( nodesCode, function( nodeCode ) {
                var currentThis=$(this);
                $(this).data('code', function(x){
                    var rmNode = currentThis.data('varconf');
                    console.log(rmNode,currentThis.data());
// affichage en blanc sur fond bleu foncé
var install_code = "\n\
# Powershell V4+ Windows 2012R2\n\
# Creaton du port\n\
Add-PrinterPort -Name \"GZ_%vps%_%port%\" -PrinterHostAddress \"%vps%\" -PortNumber %port%\n\
# Creaton du port de secour en direct\n\
Add-PrinterPort -Name \"DIRECT_%imp%_%port%\" -PrinterHostAddress \"%imp%\"\n\
# Install du driver\n\
if (Get-PrinterDriver -Name \"MS Publisher Color Printer\") {\n\
    Write-Host \"Pilote Generique deja present\"\n\
} else {\n\
    Write-Host \"Installation du pilote generique : MS Publisher Color Printer\"\n\
    Add-PrinterDriver \"MS Publisher Color Printer\"\n\
}\n\
# Creation de l’objet imprimante\n\
Add-Printer -name \"%name%\" -PortName \"GZ_%vps%_%port%\" -Location \"%site%\" -Comment \"GZ par tunnel SSH (%UTC%)\"  -DriverName \"MS Publisher Color Printer\"\n\
";
                    return install_code
                        .replace(/%vps%/g, rmNode['vps'])
                        .replace(/%imp%/g, rmNode['imp'])
                        .replace(/%port%/g, rmNode['port'])
                        .replace(/%site%/g, rmNode['site'])
                        .replace(/%name%/g, rmNode['channelComment'])
                        .replace(/%UTC%/g, new Date().toString().slice(0,24));}()
                )

            $(this).click(function(){
                    alert($(this).data('code'));
            })
        });

</script>
    </body>
</html>
