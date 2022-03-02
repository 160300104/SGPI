var KDemoPanel = function() {
    var demoPanel = KUtil.getByID('k_demo_panel');
    var offcanvas;

    var init = function() {
        offcanvas = new KOffcanvas(demoPanel, {
            overlay: true,  
            baseClass: 'k-demo-panel',
            closeBy: 'k_demo_panel_close',
            toggleBy: 'k_demo_panel_toggle'
        }); 

        var head = KUtil.find(demoPanel, '.k-demo-panel__head');
        var body = KUtil.find(demoPanel, '.k-demo-panel__body');

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
        
                height = height - parseInt(KUtil.css(demoPanel, 'paddingTop'));
                height = height - parseInt(KUtil.css(demoPanel, 'paddingBottom'));    

                return height;
            }
        });

        offcanvas.on('hide', function() {
            alert(1);
            var expires = new Date(new Date().getTime() + 60 * 60 * 1000); // expire in 60 minutes from now
            Cookies.set('k_demo_panel_shown', 1, { expires: expires });
        });
    }

    var remind = function() {
        if (!(encodeURI(window.location.hostname) == 'keenthemes.com' || encodeURI(window.location.hostname) == 'www.keenthemes.com')) {
            return;
        }

        setTimeout(function() {
            if (!Cookies.get('k_demo_panel_shown')) {
                var expires = new Date(new Date().getTime() + 15 * 60 * 1000); // expire in 15 minutes from now
                Cookies.set('k_demo_panel_shown', 1, { expires: expires });
                offcanvas.show();
            } 
        }, 4000);
    }

    return {     
        init: function() {  
            init(); 
            remind();
        }
    };
}();

$(document).ready(function() {
    KDemoPanel.init();
});