"use strict";
var KAsideSecondary = function() {
    var panel = KUtil.get('k_aside_secondary');
    var content1 = KUtil.get('k_aside_secondary_tab_1');
    var content2 = KUtil.get('k_aside_secondary_tab_2');
    var content3 = KUtil.get('k_aside_secondary_tab_3');
    var scroll1 = KUtil.find(content1, '.k-aside-secondary__content-body');
    var scroll2 = KUtil.find(content2, '.k-aside-secondary__content-body');
    var scroll3 = KUtil.find(content3, '.k-aside-secondary__content-body');
    var mobileNavToggler;
    var lastOpenedTab;

    var getContentHeight = function(content) {
        var height;
        var head = KUtil.find(content, '.k-aside-secondary__content-head');
        var body = KUtil.find(content, '.k-aside-secondary__content-body');

        height = parseInt(KUtil.getViewPort().height) - parseInt(KUtil.actualHeight(head)) - 60;
        
        if (KUtil.isInResponsiveRange('desktop')) {
            height = height - KUtil.actualHeight(KUtil.get('k_header'));
        } else {
            height = height - KUtil.actualHeight(KUtil.get('k_header_mobile'));
        }

        return height;
    }
    
    var initNavs = function() {
        $('#k_aside_secondary_nav a[data-toggle="tab"]').on('click', function (e) {
            if ((lastOpenedTab && lastOpenedTab.is($(this))) && $('body').hasClass('k-aside-secondary--expanded')) {
                KLayout.closeAsideSecondary();
            } else {
                lastOpenedTab =  $(this);
                KLayout.openAsideSecondary();                
            }
        });

        $('#k_aside_secondary_close').on('click', function (e) {
            KLayout.closeAsideSecondary();
        });

        $('#k_aside_secondary_nav a[data-toggle="tab"]').on('shown.bs.tab', function (e) { 
            KUtil.scrollUpdate(scroll1);
            KUtil.scrollUpdate(scroll2);
            KUtil.scrollUpdate(scroll3);
        });

        mobileNavToggler = new KToggle('k_aside_secondary_mobile_nav_toggler', {
            target: 'body',
            targetState: 'k-aside-secondary--mobile-nav-expanded'
        });
    }

    var initContent1 = function() {
        KUtil.scrollInit(scroll1, {
            disableForMobile: true, 
            resetHeightOnDestroy: true, 
            handleWindowResize: true, 
            height: function() {
                return getContentHeight(content1);
            }
        });
    }

    var initContent2 = function() {
        KUtil.scrollInit(scroll2, {
            disableForMobile: true, 
            resetHeightOnDestroy: true, 
            handleWindowResize: true, 
            height: function() {
                return getContentHeight(content2);
            }
        });
    }

    var initContent3 = function() {
        KUtil.scrollInit(scroll3, {
            disableForMobile: true, 
            resetHeightOnDestroy: true, 
            handleWindowResize: true, 
            height: function() {
                return getContentHeight(content3);
            }
        });
    }

    return {     
        init: function() {  
            //initOffcanvas(); 
            initNavs();
            initContent1();
            initContent2();
            initContent3();
        }
    };
}();

$(document).ready(function() {
    if (KUtil.get('k_aside_secondary')) {
        KAsideSecondary.init();
    }
});