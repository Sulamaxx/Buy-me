<?php if($cookieConsentConfig['enabled'] && ! $alreadyConsentedWithCookies): ?>

    <?php echo $__env->make('cookie-consent::dialogContents', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>

        window.laravelCookieConsent = (function () {

            const COOKIE_VALUE = 1;
            const COOKIE_DOMAIN = '<?php echo e(config('session.domain') ?? request()->getHost()); ?>';

            function consentWithCookies() {
                setCookie('<?php echo e($cookieConsentConfig['cookie_name']); ?>', COOKIE_VALUE, <?php echo e($cookieConsentConfig['cookie_lifetime']); ?>);
                hideCookieDialog();
            }
    
            function consentWithoutCookies() {
                clearDomainCookies();
                
                let message = "<?php echo e(t('cookie_consent_disagree_message')); ?>";
                jsAlert(message, 'warning', false, true, true);
            }

            function cookieExists(name) {
                return (document.cookie.split('; ').indexOf(name + '=' + COOKIE_VALUE) !== -1);
            }

            function hideCookieDialog() {
                const dialogs = document.getElementsByClassName('js-cookie-consent');

                for (let i = 0; i < dialogs.length; ++i) {
                    dialogs[i].style.display = 'none';
                }
            }

            function setCookie(name, value, expirationInDays) {
                const date = new Date();
                date.setTime(date.getTime() + (expirationInDays * 24 * 60 * 60 * 1000));
                document.cookie = name + '=' + value
                    + ';expires=' + date.toUTCString()
                    + ';domain=' + COOKIE_DOMAIN
                    + ';path=/<?php echo e(config('session.secure') ? ';secure' : null); ?>'
                    + '<?php echo e(config('session.same_site') ? ';samesite='.config('session.same_site') : null); ?>';
            }
            
            function clearDomainCookies() {
                var cookies = document.cookie.split("; ");
                for (var c = 0; c < cookies.length; c++) {
                    var d = window.location.hostname.split(".");
                    while (d.length > 0) {
                        var cookieBase = encodeURIComponent(cookies[c].split(";")[0].split("=")[0]) + '=; expires=Thu, 01-Jan-1970 00:00:01 GMT; domain=' + d.join('.') + ' ;path=';
                        var p = location.pathname.split('/');
                        document.cookie = cookieBase + '/';
                        while (p.length > 0) {
                            document.cookie = cookieBase + p.join('/');
                            p.pop();
                        }
                        d.shift();
                    }
                }
            }
            
            if (cookieExists('<?php echo e($cookieConsentConfig['cookie_name']); ?>')) {
                hideCookieDialog();
            }
            
            
            const agreeButtons = document.getElementsByClassName('js-cookie-consent-agree');
            for (let i = 0; i < agreeButtons.length; ++i) {
                agreeButtons[i].addEventListener('click', consentWithCookies);
            }
            
            
            const disagreeButtons = document.getElementsByClassName('js-cookie-consent-disagree');
            for (let i = 0; i < disagreeButtons.length; ++i) {
                disagreeButtons[i].addEventListener('click', consentWithoutCookies);
            }
            
            return {
                consentWithCookies: consentWithCookies,
                hideCookieDialog: hideCookieDialog
            };
        })();
    </script>

<?php endif; ?>
<?php /**PATH F:\Work\Sulochana\Buyme.lk\Buy-me\resources\views/vendor/cookie-consent/index.blade.php ENDPATH**/ ?>