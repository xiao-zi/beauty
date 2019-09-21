<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------
namespace User\Model;
use Think\Model;
/**
 * 后台管理员模型
 */
class UserModel extends Model{
	protected $trueTableName = 'admin_user';

	/**
	 * @param $username 账户
	 * @param $password 密码
	 * @param $check 是否记住密码
	 */
	public function login($username,$password,$check){
		$user = M('AdminUser');
		//查找用户信息
		$info = $user->where(array('username'=>$username))->find();
		if($info){
			//验证密码是否正确
			if(PasswordEncryption($password, UC_AUTH_KEY) == $info['password'] ){
				if($info['status'] == 'activation'){
					$data  = array(
						'id'=>$info['id'],
						'username'=>$info['username'],
						'realname'=>$info['realname'],
						'image'=>$info['image'],
						'grouping'=>$info['grouping'],
					);
					$_SESSION['admin'] = $data;
					if($check == 'on'){
						//将登录信息，存放在Cookie中,7天后过期
						$data = json_encode($data);
						setcookie('Login', $data,time()+60*60*24*7,'/');
					}
					$this->updateLogin($info['id']);//更新用户登录时间和ip地址
					$back['rel'] = 1;
					$back['msg'] = GSL('Login-successfully');
				}else{
					$back['rel'] = 3;
					$back['msg'] =GSL('not-login');
				}
			}else{
				$back['rel'] = 2;
				$back['msg'] =GSL('password').' '.GSL('error');
			}
		}else{
			$back['rel'] = 0;
			$back['msg'] =GSL('no-user');
		}
		return $back;
	}
	/**
	 * 查找后台管理人员信息
	 * @param $where
	 * @param $order
	 * @param $limit
	 * @param $field
	 * @return mixed
	 */
	public function selectUser($where,$order,$limit,$field){
		$data = $this->where($where)->order($order)->limit($limit)->field($field)->select();
		return $data;
	}

	/**
	 * 更新用户登录状态
	 * @param $id 用户的id
	 */
	public function updateLogin($id){
		$user = M('Admin_user');
		$map['id'] = $id;
		$data = array(
			'login_time'=>date("Y-m-d H:i:s",time()),
			'login_ip'=>get_client_ip()
		);
		$result = $user->where($map)->save($data);
		return $result;
	}

	/**
	 * 修改后台管理员的状态数据
	 * @param $id
	 * @param $data
	 * @return bool
	 */
	public function updateUserStatus($id,$data){
		$user = M('Admin_user');
		$map['id'] = $id;
		$result = $user->where($map)->save($data);
		return $result;
	}

	/**
	 * 添加后台管理员
	 * @param $data
	 * @return mixed
	 */
	public function createUser($data){
		$rule = array(
			'username'=>array(
				array('unique','',GSL('account').' '.GSL('must-be-unique')),
				array('request','',GSL('account').' '.GSL('must-fill-in')),
				array('regular','/[\s\S]*/',GSL('account').' '.GSL('Non-conformity')),
			),
			'realname'=>array(
				array('request','',GSL('nickname').' '.GSL('must-fill-in')),
			),
			'password'=>array(
				array('request','',GSL('password').' '.GSL('must-fill-in')),
			),
			'phone'=>array(
				array('request','',GSL('phone').' '.GSL('must-fill-in')),
			),
			'email'=>array(
				array('request','',GSL('email').' '.GSL('must-fill-in')),
				array('regular','/^\w+([-.]\w+)*@\w+([-]\w+)*\.(\w+([-]\w+)*\.)*[a-z]{2,3}$/',GSL('email').' '.GSL('Non-conformity')),
			),
			'grouping'=>array(
				array('request','',GSL('jurisdiction').' '.GSL('must-fill-in')),
				array('regular','/^\d+$/',GSL('jurisdiction').' '.GSL('Non-conformity')),
			),
		);
		$user = M('Admin_user');
		$back = Verification($user,$rule,$data,true);
		if(!$back){
			$data['password'] = PasswordEncryption($data['password'], UC_AUTH_KEY);
			$data['register_time'] = date("Y-m-d H:i:s",time());
			$data['register_ip'] = get_client_ip();
			$data['login_time'] = date("Y-m-d H:i:s",time());
			$data['login_ip'] = get_client_ip();
			$result = $user->add($data);
			return $back = array('rel'=>$result,'msg'=>GSL('create-success'));
		}else{
			return $back = array('rel'=>0,'msg'=>$back);
		}
	}

	/**
	 * 修改后台管理员的数据
	 * @param $id
	 * @param $data
	 * @return bool
	 */
	public function updateUser($id,$data){
		$user = M('Admin_user');
		$rule = array(
			'username'=>array(
				array('request','',GSL('account').' '.GSL('must-fill-in')),
				array('regular','/[\s\S]*/',GSL('account').' '.GSL('Non-conformity')),
			),
			'realname'=>array(
				array('request','',GSL('nickname').' '.GSL('must-fill-in')),
			),
			'phone'=>array(
				array('request','',GSL('phone').' '.GSL('must-fill-in')),
			),
			'email'=>array(
				array('request','',GSL('email').' '.GSL('must-fill-in')),
				array('regular','/^\w+([-.]\w+)*@\w+([-]\w+)*\.(\w+([-]\w+)*\.)*[a-z]{2,3}$/',GSL('email').' '.GSL('Non-conformity')),
			),
			'grouping'=>array(
				array('request','',GSL('jurisdiction').' '.GSL('must-fill-in')),
				array('regular','/^\d+$/',GSL('jurisdiction').' '.GSL('Non-conformity')),
			),
		);
		$back = Verification($user,$rule,$data,true);
		if(!$back){
			$map['id'] = $id;
			$result = $user->where($map)->save($data);
			return $back = array('rel'=>$result,'msg'=>GSL('update-success'));
		}else{
			return $back = array('rel'=>0,'msg'=>$back);
		}
	}

	/**
	 * 后台管理员修改密码
	 * @param $id
	 * @param $password
	 * @return array
	 */
	public function changePassword($id,$password){
		$user = M('Admin_user');
		$rule = array(
			'password'=>array(
				array('request','',GSL('password').' '.GSL('must-fill-in')),
			),
		);
		$data = array('password'=>PasswordEncryption($password, UC_AUTH_KEY));
		$back = Verification($user,$rule,$data,true);
		if(!$back){
			$map['id'] = $id;
			$result = $user->where($map)->save($data);
			return $back = array('rel'=>$result,'msg'=>GSL('update-success'));
		}else{
			return $back = array('rel'=>0,'msg'=>$back);
		}
	}
}
