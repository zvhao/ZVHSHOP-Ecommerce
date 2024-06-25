<?php

class Comment extends Controller
{
	private $products;
	private $comment;

	function __construct()
	{
		$this->comment = $this->model('CommentModel');
		$this->products = $this->model('ProductModel');
	}

	public function add_comment()
	{

		// show_array($_POST);
		if (isset($_POST['btn_submit']) && $_SESSION['user']) {
			$id_user = $_POST['id_user'];
			$id_pro = $_POST['id_pro'];
			$comment = $_POST['comment'];
			$rating = $_POST['stars'];
			$created_at = date("Y-m-d H:i:s");
			// show_array($_POST);

			$idComment = $this->comment->insertComment($id_user, $id_pro, $comment, $rating, $created_at);

			// $arrTotalRating = $this->comment->avgTotalRating();
			// foreach($arrTotalRating as $item) {
			// 	$this->products->updateRating($item['id_pro'], round($item['total_rating'], 1));
			// }
			$countComment = $this->comment->countComment($id_pro);


			$avgRating = $this->comment->avgTotalRatingOne($id_pro);
			// show_array($avgRating);

			$avgRound = round($avgRating, 1);

			$this->products->updateRating($id_pro, round($avgRating, 1));
			$comments = $this->comment->getAllComment($id_pro);
			$data = array(
				'avgRound' => $avgRound,
				'countComment' => $countComment
			);
			print_r(json_encode($data));
			// redirectTo("detailproduct/product/$id_pro");
		}
	}

	public function reply_comment()
	{
		if (isset($_POST['btn_reply_cmt'])) {
			$id_cmt = $_POST['id_cmt'];
			$reply_comment = $_POST['reply_comment'];

			if ($this->comment->updateRespondedComment($id_cmt, $reply_comment)) {
				$this->comment->updateRespondedComment($id_cmt, $reply_comment);
				$data = array(
					'id_cmt' => $id_cmt,
					'reply_comment' => $reply_comment,
					'responded' => 'Đã phản hồi'
				);
				print_r(json_encode($data));
			}
		}
	}
}
