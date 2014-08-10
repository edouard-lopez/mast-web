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

	init: function () {
		var self = this;

        this.overlay()

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

        return this;
    }
};


(function (window, document, _) {
	_.init();
}(window, document, instance));
