<div style="border:1px solid #990000;padding-left:20px;margin:0 0 10px 0;">
    <h4>A Fatal Error was encountered</h4>
    <p>Severity: <?php echo $severity; ?></p>
    <?php echo "<pre>"; ?>
    <p>Message:  <?php print_r($message); ?></p>
    <?php echo "</pre>"; ?>
    <p>Filename: <?php echo $filePath; ?></p>
    <p>Line Number: <?php echo $line; ?></p>
</div>