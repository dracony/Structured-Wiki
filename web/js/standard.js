 
$(document).ready(function() {
    // Show the the login dialog
    $(document).on('click', '.btnLoginDialog', function() {
        overlay(true);
        $("#loginBox").fadeIn("fast");
        return false;
    });
    
    // Cancel a login or forgot password
    $(document).on('click', '.btnLoginCancel', function() {
        overlay(false);
        $("#loginBox").fadeOut("fast");
        $("#forgotBox").fadeOut("fast");
        return false;
    });
    
    // Show the forgot password dialog
    $(document).on('click', '.btnForgotDialog', function() {
        $("#loginBox").hide();
        $("#forgotBox").show();
        $("#loginUsername").val('');
        $("#loginPassword").val('');
        return false;
    });
    
    // Attempt to login
    $(document).on('click', '.btnLogin', function() {
        var u = $("#loginUsername").val();
        var p = $("#loginPassword").val();
        
        if (u == '' || p == '')
            return;
                
        $.ajax({
            type: "POST",
            url: "/~api/login",
            data: { 'user':u, 'pass':p }
        }).done(function(data) {
            overlay(false);
            $("#loginBox").fadeOut("fast");
            $("#loginUsername").val('');
            $("#loginPassword").val('');
            data = $.parseJSON(data);
            if (data['auth'])
                $('.topBar').html(data['bar']);
            else
                alert('Email or password not correct.');
        }).fail(function(jqXHR, textStatus, errorThrown) {
            overlay(false);
            $("#loginBox").fadeOut("fast");
            $("#loginUsername").val('');
            $("#loginPassword").val('');
                alert('Error: ' + errorThrown);
        });
    });

    
    // Logout
    $(document).on('click', '.btnLogout', function() {
        $.ajax({
            type: "POST",
            url: "/~api/logout"
        }).done(function(data) {
            data = $.parseJSON(data);
            if (!data['auth'])
                $('.topBar').html(data['bar']);
        });
    });
});

function overlay(show) {
    var overlay = $("#overlay");
    if (show) {
        overlay.fadeIn("fast");
    } else {
        overlay.fadeOut("fast");
    }
}
