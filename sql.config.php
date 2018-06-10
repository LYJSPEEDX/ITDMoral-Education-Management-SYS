<?php
  $conn=@mysqli_connect("host","usr","passwd","db");

  //PHP内置函数（Errno为错误码）
  if(mysqli_connect_errno($conn)){
  	$error = mysqli_connect_errno($conn);
  	echo <<<EOT
  	<div class="modal fade" id="dberror" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">OOPS...</h5>
      </div>
      <div class="modal-body">
        抱歉，系统目前尚不可用，请稍后访问！
      </div>
      <div class="modal-footer">
        错误代码，请提交于ITD：{$error}
      </div>
    </div>
  </div>
</div>
EOT;
  	die ("<script>$('#dberror').modal();</script>");
  }
?>
