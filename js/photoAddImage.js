window.onload = function(){
	var upload = document.getElementById('upload');
	upload.onclick = function(){
		funcNewCenterWindow('uploadImg.php?dir='+this.title, 'upload', '300', '400');
	};
	var oForm = document.getElementsByTagName('form')[0];
	oForm.onsubmit = function (){
		if(oForm.name.value.length < 2 || oForm.name.value.length > 20){
			alert('图片名不得小于2位或者大于20位');
			oForm.name.focus(); //将焦点以至表单字段
			return false;
		}
		if(oForm.url.value == ''){
			alert('地址不得为空！');
			oForm.url.focus(); //将焦点以至表单字段
			return false;
		}
		return true;
	};
};
function funcNewCenterWindow(sUrl, sName, iHeight, iWidth){
	var iLeft = (screen.width - iWidth) / 2;
	var iTop = (screen.height - iHeight) / 2;
	window.open(sUrl, sName, 'height='+iHeight+', width='+iWidth+', top='+iTop+' left='+iLeft+'');
}