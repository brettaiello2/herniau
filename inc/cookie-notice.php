<!-- Cookie Consent Notice -->
<div id="cookie-notice" style="display:none; position:fixed; bottom:0; left:0; width:100%; background:#222; color:#fff; padding:15px; text-align:center; z-index:9999;">
  <span>
    We use cookies to ensure you get the best experience on our website. 
    <a href="/privacy-policy" style="color: var(--gold); text-decoration:underline;">Learn more</a>
  </span>

  <div class="wp-block-button" id="cookie-accept"><a class="wp-block-button__link wp-element-button" href="javascript:void(0);">Accept</a></div>
</div>

<script>
  (function() {
    const notice = document.getElementById('cookie-notice');
    const acceptBtn = document.getElementById('cookie-accept');

    if (!localStorage.getItem('cookie_consent')) {
      notice.style.display = 'block';
    }

    acceptBtn.addEventListener('click', function() {
      localStorage.setItem('cookie_consent', 'true');
      notice.style.display = 'none';
    });
  })();
</script>
