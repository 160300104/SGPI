var KOffcanvasPanel = function() {
    var notificationPanel = KUtil.get('k_offcanvas_toolbar_notifications');
    var quickActionsPanel = KUtil.get('k_offcanvas_toolbar_quick_actions');
    var profilePanel = KUtil.get('k_offcanvas_toolbar_profile');
    var searchPanel = KUtil.get('k_offcanvas_toolbar_search');

    var initNotifications = function() {
        var head = KUtil.find(notificationPanel, '.k-offcanvas-panel__head');
        var body = KUtil.find(notificationPanel, '.k-offcanvas-panel__body');

        var offcanvas = new KOffcanvas(notificationPanel, {
            overlay: true,  
            baseClass: 'k-offcanvas-panel',
            closeBy: 'k_offcanvas_toolbar_notifications_close',
            toggleBy: 'k_offcanvas_toolbar_notifications_toggler_btn'
        }); 

        KUtil.scrollInit(body, {
            disableForMobile: true, 
            resetHeightOnDestroy: true, 
            handleWindowResize: true, 
            height: function() {
                var height = parseInt(KUtil.getViewPort().height);
               
                if (head) {
                    height = height - parseInt(KUtil.actualHeight(head));
                    height = height - parseInt(KUtil.css(head, 'marginBottom'));
                }
        
                height = height - parseInt(KUtil.css(notificationPanel, 'paddingTop'));
                height = height - parseInt(KUtil.css(notificationPanel, 'paddingBottom'));    

                return height;
            }
        });
    }

    var initQucikActions = function() {
        var head = KUtil.find(quickActionsPanel, '.k-offcanvas-panel__head');
        var body = KUtil.find(quickActionsPanel, '.k-offcanvas-panel__body');

        var offcanvas = new KOffcanvas(quickActionsPanel, {
            overlay: true,  
            baseClass: 'k-offcanvas-panel',
            closeBy: 'k_offcanvas_toolbar_quick_actions_close',
            toggleBy: 'k_offcanvas_toolbar_quick_actions_toggler_btn'
        }); 

        KUtil.scrollInit(body, {
            disableForMobile: true, 
            resetHeightOnDestroy: true, 
            handleWindowResize: true, 
            height: function() {
                var height = parseInt(KUtil.getViewPort().height);
               
                if (head) {
                    height = height - parseInt(KUtil.actualHeight(head));
                    height = height - parseInt(KUtil.css(head, 'marginBottom'));
                }
        
                height = height - parseInt(KUtil.css(quickActionsPanel, 'paddingTop'));
                height = height - parseInt(KUtil.css(quickActionsPanel, 'paddingBottom'));    

                return height;
            }
        });
    }

    var initProfile = function() {
        var head = KUtil.find(profilePanel, '.k-offcanvas-panel__head');
        var body = KUtil.find(profilePanel, '.k-offcanvas-panel__body');

        var offcanvas = new KOffcanvas(profilePanel, {
            overlay: true,  
            baseClass: 'k-offcanvas-panel',
            closeBy: 'k_offcanvas_toolbar_profile_close',
            toggleBy: 'k_offcanvas_toolbar_profile_toggler_btn'
        }); 

        KUtil.scrollInit(body, {
            disableForMobile: true, 
            resetHeightOnDestroy: true, 
            handleWindowResize: true, 
            height: function() {
                var height = parseInt(KUtil.getViewPort().height);
               
                if (head) {
                    height = height - parseInt(KUtil.actualHeight(head));
                    height = height - parseInt(KUtil.css(head, 'marginBottom'));
                }
        
                height = height - parseInt(KUtil.css(profilePanel, 'paddingTop'));
                height = height - parseInt(KUtil.css(profilePanel, 'paddingBottom'));    

                return height;
            }
        });
    }

    var initSearch = function() {
        var head = KUtil.find(searchPanel, '.k-offcanvas-panel__head');
        var body = KUtil.find(searchPanel, '.k-offcanvas-panel__body');
        
        var offcanvas = new KOffcanvas(searchPanel, {
            overlay: true,  
            baseClass: 'k-offcanvas-panel',
            closeBy: 'k_offcanvas_toolbar_search_close',
            toggleBy: 'k_offcanvas_toolbar_search_toggler_btn'
        }); 

        KUtil.scrollInit(body, {
            disableForMobile: true, 
            resetHeightOnDestroy: true, 
            handleWindowResize: true, 
            height: function() {
                var height = parseInt(KUtil.getViewPort().height);
               
                if (head) {
                    height = height - parseInt(KUtil.actualHeight(head));
                    height = height - parseInt(KUtil.css(head, 'marginBottom'));
                }
        
                height = height - parseInt(KUtil.css(searchPanel, 'paddingTop'));
                height = height - parseInt(KUtil.css(searchPanel, 'paddingBottom'));    

                return height;
            }
        });
    }

    return {     
        init: function() {  
            initNotifications(); 
            initQucikActions();
            initProfile();
            initSearch();
        }
    };
}();

$(document).ready(function() {
    KOffcanvasPanel.init();
});