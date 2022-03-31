<?php
$calendlyAddress = propertyGetData($_SESSION["property_code"],'property_calendly');
?>


<script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js">
    Calendly.initInlineWidget({
 url: 'https://calendly.com/<?php echo $calendlyAddress; ?>',
 parentElement: document.getElementById('SAMPLEdivID'),
 prefill: {},
 utm: {}
});
</script>

<!-- Calendly inline widget begin -->
<div class="calendly-inline-widget" style="min-width:320px;height:100%;" data-auto-load="false">
<script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>
<script>
Calendly.initInlineWidget({
url: 'https://calendly.com/<?php echo $calendlyAddress; ?>?hide_gdpr_banner=1'
});
</script>
</div>
<!-- Calendly inline widget end -->
