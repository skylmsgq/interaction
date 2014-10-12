var zan = false;
var count = 0;
$(document).ready(function(){
	$('#info img').click(function(){
		zan = !zan;
		if(zan){
			$('#info img').attr('src','img/zaned.png');
			$.ajax({
				url: 'data.php',
				type: 'POST',
				data: {method: 'add', openid: $('#openid').text()},
				dataType: 'json',
				error: function(){
					alert('something is wrong');
				},
				success: function(data){
					count = $('#zan').text();
					$('#zan').text(parseInt(count)+1);
				}
			});
		}
		else{
			$('#info img').attr('src','img/zan.png');
			$.ajax({
				url: 'data.php',
				type: 'POST',
				data: {method: 'delete', openid: $('#openid').text()},
				dataType: 'json',
				error: function(){
					alert('something is wrong');
				},
				success: function(){
					count = $('#zan').text();
					$('#zan').text(parseInt(count)-1);
				}
			});
		}
	});
});