(function ($) {
    "use strict";

    // Constructor
    function NotificationApp() { }

    /**
     * Show Notification
     * @param {string} heading - Notification title
     * @param {string|array} text - Message or list of messages
     * @param {string} position - top-right, top-left, bottom-right, bottom-left, top-center, bottom-center
     * @param {string} loaderBg - Loader background color (e.g. rgba(0,0,0,0.2))
     * @param {string} icon - success | error | warning | info
     * @param {int|false} hideAfter - Auto hide after ms or false for sticky
     * @param {int} stack - How many toasts to stack
     * @param {string} transition - fade | slide | plain
     */
    NotificationApp.prototype.send = function (
        heading, text, position, loaderBg, icon,
        hideAfter, stack, transition
    ) {
        var toastConfig = {
            heading: heading || '',
            text: text || '',
            position: position || 'top-right',
            loaderBg: loaderBg || 'rgba(0,0,0,0.2)',
            icon: icon || 'info',
            hideAfter: hideAfter || 6000,
            stack: stack || 1,
            showHideTransition: transition || 'fade'
        };

        $.toast().reset('all');
        $.toast(toastConfig);
    };

    // Create global object
    $.NotificationApp = new NotificationApp();
    $.NotificationApp.Constructor = NotificationApp;

})(window.jQuery);
