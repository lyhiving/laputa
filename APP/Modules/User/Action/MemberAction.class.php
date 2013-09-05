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
        $this->page_name = "login";
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
            $this->error('对不起 该用户名已存在');
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
		   $uid = M('User')->add($data);
           if( $uid) {
            self::LoginMethod($email, $pwd = I('pass1', '', 'md5'));


			// 通知多说 同步用户
            import('Class.DuoShuo', APP_PATH);
            DuoShuo::syncUser($uid);

            $this->redirect('/home/setting/');
             }

            }
    }

	public function forget() {

		$v = I('v'); $uid = I('id');
		$user = M('user')->where(array('id' => $uid))->count();
		if (!$user) $this->redirect('/');

		$validate = M('user')->where(array('id' => $uid))->getField("validate");
		if ( $v != $validate ) {
			$this->error("验证信息有误 请重新申请");
		} else {
			$user = M('user')->field("id,username")->find($uid);
			$this->user = $user;
			$this->display();
		};
	}
	public function forgetHandle() {
		if (!IS_POST) _404('页面不存在...');
		$pass1 = I('pass1');$pass2 = I('pass2'); $uid = I('uid');
		$user = M('user')->where(array('id' => $uid))->count();
		if (!$user) $this->redirect('/');

		if ( $pass1 != $pass2 ) {
			$this->error("密码不相同");
		} else {
			$data = array('validate' =>'', 'password'=> md5($pass1));
			M('user')->where(array('id' => $uid))->save($data);
			$this->success("设置成功 请重新登录",U('member/login'));
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
        cookie('duoshuo_token', null, -8640000);
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

        cookie('__u',$user['id']);
        cookie('__c',sha1($user['id'] . '3stc' . $user['password']));

        import('Class.JWT', APP_PATH);  // 多收评论
		$token = array(
		    "short_name"=> C('DUOSHUO_USER'),
		    "user_key"=> $user['id'],
		    "name"=> $user['username'],
		);
		$duoshuoToken = JWT::encode($token, C('DUOSHUO_SECRET'));
		cookie('duoshuo_token',$duoshuoToken);

   }

}
?>