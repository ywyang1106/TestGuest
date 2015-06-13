function captcha(){
	var captcha = document.getElementById('captcha');
	if(captcha == null){
		return;
	}	
	captcha.onclick = function(){
 		this.src = 'captcha.php?tm='+Math.random();
 	};
}