<?php
?>

<footer class="site-footer">
    <div class="footer-inner">
        <h6 class="copyright"><?php echo '©'.date('Y').' - Alban DOINEL'; ?></h6>
    </div>
</footer>
<style>
@import url("static/site.css");
    .site-footer{
        position: sticky;
        bottom: 0;
        left: 0;
        right: 0;
        margin-top: auto;
        width: 100%;
        text-align: center;
        z-index: 9999;
        pointer-events: none;
        background: rgba(5, 11, 24, 0.72);
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        padding: clamp(0.18rem, 0.8vw, 0.35rem) 0;
        transform: translateY(110%);
        opacity: 0;
        visibility: hidden;
        transition: transform 0.25s ease, opacity 0.25s ease, visibility 0.25s ease;
    }

    .site-footer.visible{
        transform: translateY(0);
        opacity: 1;
        visibility: visible;
        pointer-events: none;
    }

    .site-footer .copyright{
        margin: 0;
        font-size: clamp(0.75rem, 2vw, 0.875rem);
        font-weight: 500;
        color: #d4e1ff;
        text-shadow: 0.075rem 0.075rem 0.3rem rgba(0,0,0,0.35);
        opacity: 0.98;
    }
</style>
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
