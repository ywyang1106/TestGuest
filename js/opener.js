window.onload = function(){
 	var iAvatar = document.getElementsByTagName('img');
 	for(i=0; i<iAvatar.length; i++){
 		iAvatar[i].onclick = function(){
 			funcOpener(this.alt);
 		};
 	}
 };
 // 
 function funcOpener(src){
 	//operner表示父窗口，.document表示其文档
	opener.document.getElementById('avatarImage').src = src;
 	opener.document.register.avatar.value = src;
 }