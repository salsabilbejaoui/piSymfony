(function($) {
    $("a.comment-button").on('click', function(e) {
        $("#add").css("visibility", "visible");
        $("#close").on('click', function(e) {
            $("#add").css("visibility", "hidden");
        });
    });
}).call(this,$);


