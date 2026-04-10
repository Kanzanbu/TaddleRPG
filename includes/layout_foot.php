<?php
// includes/layout_foot.php
?>
<footer class="site-footer">
    <span class="footer-text">TaddleRPG &nbsp;·&nbsp; CSC 4370/6370</span>
    <?php if (isset($_SESSION['user'])): ?>
        <span class="footer-user">
            <?= htmlspecialchars($_SESSION['user']) ?>
            &nbsp;<a href="logout.php">log out</a>
        </span>
    <?php endif; ?>
</footer>
<script>
// :has() fallback for Firefox < 121
if (!CSS.supports('selector(:has(input))')) {
    document.querySelectorAll('.class-option input[type="radio"]').forEach(function(r) {
        r.addEventListener('change', function() {
            document.querySelectorAll('.class-option').forEach(function(o) { o.classList.remove('selected'); });
            if (r.checked) r.closest('.class-option').classList.add('selected');
        });
        if (r.checked) r.closest('.class-option').classList.add('selected');
    });
}
</script>
</body>
</html>