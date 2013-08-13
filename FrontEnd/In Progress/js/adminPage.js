$(document).ready(function() 
{
	//Handle Menu Clicks to the left of the webpage
	$("#table_left_top td a link").load(function() 
	{

		$("div > left_column").css({"color" : "#551B84"});
				$("div > left_column").css({"font-family" : "Arial, Helvetica, sans-serif"});
				$("div > left_column").css({"text-decoration": "none"});
				$("div > left_column").css({"font-weight" : "bold"});
				$("div > left_column").css({"font-style": "normal"});
				$("div > left_column").css({"position" : "relative"});
				$("div > left_column").css({"vertical-align" : "auto"});
				$("div > left_column").css({"word-spacing" : "inherit"});
				$("div > left_column").css({"font-size" : "18px"});
				$("div > left_column").css({"margin" : "0"});			
				$("div > left_column").css({"padding" : "0"});
				$("div > left_column").css({"border" : "none"});
				$("div > left_column").css({"outline" : "none"});
			
		
    });
	
		$("#table_left_top > td > a ").click(function() 
	{

		$("div > left_column").css({"color" : "#DFAC11"});
				$("div = left_column").css({"font-family" : "Arial, Helvetica, sans-serif"});
				$("div = left_column").css({"text-decoration": "none"});
				$("div = left_column").css({"font-weight" : "bold"});
				$("div = left_column").css({"font-style": "normal"});
				$("div = left_column").css({"position" : "relative"});
				$("div = left_column").css({"vertical-align" : "auto"});
				$("div = left_column").css({"word-spacing" : "inherit"});
				$("div = left_column").css({"font-size" : "18px"});
				$("div = left_column").css({"margin" : "0"});			
				$("div = left_column").css({"padding" : "0"});
				$("div = left_column").css({"border" : "none"});
				$("div = left_column").css({"outline" : "none"});
			
		
    });
	
	$("#table_left_top td a").bind("click",(function() 
	{
            var page = $(this).attr('href');
		    $('a[id = "' + this.id + '"]').css({"color" : "#DFAC11"});
		
    }));
	
	function HandleFileButtonClick()
    {
        document.frmUpload.myFile.click();
        document.frmUpload.txtFakeText.value = document.frmUpload.myFile.value;
    }
});
