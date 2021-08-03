


<div class="fluid-container">

    <hr class="hr-text" data-content="">

</div>

<footer class="footer">
    <div class="fluid-container">
        <hr class="mt-50 hr-text" data-content="">
        <span class="text-muted">&copy; <?php echo date("Y"); ?> Cloud Transcode  <p class="float-right">Make Better!</p> </span>

    </div>
</footer>


<script>
    var clipboard = new ClipboardJS('.btn');

    clipboard.on('success', function(e) {
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);
        e.clearSelection();
    });

    clipboard.on('error', function(e) {
        console.error('Action:', e.action);
        console.error('Trigger:', e.trigger);
    });
</script>
</body>
</html>
