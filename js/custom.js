jQuery(document).ready(function() {
  // Drop down menu
  jQuery('#main-menu a.active').parent('li').parent('ul').parent('li').addClass('active-parent');

  // Bios page animated scroll
  jQuery('a.top').click(function(e) {
    e.preventDefault();
    jQuery('html, body').animate({scrollTop: 0}, 500);
  });
  jQuery('.view-artist-link-list a, .view-artist-link-list-french a').click(function(e) {
    e.preventDefault();
    var dest_id = jQuery(this).attr('href');
    var dest_pos = jQuery(dest_id).offset().top;
    jQuery('html, body').animate({scrollTop: dest_pos}, 500)
  });
});
