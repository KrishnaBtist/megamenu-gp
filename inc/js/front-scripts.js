let imcgpmenu_headerBackgroundColor = imc_menu_object.imcgpmenu_headerBackgroundColor;
let imcgpmenu_nav_dropdown_type    = imc_menu_object.imcgpmenu_nav_dropdown_type;

function getwindowwidth(){
    var windowWidth = jQuery(window).width();
    return windowWidth;
}
function tochecknavigationtype(){
    if(imcgpmenu_nav_dropdown_type.length > 0 && imcgpmenu_nav_dropdown_type == "hover"){
        return true; // click nav
    }else{
        return false;
    }
}
function isSticky(){
    console.log('8888');
    let stickyheight = false;
    if(jQuery('nav').hasClass('is_stuck')){
        console.log('999');
        stickyheight =   jQuery('.is_stuck').outerHeight()
    }
    return stickyheight;
}
function checkheadertop(){
    let headertop = false;
    if (jQuery('body').hasClass('nav-float-right') || jQuery('body').hasClass('nav-below-header') || jQuery('body').hasClass('nav-above-header') || jQuery('body').hasClass('nav-float-left')) {
        headertop = true;
    }
    return headertop;
}
function addTopInMegaMenu(){
    jQuery('.imc-gp-mega-menu-wrapper').css('top', getHeaderHeight() + 'px'); 
} 
function getHeaderHeight(){
    console.log('7777')
    let height = 0;
    let admintoolHeight = 0; 
    if( jQuery("#wpadminbar").length > 0){
        console.log('555');
        admintoolHeight = jQuery("#wpadminbar").outerHeight();
    }
    if(isSticky()){
        console.log('111');
        height = admintoolHeight + isSticky() - 1;
      
    }else if (jQuery('.main-navigation').prev('header').length > 0) {
        console.log('222');
        height = jQuery('#primary-menu').outerHeight() +  jQuery('header.site-header').outerHeight() + admintoolHeight;            
    }else if(jQuery('.main-navigation').next('header').length > 0){
        console.log('333');
        height = jQuery('#primary-menu').outerHeight() + admintoolHeight;
    }else{  
        console.log('444');          
        height = jQuery('header.site-header').outerHeight() + admintoolHeight;
    }
    if(!isSticky()){
        console.log('666');  
        height -= jQuery(window).scrollTop();
    }
    return height;
}
function megaMenuVisibleActive(){
    let megaMenuActive = false;
    if(jQuery(".imc_gp_mega_menu_item").hasClass('imc_MegaMenuVisible')){
        console.log('megaMenuVisibleActive()');
        megaMenuActive = true;
    }
    return megaMenuActive;
}

jQuery(document).ready(function($){
     //Add height mega menu      
     setTimeout(function(){
        addTopInMegaMenu()
     },100)

    $(window).on('resize', function(){  
    addTopInMegaMenu() //Add height mega menu      
        if(getwindowwidth() > 768){
            if(tochecknavigationtype()){
                desktopmegamenu()
            }
        }
        else{
            jQuery('.imc-gp-mega-menu-wrapper').css('top', 0 + 'px');  
        }
    })
    if(getwindowwidth() > 768){
        if(tochecknavigationtype()){
            desktopmegamenu()
        }
    }
    function desktopmegamenu(){
        jQuery('.imc_gp_mega_menu_item').on('mouseover', function(){
            addTopInMegaMenu()
            let megaMenu = jQuery(this).find('.imc-gp-mega-menu-wrapper');  
            jQuery('.imc-gp-mega-menu-wrapper').removeClass('openMenu')        
            megaMenu.addClass('openMenu')
            if(checkheadertop()){
                activenavbg()
            }
            if( jQuery(".inside-right-sidebar nav").length > 0  || jQuery(".inside-left-sidebar nav").length ){
                jQuery('.imc-gp-mega-menu-wrapper').css({
                    'width': getsidebarwidth() + 'px',
                    'max-width': getsidebarwidth() + 'px', // Replace with your desired max-width value
                });
                jQuery(this).closest('.imc_gp_mega_menu_item').css('background-color', headerbackgroundcolor);
            }
        })
        jQuery('.imc_gp_mega_menu_item').on('mouseleave', function(e){
            let megaMenuWrapper = jQuery(this);
            let rect = megaMenuWrapper[0].getBoundingClientRect();
            if (e.clientY >= rect.bottom) {
            }else{
                megaMenuWrapper.find('.imc-gp-mega-menu-wrapper').removeClass('openMenu')  
                removebgnav()
            }
            if( jQuery(".inside-right-sidebar nav").length > 0  || jQuery(".inside-left-sidebar nav").length ){
                jQuery(this).closest('.imc_gp_mega_menu_item').css('background-color', '');
            }
        })
        jQuery('.imc-gp-mega-menu-wrapper').on('mouseleave', function(e){
            jQuery('.imc-gp-mega-menu-wrapper').removeClass('openMenu');
            removebgnav()
        })
    }
    function activenavbg(){
        if (jQuery('body').hasClass('nav-float-left') || jQuery('body').hasClass('nav-float-right')) {
            jQuery('.site-header,.imc_gp_megamenu .main-navigation').css('background-color', imcgpmenu_headerBackgroundColor);
            jQuery('.site-header  .header-image').hide()
            jQuery(".site-header  .header-image.imcgpmenuLogo").show();
            jQuery(".sticky-navigation-logo .is-logo-image").hide();
            jQuery(".sticky-navigation-logo .imcgpmenuLogo").show();
        }else{
            jQuery(".imc_gp_mega_menu_item").closest('.main-navigation').css('background-color', imcgpmenu_headerBackgroundColor);
        }
        if(jQuery('nav.sticky-navigation-transition').length>0){
            jQuery('nav.sticky-navigation-transition').css('background-color', imcgpmenu_headerBackgroundColor);  
        }
    }
    function removebgnav(){
        if (jQuery('body').hasClass('nav-float-left') || jQuery('body').hasClass('nav-float-right')) {
            jQuery('.site-header,.imc_gp_megamenu .main-navigation').css('background-color', '');
            jQuery('.site-header .header-image').show()
            jQuery(".site-header .header-image.imcgpmenuLogo").hide();
            jQuery(".sticky-navigation-logo .is-logo-image").show();
            jQuery(".sticky-navigation-logo .imcgpmenuLogo").hide();

        }else{
            jQuery(".imc_gp_mega_menu_item").closest('.main-navigation').css('background-color', '');
        }
        if(jQuery('nav.sticky-navigation-transition').length>0){
            jQuery('nav.sticky-navigation-transition').css('background-color','');  
        }

    }
    function getsidebarwidth(){
        var windowWidth    = $(window).width();
        var widthsidebar   = $('.inside-right-sidebar').width()
        var element        = $('.inside-right-sidebar')
        var rightSideWidth = $(window).width() - (element.offset().left + element.outerWidth());
        let finalwidth     =  windowWidth - widthsidebar - rightSideWidth;
        return finalwidth;
    }
    jQuery(window).scroll('body',function(){
        jQuery('.imc-gp-mega-menu-wrapper').removeClass('openMenu')
        if (jQuery('body').hasClass('nav-float-left') || jQuery('body').hasClass('nav-float-right')) {
            jQuery('.site-header,.imc_gp_megamenu .main-navigation').css('background-color', '');
        }
    });
});


//CLICK MEGA MENU EVENT 
jQuery(document).ready(function($) {
    // Click event on menu item
    jQuery(document).on('click','.imc_gp_mega_menu_item.menu-item-has-children-click >a', function(event) {
        console.log('222')
        event.preventDefault();
       // jQuery('body').trigger('click'); // Hide Default dropdown 
        var clickedItem = $(this).parents('li.menu-item');
        $('.imc_gp_mega_menu_item.menu-item-has-children-click a').not(this).each(function() {
            var currentItem = $(this).parents('li.menu-item');
            if (!currentItem.is(clickedItem)) {
                currentItem.find('ul.sub-menu').removeClass('toggled-on');
                currentItem.removeClass('sfHover');
                currentItem.removeClass('imc_MegaMenuVisible');
            }
        });
        clickedItem.find('ul.sub-menu').toggleClass('toggled-on');
        clickedItem.toggleClass('sfHover');
        var theItem = jQuery(this).parents('li.menu-item');
        let isOpen  = jQuery(this).parents('li.menu-item').find('ul').hasClass('toggled-on');
        if (isOpen) { 
            console.log('1111*')        
            showMenu(theItem);  
        } else {
            console.log('2222*')      
            hideMenu();
        }   
    });
    // Click event on arrow icon
    
    $('.imc_gp_mega_menu_item.menu-item-has-children-click-arrow .imc_gp_arrow').on('click', function(event) {
        event.preventDefault(); 
        $('.imc_gp_mega_menu_item.menu-item-has-children-click-arrow .imc_gp_arrow').not(this).each(function() {
            $(this).parents('li.menu-item').find('ul.sub-menu').removeClass('toggled-on');
            $(this).parents('li.menu-item').removeClass('sfHover');
            $(this).parents('li.menu-item').removeClass('imc_MegaMenuVisible');
        });
        $(this).parents('li.menu-item').find('ul.sub-menu').toggleClass('toggled-on');
        $(this).parents('li.menu-item').toggleClass('sfHover');
        var theItem = jQuery(this).parents('li.menu-item');
        let isOpen  = jQuery(this).parents('li.menu-item').find('ul').hasClass('toggled-on');
        if (isOpen) {         
            showMenu(theItem);  
        } else {
            hideMenu();
        }   
    });

    function showMenu(theItem){
        theItem.addClass('imc_MegaMenuVisible')
        if (jQuery('body').hasClass('nav-float-left') || jQuery('body').hasClass('nav-float-right')) {
            jQuery('.site-header,.imc_gp_megamenu .main-navigation').css('background-color', imcgpmenu_headerBackgroundColor);
        }
        else{
            jQuery(".imc_gp_mega_menu_item").closest('.main-navigation').css('background-color', imcgpmenu_headerBackgroundColor); 
        }
        jQuery('.site-header  .header-image').hide()
        jQuery(".site-header  .header-image.imcgpmenuLogo").show();
        jQuery(".sticky-navigation-logo .is-logo-image").hide();
        jQuery(".sticky-navigation-logo .imcgpmenuLogo").show(); 

    }
    function hideMenu(){
        jQuery('.imc_gp_mega_menu_item').removeClass('imc_MegaMenuVisible')
        if (jQuery('body').hasClass('nav-float-left') || jQuery('body').hasClass('nav-float-right')) {
            jQuery('.site-header,.imc_gp_megamenu .main-navigation').css('background-color', '');
            jQuery('.site-header .header-image').show()
            jQuery(".site-header .header-image.imcgpmenuLogo").hide();
            jQuery(".sticky-navigation-logo .is-logo-image").show();
            jQuery(".sticky-navigation-logo .imcgpmenuLogo").hide();

        }else{
            jQuery(".imc_gp_mega_menu_item").closest('.main-navigation').css('background-color', '');
        }
        if(jQuery('nav.sticky-navigation-transition').length>0){
            jQuery('nav.sticky-navigation-transition').css('background-color','');  
        }
    }
    // jQuery(document).on('click', function(event) {
    //     if (!jQuery(event.target).closest('.imc_gp_mega_menu_item').length) {
    //         jQuery('.imc-gp-mega-menu-wrapper').removeClass('openMenu')        
    //         hideMenu()
    //     }
    // });
    if(getwindowwidth() <= 768){
       jQuery('.imc-gp-mega-menu-wrapper').css('top', 0 + 'px'); 
       jQuery(".imc_gp_mega_menu_item").addClass('menu-item-has-children')
       jQuery(".imc_gp_mega_menu_item").removeClass('menu-item-has-children-click')
       jQuery(".imc_gp_mega_menu_item").removeClass('menu-item-has-children-click-arrow')
    }else{
        //console.log('**---')
    }

});



//STICKY BEHAVEIOUR
// jQuery(document).ready(function() {
//     if (!tochecknavigationtype()) {
//         var isScrolling = false;
        
//         jQuery(window).scroll(function() {
//             if (!isScrolling && megaMenuVisibleActive()) {
//                 isScrolling = true;
//                 console.log(megaMenuVisibleActive());
                
//                // if (jQuery(this).scrollTop() > 50) {
   
//                     jQuery(".imc_gp_mega_menu_item").find('ul.sub-menu').removeClass('toggled-on');
//                     jQuery(".imc_gp_mega_menu_item").find('ul.sub-menu').removeClass('imc_MegaMenuVisible');
//                     jQuery(".imc_gp_mega_menu_item").removeClass('sfHover');
                
//                     setTimeout(function() {
//                         isScrolling = false;
//                     }, 100); // Adjust the timeout duration as needed
//             }
//         });

//         jQuery(window).on('click hover', function() {
//             isScrolling = false;
//         });
//     }
// });


