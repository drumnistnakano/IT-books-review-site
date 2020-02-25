// コメントの表示・非表示のイベントハンドラ
window.onload = function() {
  var btn = document.getElementsByName('display_comments');
  btn.forEach(function(e) {
      e.addEventListener("click", function() {
          document.display.submit();
      });
  });
};