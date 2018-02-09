{__NOLAYOUT__}<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no"/>
    <title>跳转提示</title>
    <link href="/static/assets/global/plugins/bootstrap-sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
    <script src="/static/assets/global/plugins/jquery.min.js" type="text/javascript"></script>
    <script src="/static/assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js" type="text/javascript"></script>
    <script src="/static/assets/pages/scripts/ui-sweetalert.min.js" type="text/javascript"></script>
    <link href="/static/assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
</head>
<body>
<div class="system-message">
    <?php switch ($code) {?>
    <?php case 1:?>
    <script>
        swal({
        title: "成功提示",
        type: "success",
        html:true,
        text: '<h4><?php echo(strip_tags($msg)); ?></h4>' +
        '<b id="wait"><?php echo($wait);?></b> 秒之后自动跳转<br><br>' +
        '<a style="margin-top: 20px;text-decoration: none" id="href" href="<?php echo($url);?>" class="btn green">立即跳转</a>',
        showConfirmButton: false
    });
    </script>
    <?php break;?>
    <?php case 0:?>
    <script>
        swal({
            title: "失败提示",
            type: "error",
            html:true,
            text: '<h4><?php echo(strip_tags($msg)); ?></h4>' +
            '<b id="wait"><?php echo($wait);?></b> 秒之后自动跳转<br><br>' +
            '<a style="margin-top: 20px;text-decoration: none" id="href" href="<?php echo($url);?>" class="btn red">立即跳转</a>',
            showConfirmButton: false
        });
    </script>
    <?php break;?>
    <?php } ?>
    <b style = "display:none;"><?php echo($wait); ?></b> </p>


</div>



<script type="text/javascript">
    (function(){
        var wait = document.getElementById('wait'),
            href = document.getElementById('href').href;
        var interval = setInterval(function(){
            var time = --wait.innerHTML;
            if(time <= 0) {
                location.href = href;
                clearInterval(interval);
            };
        }, 1000);
    })();
</script>
</body>
</html>
