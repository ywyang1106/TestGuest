window.onload = function(){
 	captcha();
 	//登录表单验证
 	var oForm = document.getElementsByTagName('form')[0];
 	oForm.onsubmit = function(){
 		//用户名验证
		if(oForm.username.value.length < 2 || oForm.username.value.length> 20){
			alert('用户名长度不得小于2位或者大于20位');
			oForm.username.value = '';//清空value值
			oForm.username.focus();//将焦点移至表单对应字段
			return false;
		}
		if(/[<>\'\"\ ]/.test(oForm.username.value)){
			alert('用户名不得包含非法字符');
			oForm.username.value = '';//清空value值
			oForm.username.focus();//将焦点移至表单对应字段
			return false;
		}
		//密码验证
		if(oForm.password.value.length < 6){
			alert('密码不得小于6位');
			oForm.password.value = '';//清空value值
			oForm.password.focus();//将焦点移至表单对应字段
			return false;
		}
		//验证码验证
		if(oForm.captcha.value.length != 4){
			alert('验证码非4位');
			oForm.captcha.value = '';//清空value值
			oForm.captcha.focus();//将焦点移至表单对应字段
			return false;
		}
		return true;
 	}
 };