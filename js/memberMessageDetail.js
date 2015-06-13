window.onload = function(){
	var oReturnList = document.getElementById('returnList');
	var oDeleteMessage = document.getElementById('deleteMessage');
	oReturnList.onclick = function(){
		history.back();
	};
	oDeleteMessage.onclick = function(){
		if(window.confirm('确定删除短信？')){
				location.href='?action=delete&id='+this.name;
		}	
	};
}