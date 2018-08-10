$(document).ready(function(){

	var editor_config = {
		path_absolute: url,// { asset('/')}} in php script
		selector: 'textarea',
		language: 'ser',
		branding: false,
		plugins:[
			"advlist autolink lists link charmap print preview hr anchor pagebreak",
			"searchreplace wordcount visualblocks visualchars code fullscreen help hr",
			"insertdatetime media nonbreaking save table contextmenu directionality",
			"emoticons template paste textcolor colorpicker textpattern autoresize autosave",
			"charmap contextmenu directionality imagetools noneditable tabfocus"
		],
		toolbar: "insertfile | undo redo save | styleselect fontselect | fontsizeselect  bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image media ",
		fontsize_formats: '5pt 6pt 7pt 8pt 9pt 10pt 11pt 12pt 13pt 14pt 15pt 16pt 17pt 18pt 19pt 20pt 22pt 24pt 26pt 28pt 30pt 32pt 34pt 36pt 38pt 40pt',
		font_formats: 'Andale Mono=andale mono,times;Arial=arial,helvetica,sans-serif;Arial Black=arial black,avant garde;Book Antiqua=book antiqua,palatino;Comic Sans MS=comic sans ms,sans-serif;Courier New=courier new,courier;Georgia=georgia,palatino;Helvetica=helvetica;Impact=impact,chicago;Symbol=symbol;Tahoma=tahoma,arial,helvetica,sans-serif;Terminal=terminal,monaco;Times New Roman=times new roman,times;Trebuchet MS=trebuchet ms,geneva;Verdana=verdana,geneva;Webdings=webdings;Wingdings=wingdings,zapf dingbats',

		relative_urls: false,
		file_browser_callback :  function(field_name, url, type, win){
			var x = window.innerWidth || document.documentElement.clientWidth || document.getElementsByTagName('body')[0].clientWidth;
			var y = window.innerHeight || document.documentElement.clientHeight || document.getElementsByTagName('body')[0].clientHeight;
			var cmsURL = editor_config.path_absolute + 'laravel-filemanager?field_name=' + field_name;

			if(type == 'image'){
				cmsURL = cmsURL + "&type=Images";
			}else{
				cmsURL = cmsURL + "&type=Files";
			}

			tinyMCE.activeEditor.windowManager.open({
				file: cmsURL,
				title: 'Filemanager',
				width: x * 0.8,
				height: y * 0.8,
				resizable: 'yes',
				close_previous: 'no'
			});
		}
	}

	tinymce.init(editor_config);
	
});