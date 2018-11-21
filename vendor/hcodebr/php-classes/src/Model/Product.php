<?php 

namespace Hcode\Model;
use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Mailer;
class Product extends Model{

	
	//Método para listar os produtos pelo desproduct
	public static function listAll()
	{

			$sql = new Sql();
			return $sql->select("SELECT * FROM tb_products ORDER BY desproduct");
	}



	public static function checkList($list)
	{


		foreach ($list as &$row) {
			$p = new Product();

			$p->setData($row);

			$row = $p->getValues();


		}

		return $list;


	}


	//Método para criar produtos
	public function save()
	{
		

		$sql = new Sql();

		$results = $sql->select("CALL sp_products_save(:idproduct, :desproduct, :vlprice, :vlwidth, :vlheight, :vllength, :vlweight, :desurl)",
			 array(
			":idproduct"=>$this->getidproduct(),
			":desproduct"=>$this->getdesproduct(),
			":vlprice"=>$this->getvlprice(),
			":vlwidth"=>$this->getvlwidth(),
			":vlheight"=>$this->getvlheight(),
			":vllength"=>$this->getvllength	(),
			":vlweight"=>$this->getvlweight(),
			":desurl"=>$this->getdesurl()
		));

		$this->setData($results[0]);

		

	}


	//Método para pegar os produtos da DB
	public function get($idproduct)
	{


		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_products WHERE idproduct = :idproduct", [

			':idproduct'=>$idproduct
		] );

		$this->setData($results[0]);
	}


	//Método para deletar produtos da tabela tb_products pelo idproduct
	public function delete()
	{
		$sql = new Sql();

		$sql->query("DELETE FROM tb_products WHERE idproduct = :idproduct", [':idproduct'=>$this->getidproduct()
		]);
		

	}


	//Método para checkar se existe foto para o produto
	public function checkPhoto()

	{

		if (file_exists($_SERVER["DOCUMENT_ROOT"]. DIRECTORY_SEPARATOR . "res" . DIRECTORY_SEPARATOR . "site" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . $this->getidproduct() . ".jpg"))

		{


			$url =  "/res/site/img/products/" . $this->getidproduct() . ".jpg";


		}else{

			$url =  "/res/site/img/product.jpg";



		}

		return $this->setdesphoto($url);

	}
		


	public function getValues()

	{
		$this->checkPhoto();

		$values = parent::getValues();

		return $values;
	}


	//Méetodo para setar o tipo de imagem enviada
	public function setPhoto($file)
	{

		$extension = explode('.', $file["name"]);
		$extension = end($extension);

		switch ($extension) {
			case 'jpeg':
			case 'jpg':
			$image = imagecreatefromjpeg($file["tmp_name"]);
				break;
			
			case 'gif':
	       $image = imagecreatefromgif($file["tmp_name"]);
	       	break;

			case 'png':
			$image = imagecreatefrompng($file["tmp_name"]);
			break;
		}

		$dist = $_SERVER["DOCUMENT_ROOT"]. DIRECTORY_SEPARATOR . "res" . DIRECTORY_SEPARATOR . "site" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . $this->getidproduct() . ".jpg";

		imagejpeg($image, $dist);

		imagedestroy($image);

		$this->checkPhoto();

	}
	

}

 ?>