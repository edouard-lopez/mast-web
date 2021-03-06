/**
 * User: ed8
 * Date: 7/27/14
 */

var instance = {
    /**
     * list of data-* attributes transmitted to the api
     */
    args_whitelist: [
        'id',
        'name',
        'action',
        'remote_host',
        'printer',
        'desc'
    ],

	apiCall: function (action) {
        console.info(action);
		var request = $.ajax({
				url: "/api/"+action,
				cache: false
		});
		request.done(function(_) {
				console.log('response: ', _);
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

		if (hash !== '' && hash !== null && reSmart.exec(hash)) {
            $('#dangerous-area').hide();
            // var action = /add-channel/;
            // if (action.exec(hash)) {
            //     $('.restart').addClass('animated tada');
            // }
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

        $('.btn-action').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            data = $(this).data();
            if (! data.action ) { console.warn('no action'); return; }

            args = []; // only process whitelisted data-attributes
            for (attr in data ) {
                if (attr !== 'action' && $.inArray(attr, self.args_whitelist) !== -1) {
                    args.push(attr+':'+data[attr]);
                }
            }

            var action =  data.action;
            var redirect =  Boolean(data.redirect);
            var desc, host, id, name, printer;
            var target_form = '#modal-' + action;

            switch (action) {
                //no special behavior, fallback to simple api call
                case 'start':
                case 'stop':
                case 'status':
                case 'list-hosts':
                case 'list-channels':
                case 'restart':
                    break;
                case 'remove-host':
                case 'remove-channel':
                    if (! window.confirm("Êtes vous sur de vouloir supprimer cet élément ?")) {
                         return false;
                    } else {
                        $(this).parents('.tunnel, .channel')[0].remove();
                    }
                    break;
                // form in modal
                case 'add-host':
                    $(target_form)
                        .on('show.bs.modal', function (e) {
                            $(target_form+' .modal-title > .name')[0].textContent = data.name;
                            $(target_form+' .modal-body .name').val(data.name);
                        })
                        .modal();
                    return true;
                case 'add-channel':
                    $(target_form)
                        .on('show.bs.modal', function (e) {
                            $(target_form+' .modal-title > .name')[0].textContent = data.name;
                            $(target_form+' .modal-body .name').val(data.name);
                        })
                        .modal();
                    return true;
                case 'link':
                    window.open(data.href);
                    return true;
                default:
                    console.error('invalid action: ' + action);
                    return true;
            }

            var q = action+'/'+args.join(',')+'/'+redirect;
            console.info(q);
            self.apiCall(q);

            return true;
        });

        return this;
    }
};


(function (window, document, _) {
    $(function () { $("[data-toggle='tooltip']").tooltip(); });
	_.init();
}(window, document, instance));
