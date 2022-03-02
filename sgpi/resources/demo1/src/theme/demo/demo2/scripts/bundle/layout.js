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

        options.minimize.mobile = false;

        if (KUtil.attr(headerEl, 'data-kheader-minimize') == 'on') {
            options.minimize.desktop = {};
            options.minimize.desktop.on = 'k-header--minimize';
            options.offset.desktop = 1;
        } else {
            options.minimize.desktop = false;
        }

        header = new KHeader('k_header', options);
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
            closeBy: 'k_aside_close_btn',
            toggleBy: {
                target: 'k_aside_mobile_toggler',
                state: 'k-header-mobile__toolbar-toggler--active'
            }
        });

        // Handle minimzied aside hover
        if (KUtil.hasClass(body, 'k-aside--fixed')) {
            var insideTm;
            var outsideTm;

            KUtil.addEvent(aside, 'mouseenter', function(e) {
                e.preventDefault();

                if (KUtil.isInResponsiveRange('desktop') === false) {
                    return;
                }

                if (outsideTm) {
                    clearTimeout(outsideTm);
                    outsideTm = null;
                }

                insideTm = setTimeout(function() {
                    if (KUtil.hasClass(body, 'k-aside--minimize') && KUtil.isInResponsiveRange('desktop')) {
                        KUtil.removeClass(body, 'k-aside--minimize');
                        
                        // Minimizing class
                        KUtil.addClass(body, 'k-aside--minimizing');
                        KUtil.transitionEnd(body, function() {
                            KUtil.removeClass(body, 'k-aside--minimizing');
                        });

                        // Hover class
                        KUtil.addClass(body, 'k-aside--minimize-hover');
                        asideMenu.scrollUpdate();
                        asideMenu.scrollTop();
                    }
                }, 50);
            });

            KUtil.addEvent(aside, 'mouseleave', function(e) {
                e.preventDefault();

                if (KUtil.isInResponsiveRange('desktop') === false) {
                    return;
                }

                if (insideTm) {
                    clearTimeout(insideTm);
                    insideTm = null;
                }

                outsideTm = setTimeout(function() {
                    if (KUtil.hasClass(body, 'k-aside--minimize-hover') && KUtil.isInResponsiveRange('desktop')) {
                        KUtil.removeClass(body, 'k-aside--minimize-hover');
                        KUtil.addClass(body, 'k-aside--minimize');

                        // Minimizing class
                        KUtil.addClass(body, 'k-aside--minimizing');
                        KUtil.transitionEnd(body, function() {
                            KUtil.removeClass(body, 'k-aside--minimizing');
                        });

                        // Hover class
                        asideMenu.scrollUpdate();
                        asideMenu.scrollTop();
                    }
                }, 100);
            });
        }
    }

    // Aside menu
    var initAsideMenu = function() {
        // Init aside menu
        var menu = KUtil.get('k_aside_menu');
        var menuDesktopMode = (KUtil.attr(menu, 'data-kmenu-dropdown') === '1' ? 'dropdown' : 'accordion');

        // Init scrollable menu container
        var scroll;
        if (KUtil.attr(menu, 'data-kmenu-scroll') === '1') {
            scroll = {
                height: function() {
                    var height;

                    if (KUtil.isInResponsiveRange('desktop')) {
                        height =  
                            parseInt(KUtil.getViewPort().height) - 
                            parseInt(KUtil.actualHeight('k_aside_brand'));
                    } else {
                        height =  
                            parseInt(KUtil.getViewPort().height);
                    }

                    height = height - (parseInt(KUtil.css(body, 'paddingTop')) + parseInt(KUtil.css(body, 'paddingBottom')) + parseInt(KUtil.css(menu, 'marginBottom')) + parseInt(KUtil.css(menu, 'marginTop')));

                    return height;
                }
            };
        }

        // Init aside menu
        asideMenu = new KMenu('k_aside_menu', {
            // vertical scroll
            scroll: scroll,

            // submenu setup
            submenu: {
                desktop: {
                    // by default the menu mode set to accordion in desktop mode
                    default: menuDesktopMode,
                    // whenever body has this class switch the menu mode to dropdown
                    state: {
                        body: 'k-aside--minimize',
                        mode: 'dropdown'
                    }
                },
                tablet: 'accordion', // menu set to accordion in tablet mode
                mobile: 'accordion' // menu set to accordion in mobile mode
            },

            //accordion setup
            accordion: {
                expandAll: false // allow having multiple expanded accordions in the menu
            }
        });
    }

    // Sidebar toggle
    var initAsideToggler = function() {
        if (!KUtil.get('k_aside_toggler')) {
            return;
        }

        asideToggler = new KToggle('k_aside_toggler', {
            target: 'body',
            targetState: 'k-aside--minimize',
            togglerState: 'k-aside__brand-aside-toggler--active'
        }); 

        asideToggler.on('toggle', function(toggle) {     
            if (KUtil.get('main_portlet')) {
                pageStickyPortlet.updateSticky();      
            } 

            KUtil.addClass(body, 'k-aside--minimizing');
            KUtil.transitionEnd(body, function() {
                KUtil.removeClass(body, 'k-aside--minimizing');
            });

            asideMenu.pauseDropdownHover(800);

            // Remember state in cookie
            Cookies.set('k_aside_toggle_state', toggle.getState());
            // to set default minimized left aside use this cookie value in your 
            // server side code and add "k-brand--minimize k-aside--minimize" classes to 
            // the body tag in order to initialize the minimized left aside mode during page loading.
        });

        asideToggler.on('beforeToggle', function(toggle) {   
            var body = KUtil.get('body'); 
            if (KUtil.hasClass(body, 'k-aside--minimize') === false && KUtil.hasClass(body, 'k-aside--minimize-hover')) {
                KUtil.removeClass(body, 'k-aside--minimize-hover');
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
        var asideWidth = 280;
        var asideMinimizeWidth = 78;

        return new KPortlet('k_page_portlet', {
            sticky: {
                offset: parseInt(KUtil.css( KUtil.get('k_header'), 'height')),
                zIndex: 90,
                position: {
                    top: function() {
                        if (KUtil.isInResponsiveRange('desktop')) {
                            return 0;
                        } else {
                            return parseInt(KUtil.css( KUtil.get('k_header_mobile'), 'height') );
                        }                        
                    },
                    left: function() {
                        var left = 0;

                        if (KUtil.isInResponsiveRange('desktop')) {
                            if (KUtil.hasClass(body, 'k-aside--minimize')) {
                                left += asideMinimizeWidth;
                            } else {
                                left += asideWidth;
                            }
                        }

                        left += parseInt(KUtil.css(KUtil.getByClass('k-content'), 'paddingLeft'));
                        left += parseInt(KUtil.css(body, 'paddingRight'));

                        return left; 
                    },
                    right: function() {
                        var right = 0;

                        if (KUtil.isInResponsiveRange('desktop')) {
                            return parseInt(KUtil.css(body, 'paddingRight'));
                        } else {
                            return parseInt(KUtil.css(KUtil.getByClass('k-content'), 'paddingRight'));
                        }

                        return right;
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
            $('#k_aside_menu').on('click', '.k-menu__link[href="#"]', function() {
                if(!location.hostname.match('keenthemes.com')) {
                    swal("You have clicked on a dummy link!", "This demo shows only its unique layout features. <b>Keen's</b> all available features can be re-used in this and any other demos by refering to <b>the default demo</b>.", "warning");    
                }
            });
        },

        initHeader: function() {
            initHeader();
            initHeaderTopbar();
            initScrolltop();
        },

        initAside: function() { 
            initAside();
            initAsideMenu();
            initAsideToggler();
            
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