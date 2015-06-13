window.onload = function(){
 	//验证码点击效果
 	captcha();
 	var ubb = document.getElementById('ubb');
	var ubbimg = ubb.getElementsByTagName('img');
	var oForm = document.getElementsByTagName('form')[0];
	var font = document.getElementById('font');
	var color = document.getElementById('color');
	var html = document.getElementsByTagName('html')[0];
	var q = document.getElementById('q');
	var qa = q.getElementsByTagName('a');
	
	oForm.onsubmit = function(){
		//能用客户端验证的，尽量用客户端
		//用户名验证
		if(oForm.title.value.length < 2 || oForm.title.value.length> 40){
			alert('标题长度不得小于2位或者大于40位');
			oForm.title.value = '';//清空value值
			oForm.title.focus();//将焦点移至表单对应字段
			return false;
		}
		if(/[<>\'\"\ ]/.test(oForm.title.value)){
			alert('标题不得包含非法字符');
			oForm.title.value = '';//清空value值
			oForm.title.focus();//将焦点移至表单对应字段
			return false;
		}
		//content验证
		if(oForm.content.value.length < 10){
			alert('内容长度不得小于10位');
			oForm.content.value = '';//清空value值
			oForm.content.focus();//将焦点移至表单对应字段
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
	
	qa[0].onclick = function(){
		window.open('q.php?num=48&path=qpic/1/','q','width=400,height=400,scrollbars=1');
	};
	qa[1].onclick = function(){
		window.open('q.php?num=10&path=qpic/2/','q','width=400,height=400,scrollbars=1');
	};
	qa[2].onclick = function(){
		window.open('q.php?num=39&path=qpic/3/','q','width=400,height=400,scrollbars=1');
	};
	html.onmouseup = function(){
		font.style.display = 'none';
		color.style.display = 'none';
	};
	ubbimg[0].onclick = function(){
		font.style.display = 'block';
	};
	ubbimg[2].onclick = function(){
		content('[b][/b]');
	};
	ubbimg[3].onclick = function(){
		content('[i][/i]');
	};
	ubbimg[4].onclick = function(){
		content('[u][/u]');
	};
	ubbimg[5].onclick = function(){
		content('[s][/s]');
	};
	ubbimg[7].onclick = function(){
		color.style.display = 'block';
		oForm.t.focus();
	};
	ubbimg[8].onclick = function(){
		var url = prompt('请输入网址：','http://');
		if(url){
			if(/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(url)){
				content('[url]'+url+'[/url]');
			} 
			else{
				alert('网址不合法！');
			}
		}
	};
	ubbimg[9].onclick = function(){
		var email = prompt('请输入电子邮件：','@');
		if(email){
			if(/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/.test(email)){
				content('[email]'+email+'[/email]');
			} 
			else{
				alert('电子邮件不合法！');
			}
		}
	};
	ubbimg[10].onclick = function(){
		var img = prompt('请输入图片地址：','');
		content('[img]'+img+'[/img]');
	};
	ubbimg[11].onclick = function(){
		var flash = prompt('请输入视频flash：','http://');
		if(flash){
			if(/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/.test(flash)){
				content('[flash]'+flash+'[/flash]');
			} 
			else{
				alert('视频不合法！');
			}
		}
	};
	ubbimg[18].onclick = function(){
		oForm.content.rows += 2;
	};
	ubbimg[19].onclick = function(){
		oForm.content.rows -= 2;
	};
	function content(string){
		oForm.content.value += string; 
	}
	oForm.t.onclick = function(){
		showcolor(this.value);
	}
 };
function font(size){
	document.getElementsByTagName('form')[0].content.value += '[size='+size+'][/size]'; 
}
function showcolor(value){
	document.getElementsByTagName('form')[0].content.value += '[color='+value+'][/color]';
};