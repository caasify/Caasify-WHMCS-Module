<iframe src="{$systemurl}modules/addons/caasify/views/view/index.php" class="caasify" id="myIframe" onload="initResize()"></iframe>
<style type="text/css">
.caasify{
    width: 100%;
    height: 1000px;
    border: none;
}
</style>

<script>

setTimeout(function() {
    location.reload()
}, 120000);

function initResize() {
  const iframe = document.getElementById('myIframe');
  const iframeDoc = iframe.contentWindow.document;

  const resize = () => {
    iframe.style.height = (iframeDoc.body.scrollHeight + 100) + 'px';
  };

  // Observe changes inside iframe
  const observer = new iframe.contentWindow.MutationObserver(resize);
  observer.observe(iframeDoc.body, {
    attributes: true,
    childList: true,
    subtree: true
  });

  // Initial resize
  resize();
}
</script>