var KQuickPanel = function() {
    var panel = KUtil.get('k_quick_panel');
    var notificationPanel = KUtil.get('k_quick_panel_tab_notifications');
    var actionsPanel = KUtil.get('k_quick_panel_tab_actions');
    var settingsPanel = KUtil.get('k_quick_panel_tab_settings');

    var getContentHeight = function() {
        var height;
        var nav = KUtil.find(panel, '.k-quick-panel__nav');
        var content = KUtil.find(panel, '.k-quick-panel__content');

        height = parseInt(KUtil.getViewPort().height) - parseInt(KUtil.actualHeight(nav)) - (2 * parseInt(KUtil.css(nav, 'padding-top'))) - 10;

        return height;
    }

    var initOffcanvas = function() {
        var offcanvas = new KOffcanvas(panel, {
            overlay: true,  
            baseClass: 'k-quick-panel',
            closeBy: 'k_quick_panel_close_btn',
            toggleBy: 'k_quick_panel_toggler_btn'
        });   
    }

    var initNotifications = function() {
        KUtil.scrollInit(notificationPanel, {
            disableForMobile: true, 
            resetHeightOnDestroy: true, 
            handleWindowResize: true, 
            height: function() {
                return getContentHeight();
            }
        });
    }

    var initActions = function() {
        KUtil.scrollInit(actionsPanel, {
            disableForMobile: true, 
            resetHeightOnDestroy: true, 
            handleWindowResize: true, 
            height: function() {
                return getContentHeight();
            }
        });
    }

    var initSettings = function() {
        KUtil.scrollInit(settingsPanel, {
            disableForMobile: true, 
            resetHeightOnDestroy: true, 
            handleWindowResize: true, 
            height: function() {
                return getContentHeight();
            }
        });
    }

    var updatePerfectScrollbars = function() {
        $(panel).find('a[data-toggle="tab"]').on('shown.bs.tab', function (e) { 
            KUtil.scrollUpdate(notificationPanel);
            KUtil.scrollUpdate(actionsPanel);
            KUtil.scrollUpdate(settingsPanel);
        });
    }

    return {     
        init: function() {  
            initOffcanvas(); 
            initNotifications();
            initActions();
            initSettings();
            updatePerfectScrollbars();
        }
    };
}();

$(document).ready(function() {
    KQuickPanel.init();
});