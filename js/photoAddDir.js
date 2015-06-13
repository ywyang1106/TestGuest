window.onload = function(){
	var oForm = document.getElementsByTagName('form')[0];
	var password = document.getElementById('password');
	oForm[1].onclick = function(){
		password.style.display = 'none';
	};
	oForm[2].onclick = function(){
		password.style.display = 'block';
	};
	
	oForm.onsubmit = function(){
		//用户名验证
		if(oForm.name.value.length < 2 || oForm.name.value.length> 20){
			alert('相册名长度不得小于2位或者大于20位');
			oForm.name.value = '';//清空value值
			oForm.name.focus();//将焦点移至表单对应字段
			return false;
		}
		if(oForm[2].checked == true){
			//密码验证
			if(oForm.password.value.length < 6){
				alert('密码不得小于6位');
				oForm.password.value = '';//清空value值
				oForm.password.focus();//将焦点移至表单对应字段
				return false;
			}
		}
		return true;	
	};
};