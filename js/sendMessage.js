window.onload = function(){
	captcha();
	var oForm = document.getElementsByTagName('form')[0];
	oForm.onsubmit = function(){
		//验证码验证
		if(oForm.captcha.value.length != 4){
			alert('验证码必须是4位');
			oForm.captcha.focus(); //将焦点以至表单字段
			return false;
		}
		if(oForm.content.value.length < 10 || oForm.content.value.length > 200) {
			alert('信息内容不得小于10位，大于200位');
			oForm.content.focus(); //将焦点以至表单字段
			return false;
		}
	};
}