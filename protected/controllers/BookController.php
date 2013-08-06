<?php
class BookController extends Controller
{
	public function actionIndex()
	{
	       $d = new Book;
           $d->save(false);
			$arraymassive = array(2,3);
		$a = Book::model()->findAllByPk($arraymassive);
		foreach ($a as $one) {
			
			echo $one->title."<br>-";
		}
	
	}	

	
}


?>

