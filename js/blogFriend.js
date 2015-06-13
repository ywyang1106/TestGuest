window.onload = function(){
	//向博友发送信息
	var sendMessage = document.getElementsByName('sendMessage');
	for(var i = 0; i < sendMessage.length; i++){
		sendMessage[i].onclick = function(){
			funcNewCenterWindow('sendMessage.php?id='+this.title, 'sendMessage', 250, 400);
		};
	}
	//加为好友addFriend
	var addFriend = document.getElementsByName('addFriend');
	for(var i = 0; i < addFriend.length; i++){
		addFriend[i].onclick = function(){
			funcNewCenterWindow('addFriend.php?id='+this.title, 'addFriend', 250, 400);
		};
	}
	//写留言leaveMessage
	var leaveMessage = document.getElementsByName('leaveMessage');
	for(var i = 0; i < leaveMessage.length; i++){
		leaveMessage[i].onclick = function(){
			funcNewCenterWindow('leaveMessage.php?id='+this.title, 'leaveMessage', 250, 400);
		};
	}
	//送花sendFlower
	var sendFlower = document.getElementsByName('sendFlower');
	for(var i = 0; i < sendFlower.length; i++){
		sendFlower[i].onclick = function(){
			funcNewCenterWindow('sendFlower.php?id='+this.title, 'sendFlower', 250, 400);
		};
	}
};
function funcNewCenterWindow(sUrl, sName, iHeight, iWidth){
	var iLeft = (screen.width - iWidth) / 2;
	var iTop = (screen.height - iHeight) / 2;
	window.open(sUrl, sName, 'height='+iHeight+', width='+iWidth+', top='+iTop+' left='+iLeft+'');
}