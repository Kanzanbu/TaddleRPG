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
</body>
</html>
