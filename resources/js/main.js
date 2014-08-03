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


	init: function () {
		var self = this;
        $('.service .btn-action').on( "click", function() {
            self.apiCall(this.id);
        });
        $('#tunnels .btn-action').on( "click", function() {
            self.apiCall(this.id);
        });
        $('.btn-clear').on( "click", function() {
            $('.stdout').html('');
        });
    }
};


(function (window, document, _) {
	_.init();
}(window, document, instance));
