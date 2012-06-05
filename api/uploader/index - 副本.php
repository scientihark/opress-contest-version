<html>
<head>
    <title>Upload Control</title>
    <link rel="stylesheet" type="text/css" href="codebase/dhtmlxvault.css" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <script language="JavaScript" type="text/javascript" src="codebase/dhtmlxvault.js"></script>

    <script language="JavaScript" type="text/javascript">
        var vault = null;
		$pid=1;
		
        function doOnLoad() {
            vault = new dhtmlXVaultObject();
            vault.setImagePath("codebase/imgs/");
            vault.setServerHandlers("UploadHandler.php", "GetInfoHandler.php", "GetIdHandler.php");
	    	vault.isDemo = true;
			vault.setFilesLimit(1);
			vault.onAddFile = function(fileName) { 
			var ext = this.getFileExtension(fileName); 
			if (ext != "pdf" ) 
			{ 
				alert("亲，目前只允许上传(pdf)~~"); 
				return false; 
			} 
			else 
			{
				return true;
			}
			};
			vault.onFileUploaded = function(file) { 
			
			};
			vault.strings = { 
			remove: "删除", done: "完成", error: "错误", btnAdd: "添加文件", btnUpload: "上传", btnClean: "清空" 
			};
			vault.strings.errors = { 
			"TooBig": "文件太大了亲， (它有{0} bytes).\n目前最大允许上传 {1} 哦.", 
			"PostSize": "亲~你有麻烦咯~ :\n"+ "- 如果你是第一次看到这个，请确保文件名不包含中文、空格和符号;\n"+ "- 如果反复出现这个错误，请联系管理员亲." 
			};
            vault.create("vault1");
			vault.setFormField("pid", $pid);
			vault.setFormField("type", "1");
			//vault.setFormField("upass", "1");
	}
    </script>

    <style>
	body {font-size:12px}
	.{font-family:arial;font-size:12px}
	h1 {cursor:hand;font-size:16px;margin-left:10px;line-height:10px}
	xmp {color:green;font-size:12px;margin:0px;font-family:courier;background-color:#e6e6fa;padding:2px}
	.hdr{
		background-color:lightgrey;
		margin-bottom:10px;
		padding-left:10px;
	}
    </style>

</head>
<body onLoad="doOnLoad()">
    

    <div id="vault1">
    </div>




</body>
</html>

