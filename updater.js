(function ($) {
    $(function () {
        let timeout = null;
        let updateTimeInterval = 1500;
        let netlifyStatusBadgeImage = $('.netlify-status-badge img');
        let netlifyBadgeSrc = netlifyStatusBadgeImage.prop('src');
        
        let updateNetlifyStatusBadgeImage = function () {
            if (!netlifyStatusBadgeImage.length) {
                $('.netlify-status-badge').text("Netlify Badge Not Set");
                return;
            }
            netlifyStatusBadgeImage.prop('src',
                netlifyBadgeSrc + '?_=' + Math.random()
            ).error(function () {
                $('.netlify-status-badge').text("Netlify Badge Not Set");
            });
            timeout = setTimeout(updateNetlifyStatusBadgeImage, updateTimeInterval);
        };
        timeout = setTimeout(updateNetlifyStatusBadgeImage, updateTimeInterval);
    });
})(jQuery);
