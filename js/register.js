window.onload = function(){
 	//点击头像部分的效果及功能
 	var avatarImage = document.getElementById('avatarImage');
 	if(avatarImage != null){
	 	avatarImage.onclick = function(){
	 		window.open('avatar.php','avatar','width=400,height=400,top=0,left=0,scrollbars=1');
	 	};
 	}
 	//验证码点击效果
 	captcha();
 	//表单验证
 	var oForm = document.getElementsByTagName('form')[0];
 	if(form == undefined) return;
 	oForm.onsubmit = function(){
		//能用客户端验证的，尽量用客户端
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
		if(oForm.password.value != oForm.confirm.value){
			alert('密码和确认密码不一致');
			oForm.confirm.value = '';//清空value值
			oForm.confirm.focus();//将焦点移至表单对应字段
			return false;
		}
		//密码提示和回答验证
		if(oForm.question.value.length < 2 || oForm.question.value.length> 20){
			alert('密码提示长度不得小于2位或者大于20位');
			oForm.username.value = '';//清空value值
			oForm.username.focus();//将焦点移至表单对应字段
			return false;
		}
		if(oForm.answer.value.length < 2 || oForm.answer.value.length> 20){
			alert('密码回答长度不得小于2位或者大于20位');
			oForm.answer.value = '';//清空value值
			oForm.answer.focus();//将焦点移至表单对应字段
			return false;
		}
		if(oForm.question.value == oForm.answer.value){
			alert('密码提示和密码回答不得相同');
			oForm.answer.value = '';//清空value值
			oForm.answer.focus();//将焦点移至表单对应字段
			return false;
		}
		//邮箱验证
		if(!(/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(oForm.email.value))){
			alert('邮件格式不正确');
			oForm.email.value = '';//清空value值
			oForm.email.focus();//将焦点移至表单对应字段
			return false;
		}
		//QQ验证
		if(oForm.qq.value != ''){
			if(!(/^[1-9]{1}[0-9]{4,9}$/.test(oForm.qq.value))){
				alert('QQ号码不正确');
				oForm.qq.value = '';//清空value值
				oForm.qq.focus();//将焦点移至表单对应字段
				return false;
			}
		}
		//网址验证
		if(oForm.url.value != '' && oForm.url.value != "http://"){
			if(!(/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(oForm.url.value))){
				alert('网址不正确js');
				oForm.url.value = '';//清空value值
				oForm.url.focus();//将焦点移至表单对应字段
				return false;
			}
			if(oForm.url.value.length < 6 || oForm.url.value.length> 40){
				alert('网址长度不合法');
				oForm.url.value = '';//清空value值
				oForm.url.focus();//将焦点移至表单对应字段
				return false;
			}
		}
		//验证码验证
		if(oForm.captcha.value.length != 4){
			alert('验证码非4位');
			oForm.captcha.value = '';//清空value值
			oForm.captcha.focus();//将焦点移至表单对应字段
			return false;
		}
		return true;
	};
};