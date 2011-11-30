$(document).ready(function() {
    var bodyheight = $(window).height();
    $('#main_content').height(bodyheight - $('#main_content').offset().top - 16);
    $('#left_menu_list').height(bodyheight - $('#left_menu_list').offset().top - 8);
});

// for the window resize
$(window).resize(function() {
    var bodyheight = $(window).height();
    $('#main_content').height(bodyheight - $('#main_content').offset().top - 16);
    $('#left_menu_list').height(bodyheight - $('#left_menu_list').offset().top - 8);
});

