var refreshTime = 600000; // every 10 minutes in milliseconds
window.setInterval( function() {
    $.ajax({
        cache: false,
        type: "GET",
        url: BASE_URL+"Login/extendSession/",
        success: function(data) {
        }
    });
}, refreshTime );
