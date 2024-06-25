<?php

function getSampleComment($star) {
	$content = '';
	switch ($star) {
		case '1':
			$content = 'Shop rất buồn khi nhận lượt đánh giá này. Hi vọng mọi khó khăn khi sử dụng sản phẩm được bạn nêu rõ với shop tại email: zvhshop@gmail.com';
			break;
		case '2':
			$content = 'Shop rất buồn khi nhận lượt đánh giá này. Hi vọng mọi khó khăn khi sử dụng sản phẩm được bạn nêu rõ với shop tại email: zvhshop@gmail.com';
			break;
		case '3':
			$content = 'Shop rất buồn khi nhận lượt đánh giá này. Hi vọng mọi khó khăn khi sử dụng sản phẩm được bạn nêu rõ với shop tại email: zvhshop@gmail.com';
			break;
		case '4':
			$content = 'Cảm ơn bạn đã ủng hộ shop nha, Shop hơi buồn xíu khi không nhận được sự đánh giá 5* từ bạn nhưng đó cũng là lý do để shop tiếp tục hoàn thiện chất lượng và dịch vụ hơn nữa.';
			break;
		case '5':
			$content = 'Cảm ơn bạn đã ủng hộ shop nha, shop rất vui khi nhận được 5* từ bạn. Hi vọng bạn sẽ luôn ủng hộ shop và nếu có khó khăn trong quá trình nhận hàng và sử dụng hãy nhắn tin hoặc gọi vào hotline bên mình nhé.';
			break;
		
		default:
			$content = 'Không đúng!!!!';
			break;
	}
	return $content;

}