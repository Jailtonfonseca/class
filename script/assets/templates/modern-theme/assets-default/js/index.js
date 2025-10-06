/*--------------------------------------
POST SLIDER
--------------------------------------*/
if(jQuery('#tg-dbcategoriesslider').length > 0){
    if ($("body").hasClass("rtl")) var rtl = true;
    else rtl = false;
    var _tg_postsslider = jQuery('#tg-dbcategoriesslider');
    _tg_postsslider.owlCarousel({
        items : 8,
        nav: true,
        rtl: rtl,
        loop: false,
        dots: false,
        autoplay: false,
        dotsClass: 'tg-sliderdots',
        navClass: ['tg-prev', 'tg-next'],
        navContainerClass: 'tg-slidernav',
        navText: ['<span class="icon-chevron-left"></span>', '<span class="icon-chevron-right"></span>'],
        responsive:{
            0:{ items:2, },
            640:{ items:4, },
            768:{ items:8, },
        }
    });
}