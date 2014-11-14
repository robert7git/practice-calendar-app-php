<div id="footer" class="footer">
	robert7.com
</div>

<?php if (isset($js_files)):?>
	<?php foreach ($js_files as $js):?>
		<script src="assets/js/<?php echo $js; ?>" type="text/javascript"></script>
	<?php endforeach?>
<?php endif?>
</body>
</html>