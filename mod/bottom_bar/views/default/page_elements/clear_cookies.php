<script>

  function initPage() {
    var c = document.cookie.split("/");
    for (var i = 0; i < c.length; i++) {
      if (c[i].indexOf("_html") != -1) {
	var cname = c[i].split("=")[0];
	$.cookie(cname, "", { path: "/"});
      }
    }
  }

  initPage();
 
</script>
