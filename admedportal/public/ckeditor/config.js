CKEDITOR.editorConfig = function( config ) {
	config.height = 300;
	config.language = 'zh';
	config.toolbar = [
		{name:'styles', items: [ 'Format' ] },
		{name:'basicstyles', items: [ 'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat' ] },
		{name:'paragraph', items: [ 'NumberedList', 'BulletedList' ] },
		{name:'links', items: [ 'Link', 'Unlink' ] },
		{name:'colors', items: [ 'TextColor', 'BGColor' ] },
		{name:'insert', items: [ 'Image', 'Table' ] },
		{name:'tools', items: [ 'Maximize', 'ShowBlocks' ] },
		{name:'document', items: [ 'Source' ] }
	];
	//
	config.removeDialogTabs = 'link:advanced;image:advanced;table:advanced';
	config.startupOutlineBlocks = true;
};

CKEDITOR.stylesSet.add( 'default', [
	//物件樣式 Object Styles
	{name:'表格', element:'table', attributes:{'class':'CKCSS_table','cellpadding':'0','cellspacing':'0','border':'0','width':'100%'}},
	{name:'影像(靠左)', element:'img', attributes:{'class':'CKCSS_left'}},
	{name:'影像(寬度100%)', element:'img', attributes:{'width':'100%'}},
	
	//區塊樣式 Block Styles
    {name:'主標題',element:'div', attributes:{'class':'CKCSS_title'}},
	{name:'副標題',element:'div', attributes:{'class':'CKCSS_sub_title'}},

    //行內樣式 Inline Styles
    {name:'Marker: Green', element:'span', styles:{'background-color':'Lime'}},
	{name:'CSS Style1', element:'span', attributes:{'class':'my_style1'}}    
] );

CKEDITOR.on('dialogDefinition', function( ev ) {
  var dialogName = ev.data.name;
  var dialogDefinition = ev.data.definition;

  if(dialogName === 'table') {
    var infoTab = dialogDefinition.getContents('info');
	
    var txtWidth = infoTab.get('txtWidth');
    txtWidth['default'] = "100%";
	
	var txtCellSpace = infoTab.get('txtCellSpace');
    txtCellSpace['default'] = "1";
    
	var txtCellPad = infoTab.get('txtCellPad');
    txtCellPad['default'] = "0";
    
	var txtBorder = infoTab.get('txtBorder');
    txtBorder['default'] = "0";
  }
});