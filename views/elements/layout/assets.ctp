
<?php echo $this->Html->css(array(
	'cake.generic',
)) ?>

<!-- jQuery library loading -->
<script type="text/javascript" src="//www.google.com/jsapi"></script>
<script type="text/javascript">google.load("jquery", "1.4.4");</script>
<!-- effect javascript here -->

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-20815269-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

<?php echo $scripts_for_layout ?>