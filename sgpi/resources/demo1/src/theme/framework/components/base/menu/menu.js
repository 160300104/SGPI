"use strict";
var KMenu = function(elementId, options) {
    // Main object
    var the = this;
    var init = false;

    // Get element object
    var element = KUtil.get(elementId);
    var body = KUtil.get('body');  

    if (!element) {
        return;
    }

    // Default options
    var defaultOptions = {       
        // accordion submenu mode
        accordion: {
            slideSpeed: 200, // accordion toggle slide speed in milliseconds
            autoScroll: false, // enable auto scrolling(focus) to the clicked menu item
            autoScrollSpeed: 1200,
            expandAll: true // allow having multiple expanded accordions in the menu
        },

        // dropdown submenu mode
        dropdown: {
            timeout: 500 // timeout in milliseconds to show and hide the hoverable submenu dropdown
        }
    };

    ////////////////////////////
    // ** Private Methods  ** //
    ////////////////////////////

    var Plugin = {
        /**
         * Run plugin
         * @returns {KMenu}
         */
        construct: function(options) {
            if (KUtil.data(element).has('menu')) {
                the = KUtil.data(element).get('menu');
            } else {
                // reset menu
                Plugin.init(options);

                // reset menu
                Plugin.reset();

                // build menu
                Plugin.build();

                KUtil.data(element).set('menu', the);
            }

            return the;
        },

        /**
         * Handles submenu click toggle
         * @returns {KMenu}
         */
        init: function(options) {
            the.events = [];

            the.eventHandlers = {};

            // merge default and user defined options
            the.options = KUtil.deepExtend({}, defaultOptions, options);

            // pause menu
            the.pauseDropdownHoverTime = 0;

            the.uid = KUtil.getUniqueID();
        },

        update: function(options) {
            // merge default and user defined options
            the.options = KUtil.deepExtend({}, defaultOptions, options);

            // pause menu
            the.pauseDropdownHoverTime = 0;

             // reset menu
            Plugin.reset();

            the.eventHandlers = {};

            // build menu
            Plugin.build();

            KUtil.data(element).set('menu', the);
        },

        reload: function() {
             // reset menu
            Plugin.reset();

            // build menu
            Plugin.build();
        },

        /**
         * Reset menu
         * @returns {KMenu}
         */
        build: function() {
            // General accordion submenu toggle
            the.eventHandlers['event_1'] = KUtil.on( element, '.k-menu__toggle', 'click', Plugin.handleSubmenuAccordion);

            // Dropdown mode(hoverable)
            if (Plugin.getSubmenuMode() === 'dropdown' || Plugin.isConditionalSubmenuDropdown()) {
                // dropdown submenu - hover toggle
                the.eventHandlers['event_2'] = KUtil.on( element, '[data-kmenu-submenu-toggle="hover"]', 'mouseover', Plugin.handleSubmenuDrodownHoverEnter);
                the.eventHandlers['event_3'] = KUtil.on( element, '[data-kmenu-submenu-toggle="hover"]', 'mouseout', Plugin.handleSubmenuDrodownHoverExit);

                // dropdown submenu - click toggle
                the.eventHandlers['event_4'] = KUtil.on( element, '[data-kmenu-submenu-toggle="click"] > .k-menu__toggle, [data-kmenu-submenu-toggle="click"] > .k-menu__link .k-menu__toggle', 'click', Plugin.handleSubmenuDropdownClick);
                the.eventHandlers['event_5'] = KUtil.on( element, '[data-kmenu-submenu-toggle="tab"] > .k-menu__toggle, [data-kmenu-submenu-toggle="tab"] > .k-menu__link .k-menu__toggle', 'click', Plugin.handleSubmenuDropdownTabClick);
            }

            // General link click
            the.eventHandlers['event_6'] = KUtil.on(element, '.k-menu__item:not(.k-menu__item--submenu) > .k-menu__link:not(.k-menu__toggle):not(.k-menu__link--toggle-skip)', 'click', Plugin.handleLinkClick);

            // Init scrollable menu
            if (the.options.scroll && the.options.scroll.height) {
                Plugin.scrollInit();
            }
        },

        /**
         * Reset menu
         * @returns {KMenu}
         */
        reset: function() { 
            KUtil.off( element, 'click', the.eventHandlers['event_1']);

            // dropdown submenu - hover toggle
            KUtil.off( element, 'mouseover', the.eventHandlers['event_2']);
            KUtil.off( element, 'mouseout', the.eventHandlers['event_3']);

            // dropdown submenu - click toggle
            KUtil.off( element, 'click', the.eventHandlers['event_4']);
            KUtil.off( element, 'click', the.eventHandlers['event_5']);
            
            KUtil.off(element, 'click', the.eventHandlers['event_6']);
        },

        /**
         * Init scroll menu
         *
        */
        scrollInit: function() {
            if ( the.options.scroll && the.options.scroll.height ) {
                KUtil.scrollDestroy(element);
                KUtil.scrollInit(element, {disableForMobile: true, resetHeightOnDestroy: true, handleWindowResize: true, height: the.options.scroll.height});
            } else {
                KUtil.scrollDestroy(element);
            }           
        },

        /**
         * Update scroll menu
        */
        scrollUpdate: function() {
            if ( the.options.scroll && the.options.scroll.height ) {
                KUtil.scrollUpdate(element);
            }
        },

        /**
         * Scroll top
        */
        scrollTop: function() {
            if ( the.options.scroll && the.options.scroll.height ) {
                KUtil.scrollTop(element);
            }
        },

        /**
         * Get submenu mode for current breakpoint and menu state
         * @returns {KMenu}
         */
        getSubmenuMode: function(el) {
            if ( KUtil.isInResponsiveRange('desktop') ) {
                if (el && KUtil.hasAttr(el, 'data-kmenu-submenu-toggle')) {
                    return KUtil.attr(el, 'data-kmenu-submenu-toggle');
                }

                if ( KUtil.isset(the.options.submenu, 'desktop.state.body') ) {
                    if ( KUtil.hasClass(body, the.options.submenu.desktop.state.body) ) {
                        return the.options.submenu.desktop.state.mode;
                    } else {
                        return the.options.submenu.desktop.default;
                    }
                } else if ( KUtil.isset(the.options.submenu, 'desktop') ) {
                    return the.options.submenu.desktop;
                }
            } else if ( KUtil.isInResponsiveRange('tablet') && KUtil.isset(the.options.submenu, 'tablet') ) {
                return the.options.submenu.tablet;
            } else if ( KUtil.isInResponsiveRange('mobile') && KUtil.isset(the.options.submenu, 'mobile') ) {
                return the.options.submenu.mobile;
            } else {
                return false;
            }
        },

        /**
         * Get submenu mode for current breakpoint and menu state
         * @returns {KMenu}
         */
        isConditionalSubmenuDropdown: function() {
            if ( KUtil.isInResponsiveRange('desktop') && KUtil.isset(the.options.submenu, 'desktop.state.body') ) {
                return true;
            } else {
                return false;
            }
        },

        /**
         * Handles menu link click
         * @returns {KMenu}
         */
        handleLinkClick: function(e) {
            if ( Plugin.eventTrigger('linkClick', this) === false ) {
                e.preventDefault();
            };

            if ( Plugin.getSubmenuMode(this) === 'dropdown' || Plugin.isConditionalSubmenuDropdown() ) {
                Plugin.handleSubmenuDropdownClose(e, this);
            }
        },

        /**
         * Handles submenu hover toggle
         * @returns {KMenu}
         */
        handleSubmenuDrodownHoverEnter: function(e) {
            if ( Plugin.getSubmenuMode(this) === 'accordion' ) {
                console.log('test111!');
                return;
            }

            if ( the.resumeDropdownHover() === false ) {
                console.log('test11111!');
                return;
            }

            var item = this;

            if ( item.getAttribute('data-hover') == '1' ) {
                item.removeAttribute('data-hover');
                clearTimeout( item.getAttribute('data-timeout') );
                item.removeAttribute('data-timeout');
                //Plugin.hideSubmenuDropdown(item, false);
            }

            // console.log('test!');

            Plugin.showSubmenuDropdown(item);
        },

        /**
         * Handles submenu hover toggle
         * @returns {KMenu}
         */
        handleSubmenuDrodownHoverExit: function(e) {
            if ( the.resumeDropdownHover() === false ) {
                return;
            }

            if ( Plugin.getSubmenuMode(this) === 'accordion' ) {
                return;
            }

            var item = this;
            var time = the.options.dropdown.timeout;

            var timeout = setTimeout(function() {
                if ( item.getAttribute('data-hover') == '1' ) {
                    Plugin.hideSubmenuDropdown(item, true);
                } 
            }, time);

            item.setAttribute('data-hover', '1');
            item.setAttribute('data-timeout', timeout);  
        },

        /**
         * Handles submenu click toggle
         * @returns {KMenu}
         */
        handleSubmenuDropdownClick: function(e) {
            if ( Plugin.getSubmenuMode(this) === 'accordion' ) {
                return;
            }
 
            var item = this.closest('.k-menu__item'); 

            if ( item.getAttribute('data-kmenu-submenu-mode') == 'accordion' ) {
                return;
            }

            if ( KUtil.hasClass(item, 'k-menu__item--hover') === false ) {
                KUtil.addClass(item, 'k-menu__item--open-dropdown');
                Plugin.showSubmenuDropdown(item);
            } else {
                KUtil.removeClass(item, 'k-menu__item--open-dropdown' );
                Plugin.hideSubmenuDropdown(item, true);
            }

            e.preventDefault();
        },

        /**
         * Handles tab click toggle
         * @returns {KMenu}
         */
        handleSubmenuDropdownTabClick: function(e) {
            if (Plugin.getSubmenuMode(this) === 'accordion') {
                return;
            }

            var item = this.closest('.k-menu__item');

            if (item.getAttribute('data-kmenu-submenu-mode') == 'accordion') {
                return;
            }

            if (KUtil.hasClass(item, 'k-menu__item--hover') == false) {
                KUtil.addClass(item, 'k-menu__item--open-dropdown');
                Plugin.showSubmenuDropdown(item);
            }

            e.preventDefault();
        },

        /**
         * Handles submenu dropdown close on link click
         * @returns {KMenu}
         */
        handleSubmenuDropdownClose: function(e, el) {
            // exit if its not submenu dropdown mode
            if (Plugin.getSubmenuMode(el) === 'accordion') {
                return;
            }

            var shown = element.querySelectorAll('.k-menu__item.k-menu__item--submenu.k-menu__item--hover:not(.k-menu__item--tabs)');

            // check if currently clicked link's parent item ha
            if (shown.length > 0 && KUtil.hasClass(el, 'k-menu__toggle') === false && el.querySelectorAll('.k-menu__toggle').length === 0) {
                // close opened dropdown menus
                for (var i = 0, len = shown.length; i < len; i++) {
                    Plugin.hideSubmenuDropdown(shown[0], true);
                }
            }
        },

        /**
         * helper functions
         * @returns {KMenu}
         */
        handleSubmenuAccordion: function(e, el) {
            var query;
            var item = el ? el : this;

            if ( Plugin.getSubmenuMode(el) === 'dropdown' && (query = item.closest('.k-menu__item') ) ) {
                if (query.getAttribute('data-kmenu-submenu-mode') != 'accordion' ) {
                    e.preventDefault();
                    return;
                }
            }

            var li = item.closest('.k-menu__item');
            var submenu = KUtil.child(li, '.k-menu__submenu, .k-menu__inner');

            if (KUtil.hasClass(item.closest('.k-menu__item'), 'k-menu__item--open-always')) {
                return;
            }

            if ( li && submenu ) {
                e.preventDefault();
                var speed = the.options.accordion.slideSpeed;
                var hasClosables = false;

                if ( KUtil.hasClass(li, 'k-menu__item--open') === false ) {
                    // hide other accordions                    
                    if ( the.options.accordion.expandAll === false ) {
                        var subnav = item.closest('.k-menu__nav, .k-menu__subnav');
                        var closables = KUtil.children(subnav, '.k-menu__item.k-menu__item--open.k-menu__item--submenu:not(.k-menu__item--here):not(.k-menu__item--open-always)');

                        if ( subnav && closables ) {
                            for (var i = 0, len = closables.length; i < len; i++) {
                                var el_ = closables[0];
                                var submenu_ = KUtil.child(el_, '.k-menu__submenu');
                                if ( submenu_ ) {
                                    KUtil.slideUp(submenu_, speed, function() {
                                        Plugin.scrollUpdate();
                                        KUtil.removeClass(el_, 'k-menu__item--open');
                                    });                    
                                }
                            }
                        }
                    }

                    KUtil.slideDown(submenu, speed, function() {
                        Plugin.scrollToItem(item);
                        Plugin.scrollUpdate();
                        
                        Plugin.eventTrigger('submenuToggle', submenu);
                    });
                
                    KUtil.addClass(li, 'k-menu__item--open');

                } else {
                    KUtil.slideUp(submenu, speed, function() {
                        Plugin.scrollToItem(item);
                        Plugin.eventTrigger('submenuToggle', submenu);
                    });

                    KUtil.removeClass(li, 'k-menu__item--open');       
                }
            }
        },

        /**
         * scroll to item function
         * @returns {KMenu}
         */
        scrollToItem: function(item) {
            // handle auto scroll for accordion submenus
            if ( KUtil.isInResponsiveRange('desktop') && the.options.accordion.autoScroll && element.getAttribute('data-kmenu-scroll') !== '1' ) {
                KUtil.scrollTo(item, the.options.accordion.autoScrollSpeed);
            }
        },

        /**
         * helper functions
         * @returns {KMenu}
         */
        hideSubmenuDropdown: function(item, classAlso) {
            // remove submenu activation class
            if ( classAlso ) {
                KUtil.removeClass(item, 'k-menu__item--hover');
                KUtil.removeClass(item, 'k-menu__item--active-tab');
            }

            // clear timeout
            item.removeAttribute('data-hover');

            if ( item.getAttribute('data-kmenu-dropdown-toggle-class') ) {
                KUtil.removeClass(body, item.getAttribute('data-kmenu-dropdown-toggle-class'));
            }

            var timeout = item.getAttribute('data-timeout');
            item.removeAttribute('data-timeout');
            clearTimeout(timeout);
        },

        /**
         * helper functions
         * @returns {KMenu}
         */
        showSubmenuDropdown: function(item) {
            // close active submenus
            var list = element.querySelectorAll('.k-menu__item--submenu.k-menu__item--hover, .k-menu__item--submenu.k-menu__item--active-tab');

            if ( list ) {
                for (var i = 0, len = list.length; i < len; i++) {
                    var el = list[i];
                    if ( item !== el && el.contains(item) === false && item.contains(el) === false ) {
                        Plugin.hideSubmenuDropdown(el, true);
                    }
                }
            } 

            // adjust submenu position
            Plugin.adjustSubmenuDropdownArrowPos(item);

            // add submenu activation class
            KUtil.addClass(item, 'k-menu__item--hover');
            
            if ( item.getAttribute('data-kmenu-dropdown-toggle-class') ) {
                KUtil.addClass(body, item.getAttribute('data-kmenu-dropdown-toggle-class'));
            }
        },

        /**
         * Handles submenu slide toggle
         * @returns {KMenu}
         */
        createSubmenuDropdownClickDropoff: function(el) {
            var query;
            var zIndex = (query = KUtil.child(el, '.k-menu__submenu') ? KUtil.css(query, 'z-index') : 0) - 1;

            var dropoff = document.createElement('<div class="k-menu__dropoff" style="background: transparent; position: fixed; top: 0; bottom: 0; left: 0; right: 0; z-index: ' + zIndex + '"></div>');

            body.appendChild(dropoff);

            KUtil.addEvent(dropoff, 'click', function(e) {
                e.stopPropagation();
                e.preventDefault();
                KUtil.remove(this);
                Plugin.hideSubmenuDropdown(el, true);
            });
        },

        /**
         * Handles submenu click toggle
         * @returns {KMenu}
         */
        adjustSubmenuDropdownArrowPos: function(item) {
            var submenu = KUtil.child(item, '.k-menu__submenu');
            var arrow = KUtil.child( submenu, '.k-menu__arrow.k-menu__arrow--adjust');
            var subnav = KUtil.child( submenu, '.k-menu__subnav');

            if ( arrow ) {
                var pos = 0; 
                var link = KUtil.child(item, '.k-menu__link');

                if ( KUtil.hasClass(submenu, 'k-menu__submenu--classic') || KUtil.hasClass(submenu, 'k-menu__submenu--fixed') ) {
                    if ( KUtil.hasClass(submenu, 'k-menu__submenu--right')) {
                        pos = KUtil.outerWidth(item) / 2;
                        if (KUtil.hasClass(submenu, 'k-menu__submenu--pull')) {
                            pos = pos + Math.abs( parseFloat(KUtil.css(submenu, 'margin-right')) );
                        }
                        pos = parseInt(KUtil.css(submenu, 'width')) - pos;
                    } else if ( KUtil.hasClass(submenu, 'k-menu__submenu--left') ) {
                        pos = KUtil.outerWidth(item) / 2;
                        if ( KUtil.hasClass(submenu, 'k-menu__submenu--pull')) {
                            pos = pos + Math.abs( parseFloat(KUtil.css(submenu, 'margin-left')) );
                        }
                    }
                } else {
                    if ( KUtil.hasClass(submenu, 'k-menu__submenu--center') || KUtil.hasClass(submenu, 'k-menu__submenu--full') ) {
                        pos = KUtil.offset(item).left - ((KUtil.getViewPort().width - parseInt(KUtil.css(submenu, 'width'))) / 2);
                        pos = pos + (KUtil.outerWidth(item) / 2);
                    }
                }

                KUtil.css(arrow, 'left', pos + 'px');  
            }
        },

        /**
         * Handles submenu hover toggle
         * @returns {KMenu}
         */
        pauseDropdownHover: function(time) {
            var date = new Date();

            the.pauseDropdownHoverTime = date.getTime() + time;
        },

        /**
         * Handles submenu hover toggle
         * @returns {KMenu}
         */
        resumeDropdownHover: function() {
            var date = new Date();

            return (date.getTime() > the.pauseDropdownHoverTime ? true : false);
        },

        /**
         * Reset menu's current active item
         * @returns {KMenu}
         */
        resetActiveItem: function(item) {
            var list;
            var parents;

            list = element.querySelectorAll('.k-menu__item--active');
            
            for (var i = 0, len = list.length; i < len; i++) {
                var el = list[0];
                KUtil.removeClass(el, 'k-menu__item--active');
                KUtil.hide( KUtil.child(el, '.k-menu__submenu') );
                parents = KUtil.parents(el, '.k-menu__item--submenu');

                for (var i_ = 0, len_ = parents.length; i_ < len_; i_++) {
                    var el_ = parents[i];
                    KUtil.removeClass(el_, 'k-menu__item--open');
                    KUtil.hide( KUtil.child(el_, '.k-menu__submenu') );
                }
            }

            // close open submenus
            if ( the.options.accordion.expandAll === false ) {
                if ( list = element.querySelectorAll('.k-menu__item--open') ) {
                    for (var i = 0, len = list.length; i < len; i++) {
                        KUtil.removeClass(parents[0], 'k-menu__item--open');
                    }
                }
            }
        },

        /**
         * Sets menu's active item
         * @returns {KMenu}
         */
        setActiveItem: function(item) {
            // reset current active item
            Plugin.resetActiveItem();

            KUtil.addClass(item, 'k-menu__item--active');
            
            var parents = KUtil.parents(item, '.k-menu__item--submenu');
            for (var i = 0, len = parents.length; i < len; i++) {
                KUtil.addClass(parents[i], 'k-menu__item--open');
            }
        },

        /**
         * Returns page breadcrumbs for the menu's active item
         * @returns {KMenu}
         */
        getBreadcrumbs: function(item) {
            var query;
            var breadcrumbs = [];
            var link = KUtil.child(item, '.k-menu__link');

            breadcrumbs.push({
                text: (query = KUtil.child(link, '.k-menu__link-text') ? query.innerHTML : ''),
                title: link.getAttribute('title'),
                href: link.getAttribute('href')
            });

            var parents = KUtil.parents(item, '.k-menu__item--submenu');
            for (var i = 0, len = parents.length; i < len; i++) {
                var submenuLink = KUtil.child(parents[i], '.k-menu__link');

                breadcrumbs.push({
                    text: (query = KUtil.child(submenuLink, '.k-menu__link-text') ? query.innerHTML : ''),
                    title: submenuLink.getAttribute('title'),
                    href: submenuLink.getAttribute('href')
                });
            }

            return  breadcrumbs.reverse();
        },

        /**
         * Returns page title for the menu's active item
         * @returns {KMenu}
         */
        getPageTitle: function(item) {
            var query;

            return (query = KUtil.child(item, '.k-menu__link-text') ? query.innerHTML : '');
        },

        /**
         * Trigger events
         */
        eventTrigger: function(name, args) {
            for (var i = 0; i < the.events.length; i++ ) {
                var event = the.events[i];
                if ( event.name == name ) {
                    if ( event.one == true ) {
                        if ( event.fired == false ) {
                            the.events[i].fired = true;
                            event.handler.call(this, the, args);
                        }
                    } else {
                        event.handler.call(this, the, args);
                    }
                }
            }
        },

        addEvent: function(name, handler, one) {
            the.events.push({
                name: name,
                handler: handler,
                one: one,
                fired: false
            });
        },

        removeEvent: function(name) {
            if (the.events[name]) {
                delete the.events[name];
            }
        }
    };

    //////////////////////////
    // ** Public Methods ** //
    //////////////////////////

    /**
     * Set default options 
     */

    the.setDefaults = function(options) {
        defaultOptions = options;
    };

    /**
     * Update scroll
     */
    the.scrollUpdate = function() {
        return Plugin.scrollUpdate();
    };

    /**
     * Re-init scroll
     */
    the.scrollReInit = function() {
        return Plugin.scrollInit();
    };

    /**
     * Scroll top
     */
    the.scrollTop = function() {
        return Plugin.scrollTop();
    };

    /**
     * Set active menu item
     */
    the.setActiveItem = function(item) {
        return Plugin.setActiveItem(item);
    };

    the.reload = function() {
        return Plugin.reload();
    };

    the.update = function(options) {
        return Plugin.update(options);
    };

    /**
     * Set breadcrumb for menu item
     */
    the.getBreadcrumbs = function(item) {
        return Plugin.getBreadcrumbs(item);
    };

    /**
     * Set page title for menu item
     */
    the.getPageTitle = function(item) {
        return Plugin.getPageTitle(item);
    };

    /**
     * Get submenu mode
     */
    the.getSubmenuMode = function(el) {
        return Plugin.getSubmenuMode(el);
    };

    /**
     * Hide dropdown submenu
     * @returns {jQuery}
     */
    the.hideDropdown = function(item) {
        Plugin.hideSubmenuDropdown(item, true);
    };

    /**
     * Disable menu for given time
     * @returns {jQuery}
     */
    the.pauseDropdownHover = function(time) {
        Plugin.pauseDropdownHover(time);
    };

    /**
     * Disable menu for given time
     * @returns {jQuery}
     */
    the.resumeDropdownHover = function() {
        return Plugin.resumeDropdownHover();
    };

    /**
     * Register event
     */
    the.on = function(name, handler) {
        return Plugin.addEvent(name, handler);
    };

    the.off = function(name) {
        return Plugin.removeEvent(name);
    };

    the.one = function(name, handler) {
        return Plugin.addEvent(name, handler, true);
    };

    ///////////////////////////////
    // ** Plugin Construction ** //
    ///////////////////////////////

    // Run plugin
    Plugin.construct.apply(the, [options]);

    // Handle plugin on window resize
    KUtil.addResizeHandler(function() {
        if (init) {
            the.reload();
        }  
    });

    // Init done
    init = true;

    // Return plugin instance
    return the;
};

// Plugin global lazy initialization
document.addEventListener("click", function (e) {
    var body = KUtil.get('body');
    var query;
    if ( query = body.querySelectorAll('.k-menu__nav .k-menu__item.k-menu__item--submenu.k-menu__item--hover:not(.k-menu__item--tabs)[data-kmenu-submenu-toggle="click"]') ) {
        for (var i = 0, len = query.length; i < len; i++) {
            var element = query[i].closest('.k-menu__nav').parentNode;

            if ( element ) {
                var the = KUtil.data(element).get('menu');

                if ( !the ) {
                    break;
                }

                if ( !the || the.getSubmenuMode() !== 'dropdown' ) {
                    break;
                }

                if ( e.target !== element && element.contains(e.target) === false ) {
                    var items;
                    if ( items = element.querySelectorAll('.k-menu__item--submenu.k-menu__item--hover:not(.k-menu__item--tabs)[data-kmenu-submenu-toggle="click"]') ) {
                        for (var j = 0, cnt = items.length; j < cnt; j++) {
                            the.hideDropdown(items[j]);
                        }
                    }
                }
            }            
        }
    } 
});