window.onload = function(){
	captcha();//引入验证码函数
	//表单验证
 	var oForm = document.getElementsByTagName('form')[0];
 	oForm.onsubmit = function(){
 		//密码验证
 		if(oForm.password.value != ''){
 			if(oForm.password.value.length < 6){
			alert('密码不得小于6位');
			oForm.password.value = '';//清空value值
			oForm.password.focus();//将焦点移至表单对应字段
			return false;
			}
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