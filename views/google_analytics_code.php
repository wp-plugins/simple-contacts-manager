<?php 
	$ga_id = $this->get_analytics_id();
	if( !empty( $ga_id ) && $this->_check_insert_codes() ) {
?>

        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='https://www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','<?php echo $this->get_analytics_id(); ?>','auto');ga('send','pageview');
        </script>

<?php } ?>