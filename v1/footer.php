<footer class="site-footer">
    <div class="footer-inner">
        <h6 class="copyright"><?php echo '©'.date('Y').' - Alban DOINEL'; ?></h6>
    </div>
</footer>
<script>
(function() {
    var footer = document.querySelector('.site-footer');
    if (!footer) return;

    function updateViewportHeight() {
        var height = window.innerHeight || document.documentElement.clientHeight || 1;
        document.documentElement.style.setProperty('--viewport-height', height + 'px');
    }

    function checkFooter() {
        var atBottom = (window.innerHeight + window.pageYOffset) >= (document.documentElement.scrollHeight - 10);
        footer.classList.toggle('visible', atBottom);
    }

    function syncFooter() {
        updateViewportHeight();
        checkFooter();
    }

    window.addEventListener('scroll', checkFooter, { passive: true });
    window.addEventListener('resize', syncFooter, { passive: true });
    window.addEventListener('orientationchange', syncFooter, { passive: true });
    window.addEventListener('load', syncFooter);
    window.addEventListener('pageshow', syncFooter);

    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        requestAnimationFrame(syncFooter);
    } else {
        document.addEventListener('DOMContentLoaded', function() {
            requestAnimationFrame(syncFooter);
        });
    }

    window.setTimeout(syncFooter, 0);
    window.setTimeout(syncFooter, 150);
})();
</script>
