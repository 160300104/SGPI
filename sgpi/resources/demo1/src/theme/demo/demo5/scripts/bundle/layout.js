"use strict";
var KLayout = function() {
    var body;

    var header;
    var headerMenu;
    var headerMenuOffcanvas;

    var asideMenu;
    var asideMenuOffcanvas;
    var asideToggler;

    var scrollTop;

    var pageStickyPortlet;

    // Header
    var initHeader = function() {
        var tmp;
        var headerEl = KUtil.get('k_header');
        var options = {
            offset: {},
            minimize: {}
        };

        if (KUtil.attr(headerEl, 'data-kheader-minimize-mobile') == 'hide') {
            options.minimize.mobile = {};
            options.minimize.mobile.on = 'k-header--hide';
            options.minimize.mobile.off = 'k-header--show';
        } else {
            options.minimize.mobile = false;
        }

        if (KUtil.attr(headerEl, 'data-kheader-minimize') == 'hide') {
            options.minimize.desktop = {};
            options.minimize.desktop.on = 'k-header--hide';
            options.minimize.desktop.off = 'k-header--show';
        } else {
            options.minimize.desktop = false;
        }

        if (tmp = KUtil.attr(headerEl, 'data-kheader-minimize-offset')) {
            options.offset.desktop = tmp;
        }

        if (tmp = KUtil.attr(headerEl, 'data-kheader-minimize-mobile-offset')) {
            options.offset.mobile = tmp;
        }

        header = new KHeader('k_header', options);
    }

    // Header Menu
    var initHeaderMenu = function() {
        // init aside left offcanvas
        headerMenuOffcanvas = new KOffcanvas('k_header_menu_wrapper', {
            overlay: true,
            baseClass: 'k-header-menu-wrapper',
            closeBy: 'k_header_menu_mobile_close_btn',
            toggleBy: {
                target: 'k_header_mobile_toggler',
                state: 'k-header-mobile__toolbar-toggler--active'
            }
        });

        headerMenu = new KMenu('k_header_menu', {
            submenu: {
                desktop: 'dropdown',
                tablet: 'accordion',
                mobile: 'accordion'
            },
            accordion: {
                slideSpeed: 200, // accordion toggle slide speed in milliseconds
                expandAll: false // allow having multiple expanded accordions in the menu
            }
        });
    }

    // Header Topbar
    var initHeaderTopbar = function() {
        asideToggler = new KToggle('k_header_mobile_topbar_toggler', {
            target: 'body',
            targetState: 'k-header__topbar--mobile-on',
            togglerState: 'k-header-mobile__toolbar-topbar-toggler--active'
        });
    }

    // Aside
    var initAside = function() {
        // init aside left offcanvas
        var asidBrandHover = false;
        var aside = KUtil.get('k_aside');
        var asideBrand = KUtil.get('k_aside_brand');
        var asideOffcanvasClass = KUtil.hasClass(aside, 'k-aside--offcanvas-default') ? 'k-aside--offcanvas-default' : 'k-aside';

        asideMenuOffcanvas = new KOffcanvas('k_aside', {
            baseClass: asideOffcanvasClass,
            overlay: true,
            closeBy: 'k_aside_close',
            toggleBy: {
                target: 'k_aside_toggler',
                state: 'k-sub-header__toggler--active'
            }
        });
    }

    // Aside menu
    var initAsideMenu = function() {
        // Init aside menu
        var aside = KUtil.get('k_aside');
        var menu = KUtil.get('k_aside_menu');
        var menuDesktopMode = (KUtil.attr(menu, 'data-kmenu-dropdown') === '1' ? 'dropdown' : 'accordion');

        var scroll;
        if (KUtil.attr(menu, 'data-kmenu-scroll') === '1') {
            scroll = {
                height: function() {
                    var height;
                    
                    height = parseInt(KUtil.getViewPort().height);

                    var head = KUtil.find(aside, '.k-aside__head');

                    if (head) {
                        height = height - parseInt(KUtil.actualHeight(head));
                        height = height - parseInt(KUtil.css(head, 'marginBottom'));
                    }

                    height = height - (parseInt(KUtil.css(menu, 'marginBottom')) + parseInt(KUtil.css(menu, 'marginTop')));
                    height = height - (parseInt(KUtil.css(aside, 'paddingBottom')) + parseInt(KUtil.css(aside, 'paddingTop')));    

                    return height;
                }
            };
        }

        asideMenu = new KMenu('k_aside_menu', {
            // vertical scroll
            scroll: scroll,

            // submenu setup
            submenu: {
                desktop: 'accordion', // menu set to accordion in tablet mode
                tablet: 'accordion', // menu set to accordion in tablet mode
                mobile: 'accordion' // menu set to accordion in mobile mode
            },

            //accordion setup
            accordion: {
                expandAll: false // allow having multiple expanded accordions in the menu
            }
        });
    }

    // Scrolltop
    var initScrolltop = function() {
        var scrolltop = new KScrolltop('k_scrolltop', {
            offset: 300,
            speed: 600
        });
    }

    // Init page sticky portlet
    var initPageStickyPortlet = function() {
        return new KPortlet('k_page_portlet', {
            sticky: {
                offset: parseInt(KUtil.css( KUtil.get('k_header'), 'height')),
                zIndex: 90,
                position: {
                    top: function() {
                        if (KUtil.isInResponsiveRange('desktop')) {
                            return parseInt(KUtil.css( KUtil.get('k_header'), 'height') );
                        } else {
                            return parseInt(KUtil.css( KUtil.get('k_header_mobile'), 'height') );
                        }                        
                    },
                    left: function() {
                        if (KUtil.isInResponsiveRange('tablet-and-mobile')) {    
                            return parseInt(KUtil.css( KUtil.get('k_content'), 'paddingLeft')); 
                        }

                        return;
                    },
                    right: function() {
                        if (KUtil.isInResponsiveRange('tablet-and-mobile')) {    
                            return parseInt(KUtil.css( KUtil.get('k_content'), 'paddingRight')); 
                        }

                        return;
                    }
                }
            }
        });
    }

    return {
        init: function() {
            body = KUtil.get('body');

            this.initHeader();
            this.initAside();
            this.initPageStickyPortlet();

            // Non functional links notice(can be removed in production)
            $('#k_aside_menu, #k_header_menu').on('click', '.k-menu__link[href="#"]', function() {
                if(location.hostname.match('keenthemes.com')) {
                    swal("You have clicked on a dummy link!", "To browse the theme features please refer to the header menu.", "warning");
                } else {
                    swal("You have clicked on a dummy link!", "This demo shows only its unique layout features. <b>Keen's</b> all available features can be re-used in this and any other demos by refering to <b>the default demo</b>.", "warning");    
                }
            });
        },

        initHeader: function() {
            initHeader();
            initHeaderMenu();
            initHeaderTopbar();
            initScrolltop();
        },

        initAside: function() { 
            initAside();
            initAsideMenu();
            
            this.onAsideToggle(function(e) {
                // Update sticky portlet
                if (pageStickyPortlet) {
                    pageStickyPortlet.updateSticky();
                }

                // Reload datatable
                var datatables = $('.k-datatable');
                if (datatables) {
                    datatables.each(function() {
                        $(this).KDatatable('redraw');
                    });
                }                
            });
        },

        initPageStickyPortlet: function() {
            if (!KUtil.get('k_page_portlet')) {
                return;
            }
            
            pageStickyPortlet = initPageStickyPortlet();
            pageStickyPortlet.initSticky();
            
            KUtil.addResizeHandler(function(){
                pageStickyPortlet.updateSticky();
            });

            initPageStickyPortlet();
        },

        getAsideMenu: function() {
            return asideMenu;
        },

        onAsideToggle: function(handler) {
            if (typeof asideToggler.element !== 'undefined') {
                asideToggler.on('toggle', handler);
            }
        },

        getAsideToggler: function() {
            return asideToggler;
        },
        
        closeMobileAsideMenuOffcanvas: function() {
            if (KUtil.isMobileDevice()) {
                asideMenuOffcanvas.hide();
            }
        },

        closeMobileHeaderMenuOffcanvas: function() {
            if (KUtil.isMobileDevice()) {
                headerMenuOffcanvas.hide();
            }
        }
    };
}();

$(document).ready(function() {
    KLayout.init();
});