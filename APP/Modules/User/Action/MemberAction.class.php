<?php
// +----------------------------------------------------------------------
// | AIMOZHEN [ SHARE VIDES SHARE LIFES ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://aimozhen.com All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: Gavin Foo <fuxiaopang@msn.com>
// +----------------------------------------------------------------------


/*
 * 用户登陆注册控制器
 */
class MemberAction extends CommonAction {

    // 用户首页
    public function Index() {
        $this->display();
    }

    // 登陆页面
    public function Login() {
        if (CommonAction::$user) $this->redirect('/');
        $this->wrong = null;
        if ( $_GET["wrong"] ) {
            if ($_GET["wrong"] == 'infor') {
                $this->wrong = '请检查您的用户名或密码';} else {
            	$this->wrong = '验证码错误';
                }
        }
        $this->display();
    }

    // 登陆页验证
    public function LoginVerify() {
        if (!IS_POST) _404('页面不存在...');

        if (I('verify' ,'', 'md5') != session('verify')) {
            $this->redirect('Login', array('wrong' => 'code'));
        }
        $email = I('email');
        $pwd = I('password', '', 'md5');

        self::LoginMethod($email, $pwd);

        $this->redirect('/');


    }

    // 全站快速登录验证
    public function FrontLoginVerify() {
        if (!IS_POST) _404('页面不存在...');

        $email = I('email');
        $pwd = I('password', '', 'md5');

        self::LoginMethod($email, $pwd);

        $this->redirect($_SERVER['HTTP_REFERER']);

    }



    // 注册页面
    public function Register() {
       if (CommonAction::$user) $this->redirect('/');
       if (!IS_POST) _404('页面不存在...');

        $regemail = I('email');
        $user = M('User')->field('id,email')->where(array('email' => $regemail))->find();

        if ($user) {
            echo "有";
            } else {
            $this->regemail = $regemail;
            $this->display();
            }
    }

   public function RegisterVerify() {
       if (CommonAction::$user) $this->redirect('/');
       if (!IS_POST) _404('页面不存在...');
       $email = I('email');
       if (M('User')->field('id,email')->where(array('email' => $email))->find()) $this->redirect('/');
	   
       if ( (I('hidden') != '') && (I('hidden') == md5($email)) ) {
           $data = array (
           'username' => I('name'),
           'password' => md5(I('pass1')),
           'email' => $email,
           'createdTime' => time(),
           'group' => 99
           );
		   
           if (I('invitecode') == 'animator'){
           	$data[verify] = 1;
            $data[guest] = 0;
           } elseif (I('invitecode') == 'animetaste'){
           	$data[verify] = 0;
            $data[guest] = 0;
           } else {
           	$data[verify] = 0;
            $data[guest] = 1;
           }
		   echo 112;
           if( M('User')->add($data)) {
            self::LoginMethod($email, $pwd = I('pass1', '', 'md5'));

            $this->redirect('/');
             }

            }
    }



    // 验证码
    public function Verify() {
        import('ORG.Util.Image');
        Image::buildImageVerify(4, 1, 'png');
    }


   // 登出页面
    public function Logout() {
        cookie(__u, null, -8640000);
        cookie(__c, null, -8640000);
        session('[destroy]');
        $this->redirect('/');
    }

   // 登陆通用方法
   private function LoginMethod($email, $pwd) {


        $user = M('User')->field('id,username,email,password,group,guest,verify')->where(array('email' => $email))->find();

        if (!$user || $user['password'] != $pwd){
            $this->redirect('Login', array('wrong' => 'infor'));
        }

        $data = array (
            'id' => $user[id],
            'loginTime' => time(),
            'loginIP' => get_client_ip()
            );

        M('User')->save($data);

        session('uid', $user['id']);
        session('username', $user['username']);
        session('group', $user['group']);
        session('guest', $user['guest']);
        session('verify', $user['verify']);

        cookie('__u',$user['id']);
        cookie('__c',sha1($user['id'] . '3xtc' . $user['password']));
   }

}
?>