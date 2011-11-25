Event.observe(document,'dom:loaded',function() {
    var bodyheight = document.viewport.getHeight();
    $('main_display').setStyle({height:(bodyheight - $('main_display').offsetTop - 16)+'px'});
    $('left_menu_list').setStyle({height:(bodyheight - $('left_menu_list').offsetTop - 8)+'px'});
});

// for the window resize
Event.observe(window,'resize',function() {
    var bodyheight = document.viewport.getHeight();
    $('main_display').setStyle({height:(bodyheight - $('main_display').offsetTop - 16)+'px'});
    $('left_menu_list').setStyle({height:(bodyheight - $('left_menu_list').offsetTop - 8)+'px'});
});

