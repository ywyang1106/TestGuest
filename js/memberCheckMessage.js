window.onload = function(){
	var oSelectAll = document.getElementById('selectAll');
	var oForm = document.getElementsByTagName('form')[0];
	oSelectAll.onclick = function(){
		//form.elements获取表单内的所有表单，目前一共16个
		//checked表示已选
		for(var i=0; i<oForm.elements.length; i++){
			if(oForm.elements[i].name != 'selectAll'){
				oForm.elements[i].checked = oForm.selectAll.checked;
			}
		}
	};
	oForm.onsubmit = function(){
		if(confirm('确定要删除这批数据？')){
			return true;
		} 
		return false;
	};
}