var count = '';
var red = 0,
    green = 0,
    blue = 0;

$(document).ready(function(){
	$('.you').click(function(){
		setInterval(function(){
			$.ajax({
				url: 'light.php',
				type: 'POST',
				data: {},
				dataType: 'json',
				error: function() {
            	},
				success: function(data){
					count = data['count']*10;
					red = Math.round(17 + count * 1.95);
					green = Math.round(75 - count * 0.25);
					blue = Math.round(176 - count * 1.4);
					//alert('rgba('+red.toString()+','+green.toString()+','+blue.toString()+',0.9)');
					$('.progress').css('height', count+'%').text(count).css('background-color','rgba('+red.toString()+','+green.toString()+','+blue.toString()+',0.9)');
				}
			});
		},300);
	});
});