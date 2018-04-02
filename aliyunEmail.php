<?php    
    include_once('./config.php');
    include_once('./user.php');
    include_once 'aliyun-php-sdk-core/Config.php';
    use Dm\Request\V20151123 as Dm;


    function senEmail($email,$link,$username){
         //需要设置对应的region名称，如华东1（杭州）设为cn-hangzhou，新加坡Region设为ap-southeast-1，澳洲Region设为ap-southeast-2。
        $iClientProfile = DefaultProfile::getProfile("ap-southeast-1", "LTAIY7n7cywkJOV4", "VsrK5ML3EQ4tkeRY1UC029JhvlJb6H");        
        //新加坡或澳洲region需要设置服务器地址，华东1（杭州）不需要设置。
        $iClientProfile::addEndpoint("ap-southeast-1","ap-southeast-1","Dm","dm.ap-southeast-1.aliyuncs.com");
        //$iClientProfile::addEndpoint("ap-southeast-2","ap-southeast-2","Dm","dm.ap-southeast-2.aliyuncs.com");
        $client = new DefaultAcsClient($iClientProfile);    
        $request = new Dm\SingleSendMailRequest();     
        //新加坡或澳洲region需要设置SDK的版本，华东1（杭州）不需要设置。
        $request->setVersion("2017-06-22");

        $request->setAccountName("service@m.bdbbuy.com");
        $request->setFromAlias("bdbbuy-八点半买");
        $request->setAddressType(1);
        $request->setTagName("getPassword");
        $request->setReplyToAddress("false");// 回信地址
        $request->setToAddress($email);        
        $request->setSubject("重置密码");
        // $request->setHtmlBody("邮件正文");   

        $body = getHtmlBody($link,$username);
        $request->setHtmlBody($body);

        $res = array(
            "status"=>0,
            "requestId"=>'',
            "msg" =>"邮件发送成功"
        );
        try {
            $response = $client->getAcsResponse($request);
            // print_r($response);
        }catch (ClientException  $e) {
            // print_r($e->getErrorCode());   
            // print_r($e->getErrorMessage());  
            $res = array(
                "status"=>-1,
                "msg" =>"邮件发送失败"
            ); 
        }catch (ServerException  $e) {        
            // print_r($e->getErrorCode());   
            // print_r($e->getErrorMessage());
            $res = array(
                "status"=>-1,
                "msg" =>"邮件发送失败"
            );
        }
        return $res;
    }       

    // 邮件内容
    function getHtmlBody($link,$username){
        $htmlBody = '
                <table width="650">
                    <tbody>
                        <tr class="firstRow">
                            <td valign="top" style="color: rgb(47, 47, 47); font-size: 11px; line-height: 1.35em;">
                                <h1 style="font-size: 22px; font-weight: normal; line-height: 22px; margin: 0px 0px 11px;">
                                    亲爱的'. $username .',
                                </h1>
                                <p style="font-size: 12px; line-height: 16px; margin-bottom: 8px;">
                                    您的账户近期有修改密码的请求.
                                </p>
                                <p style="font-size: 12px; line-height: 16px;">
                                    如果您提出了申请，请点击如下链接重新设置密码:
                                    <span class="Apple-converted-space">&nbsp;</span>
                                    <a href=" ' . $link . '" style="color: rgb(30, 126, 200);">'
                                    . $link . '
                                    </a>
                                </p>
                                <p style="font-size: 12px; line-height: 16px;">
                                    如果点击无法进行链接，请将该 URL 复制并粘贴到浏览器中.
                                </p><br/>
                                <p style="font-size: 12px; line-height: 16px;">
                                    如果您未提出申请，请忽略本信息并且您的密码将保持不变.
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td style="color: rgb(47, 47, 47); font-size: 11px; line-height: 1.35em; background-color: rgb(234, 234, 234); text-align: center;">
                                <p style="font-size: 12px;">
                                    谢谢,<span class="Apple-converted-space">&nbsp;</span><strong>八点半买(<a href="http://bdbbuy.com/">bdbbuy.com</a>)</strong>
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>';
        return $htmlBody;
    }

    // 测试
    // if (isset($_GET['email'])) {
    //     echo guid();
    // }

    // 生成GUID
    function guid(){
        if (function_exists('com_create_guid')){
            return com_create_guid();
        }else{
            mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
            $charid = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);// "-"
            $uuid = substr($charid, 0, 8).$hyphen
                    .substr($charid, 8, 4).$hyphen
                    .substr($charid,12, 4).$hyphen
                    .substr($charid,16, 4).$hyphen
                    .substr($charid,20,12);
            return $uuid;
        }
    }

    // 发送激活邮件
    if (isset($_POST['email']) && isset($_POST['sendEmail'])) {
        $email = $_POST['email'];
        $result = getUserByEmail($email);
        $res = array(
                "status" => 0,
                "msg" => "操作成功"
            );

        if (count($result) == 1) {
            # 找到用户
            $userinfo = $result[0];

            $userid = $userinfo['customer_id'];
            $username = $userinfo['lastname'] . $userinfo['firstname'];

            // 产生重置连接地址
            // 设置tocken
            $redis = new Redis();
            $redis->connect($redisHost, $redisPort);
            $tocken = guid();
            $redis->setex($userid . '_tocken',7200,$tocken);//key=value，有效期为7200秒[true]

            $link = $baseHost . "resetPassword.phtml?id=" . $userid . '&tocken=' . $tocken;

            $res = senEmail($email,$link,$username);
            
        }else{
            // 用户不存在
            $res = array(
                "status" => -1,
                "msg" => "用户未注册"
            );
        }
        echo json_encode($res);
    }
   
?>