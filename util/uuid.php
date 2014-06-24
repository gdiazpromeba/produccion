<?php

      $token = md5(uniqid());

      // better, difficult to guess
      $better_token = md5(uniqid(mt_rand(), true));
	  echo $better_token;

?>