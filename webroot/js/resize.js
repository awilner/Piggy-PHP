Event.observe(document,'dom:loaded',function() {
    var bodyheight = document.viewport.getHeight();
    $('main_content').setStyle({height:(bodyheight - $('main_content').offsetTop - 16)+'px'});
    $('left_menu_list').setStyle({height:(bodyheight - $('left_menu_list').offsetTop - 8)+'px'});
});

// for the window resize
Event.observe(window,'resize',function() {
    var bodyheight = document.viewport.getHeight();
    $('main_content').setStyle({height:(bodyheight - $('main_content').offsetTop - 16)+'px'});
    $('left_menu_list').setStyle({height:(bodyheight - $('left_menu_list').offsetTop - 8)+'px'});
});

