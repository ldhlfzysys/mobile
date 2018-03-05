<?php
$api_url_v1 = "https://bdbbuy.com/index.php/api/soap/?wsdl";
$username = 'mobile';
$password = 'mobile';

//连接 SOAP
$client = new SoapClient($api_url_v1);
//获取登入后的 Session ID
$session_id = $client->login($username, $password);
//调用 API 中的方法
$result = $client->resources($session_id);
foreach($result as $k1=>$v1)
    {
        echo '<div class="box1"><dl>';
        echo '<dt>Title:</dt><dd>'.$v1['title'].'</dd>';
        echo '<dt>Name:</dt><dd>'.$v1['name'].'</dd>';
        echo '<dt>methods:</dt><dd>';
        if(count($v1['methods'])){
            echo '<ul>';
            foreach($v1['methods'] as $k2=>$v2)
            {
                echo '<li>Title:'.$v2['title'].'</li>';
                echo '<li>Name:'.$v2['name'].'</li>';
                echo '<li class="path">Path:'.$v2['path'].'</li>';
            }
            echo '</ul></dd>';
        }
        echo '</dl></div>============================<br>';
    }
?>