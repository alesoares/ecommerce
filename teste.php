	public static function validForgotDecrypt($result)
	{
		$result = base64_decode($result);
	    $code = mb_substr($result, openssl_cipher_iv_length('aes-256-cbc'), null, '8bit');
	    $iv = mb_substr($result, 0, openssl_cipher_iv_length('aes-256-cbc'), '8bit');;
	    $idrecovery = openssl_decrypt($code, 'aes-256-cbc', User::SECRET, 0, $iv);
	    $sql = new Sql();
	    $results = $sql->select("
	        SELECT *
	        FROM tb_userspasswordsrecoveries a
	        INNER JOIN tb_users b USING(iduser)
	        INNER JOIN tb_persons c USING(idperson)
	        WHERE
	        a.idrecovery = :idrecovery
	        AND
	        a.dtrecovery IS NULL
	        AND
	        DATE_ADD(a.dtregister, INTERVAL 1 HOUR) >= NOW();
	    ", array(
	        ":idrecovery"=>$idrecovery
	    ));
	    
	    if (count($results) === 0)
	    {
	        throw new \Exception("Não foi possível recuperar a senha.");
	    }
	    else
	    {
	        return $results[0];
	    }
	}

		public static function validForgotDecrypt($result)
	{
		$encryption_key =  base64_decode(User::SECRET);
		list($result, $iv) = explode('::', base64_decode($result), 2);
		$idrecovery = openssl_decrypt($result, 'aes-256-cbc', $encryption_key, 0, $iv);

		$sql = new Sql();
	    $results = $sql->select("
	        SELECT *
	        FROM tb_userspasswordsrecoveries a
	        INNER JOIN tb_users b USING(iduser)
	        INNER JOIN tb_persons c USING(idperson)
	        WHERE
	        a.idrecovery = :idrecovery
	        AND
	        a.dtrecovery IS NULL
	        AND
	        DATE_ADD(a.dtregister, INTERVAL 1 HOUR) >= NOW();
	    ", array(
	        ":idrecovery"=>$idrecovery
	    ));
	    
	    if (count($results) === 0)
	    {
	        throw new \Exception("Não foi possível recuperar a senha.");
	    }
	    else
	    {
	        return $results[0];
	    }
	}