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

        $('.btn-clear').on( "click", function() {
            $('.stdout').html('');
        });

        $('#accept-danger').on( "click", function() {
            $('#dangerous-area').hide();
        });

        $('.btn-action').on('click', function() {
            data = $(this).data();
            delete data.target;
            if (! data.action ) { console.error('no action'); return; }

            var action =  data.action;
            var params = new Array();
            var desc, host, id, name, printer;
            var target_form = '#modal-' + action;

            switch (action) {
                //no special behavior, fallback to simple api call
                case 'start':
                case 'stop':
                case 'restart':
                case 'status':
                case 'list-hosts':
                case 'list-channels':
                case 'remove-host':
                case 'remove-channel':
                    break;
                // form in modal
                case 'add-host':
                    $(target_form)
                        .on('show.bs.modal', function (e) {
                            $(target_form+' .modal-title > .name')[0].textContent = data.name;
                            $(target_form+' .modal-body .name').val(data.name);
                        })
                        .modal();
                    return;
                case 'add-channel':
                    $(target_form)
                        .on('show.bs.modal', function (e) {
                            $(target_form+' .modal-title > .name')[0].textContent = data.name;
                            $(target_form+' .modal-body .name').val(data.name);
                        })
                        .modal();
                    return;
                default:
                    console.error('invalid action: ' + action);
                    return
            }
            for (key in data) {
                if (key != 'action') {
                    params.push(key+':'+data[key]);
                }
            }
            var q = action+'/'+params.join(',');
            console.log(q);
            self.apiCall(q);

            return false;
        });

        return this;
    }
};


(function (window, document, _) {
    $(function () { $("[data-toggle='tooltip']").tooltip(); });
	_.init();
}(window, document, instance));
