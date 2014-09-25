/**
 * User: ed8
 * Date: 7/27/14
 */

var instance = {
	apiCall: function (action) {
		console.info('x'+action);
		var request = $.ajax({
				url: "/api/"+action,
				cache: false
		});
		request.done(function(_) {
				console.log(_);
				$(".stdout").append(_);
		});

		request.fail(function(jqXHR, _) {
				console.error(jqXHR, _);
				$(".stdout").append(_);
		});
		return false;
	},

    /**
     * Don't block access if user is smart enough, i.e.
     * require 'im=smart' string in hash :)
     * @returns {instance}
     */
    overlay: function () {
        var reSmart = /im=smart/;
		var hash = window.location.hash;
        console.log(hash);
		if (hash !== '' && hash !== null && reSmart.exec(hash)) {
            $('#dangerous-area').hide();
        }

        return this;
    },

    /**
     * Attach event listener
     * @returns {instance}
     */
	init: function () {
		var self = this;

        this.overlay();

        $('.service .btn-action').on( "click", function() {
            self.apiCall(this.id);
        });
        $('#tunnels .btn-action').on( "click", function() {
            self.apiCall(this.id);
        });
        $('.btn-clear').on( "click", function() {
            $('.stdout').html('');
        });

        $('#accept-danger').on( "click", function() {
            $('#dangerous-area').hide();
        });

        $('.action').on('click', function() {
            console.log(this);
            if (! $(this).data('action') ) { console.error('no action'); return; }

            var action =  $(this).data('action') || '';
            var params = new Array();
            var desc, host, id, name, printer;

            switch (action) {
                case 'add-host':
                    params.push($(this).data('name') || '' );
                    params.push($(this).data('host') || '' );
                    $('#modal-add-host').modal();
                    break;
                case 'remove-host':
                    params.push($(this).data('name') || '' );
                    break;
                case 'add-channel':
                    params.push($(this).data('name') || '' );
                    params.push($(this).data('printer') || '' );
                    params.push($(this).data('desc') || '' );
                    $('#modal-add-channel').modal();
                    break;
                case 'remove-channel':
                    params.push($(this).data('name'));
                    params.push($(this).data('id'));
                    break;
                default:
                    console.error('invalid action: '+action);
                    return
            }
            var q = action+'/'+params.join(',');
            console.log(q);
            self.apiCall(q);
        });

        return this;
    }
};


(function (window, document, _) {
	_.init();
}(window, document, instance));
