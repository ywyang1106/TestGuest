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
	opener.document.getElementsByTagName('form')[0].content.value += '[img]'+src+'[/img]';
 }