/**
 * User: ed8
 * Date: 7/27/14
 */
(function (window, document) {
    $('.btn-action').click( function () {
        var action = this.id;

        console.info(action);
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
    });
}(window, document));
