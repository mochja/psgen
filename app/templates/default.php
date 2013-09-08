<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Generátor predných stránok</title>
    <style>
  	body
  	{
  		font-family: 'Lucida Grande';
  	}
  	table, div, p, span
  	{
  		font-size: 12px;
  		margin: 0px;
  		padding: 0px;
  	}
  	#page
  	{
  		width: 800px;
  		margin: auto;	
  	}
  	#content
  	{
  		width: 800px;
  		margin: 10px 0 0 0;
  		border: 1px solid #a1a1a1;
  		background: #b3b3b3;
  	}
  	#content #left-side
  	{
  		float: left;
  		width: 400px;
  		margin: 10px 0px;
  	}
	
  	#content #right-side
  	{
  		float: right;
  		width: 400px;
  		margin: 10px 0px;
  	}
  	#footer
  	{
  		width: 800px;
  		margin: 8px 0 0 0;
  	}
  	a
  	{
  		color: #b3b3b3;
  		text-decoration: none;
  	}
  	a:hover
  	{
  		color: black;
  		text-decoration: underline;
  	}
  	.alert
  	{
  		margin: 3px 10px 3px 2px;
  		background: rgb(255,255,200);
  		border: 1px solid rgb(255,255,0);
  	}
  	.alert p
  	{
  		margin: 7px 5px;
  	}
    </style>
    </head>
    <body>
  		<div id="page">
  			<h1>Generátor predných stránok</h1>
  			<p>pre SPŠE-PO</p>
			
  			<div id="content">
			
  				<div id="left-side">
  					<center><img src="" height="300" id="preview"/></center>
  				</div>
				
  				<div id="right-side">
  					<div class="alert" style="display: none">
  						<p>Something is wrong...</p>
  					</div>
  					<form action="" method="post">
  					<table>
  						<tr> 
  							<td>Názov školy:</td>
  							<td>STREDNÁ PRIEMYSELNÁ ŠKOLA ELEKTROTECHNICKÁ</td>
  						</tr>
  						<tr> 
  							<td>Trieda:</td>
  							<td>
  								<select name="class_1">
                                  	<option value="0">I.</option>
                                  	<option value="1">II.</option>
                                  	<option value="2">III.</option>
                                  	<option value="3">IV.</option>
           						</select>
								<input type="text" name="class_2" value="A" size="2" maxlenght="2">
           						<!-- select name="class_2">
                                  	<option val="1">A</option>
                                  	<option val="2">B</option>
                                  	<option val="3">C</option>
                                  	<option val="4">D</option>
                                  	<option val="4">F</option>
                                  	<option val="4">SA</option>
                                  	<option val="4">SB</option>
           						</select -->
  							</td>
  						</tr>
  						<tr> 
  							<td>Poradové č. študenta:</td>
  							<td>
  								<input type="text" name="student_id" value="00" size="2" maxlength="2" />
  							</td>
  						</tr>
  						<tr> 
  							<td>Školský rok:</td>
  							<td>
  								<input type="text" name="year_1" size="4" maxlength="4" value="2012" /> / <input type="text" name="year_2" size="4" maxlength="4" value="2013" />
  							</td>                   
  						</tr>
  						<tr> 
  							<td>Predmet:</td>
  							<td>
  								<textarea name="subject" rows="3" cols="36">PRED
MET</textarea>
  							</td>                   
  						</tr>
  						<tr> 
  							<td>Meno študenta:</td>
  							<td>
  								<input type="text" name="name" size="50" maxlength="50" value="Ján Mochňak" />
  							</td>                   
  						</tr>
						<tr>
							<td></td>
							<td><input type="submit" value="Stiahni PDF" /></td>
						</tr>
  					</table>  
  					</form>               
  				</div>
				
  				<div style="clear: both;">	</div>
  			</div>
			
  			<div id="footer">
  				<div style="text-align: center; font-size: 9px; color: #a1a1a1">
  					janmochnak &copy; 2013
  				</div>
  			</div>
  		</div>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
	<script type="text/javascript" charset="utf-8">
	$(function() {
		var form = $('form');
		var preview = $('#preview');
		var gen = $('#generate');
		
		var timeout = 0;
		
		var updatePreview = function() {
			$.post('index.php/thumb', form.serialize(), function(data){
				preview.attr('src', 'data:image/png;base64,'+data);
			});
		};
		
		form.submit(function() {
			$.post('index.php/generate', form.serialize(), function(data) {
				document.location = 'index.php/download/'+data;
			});
			return false;
		});
		
		gen.click(function(e){
			e.preventDefault();
			updatePreview();
			return false;
		});	
		
		$('textarea, input, select').keyup(function(){
			if (timeout > 0) {
				clearTimeout(timeout);
			}
			timeout = setTimeout(function (){
				updatePreview();
			}, 2000);
		});
		
		updatePreview();
		
	});
	</script>
</body>
</html>