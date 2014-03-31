<?php

class Validator{

  public function validateCPF($cpf)
   {
    try
     {
      $invalid = array(
        '11111111111',
        '22222222222',
        '33333333333',
        '44444444444',
        '55555555555',
        '66666666666',
        '77777777777',
        '88888888888',
        '99999999999',
        '00000000000',
        '12345678909');

      $cpf = ereg_replace('[^0-9]', '', $cpf);

       if(in_array($cpf, $invalid))
         throw new Exception('Wrong CPF!');
       //1st Verifying Digit validation
      $vd1=0;
       for($i=0; $i < 9; $i++){
         $vd1 += ($cpf[$i]*(10 - $i));
        }
      $r1 = ($vd1 % 11);
      $vd1 = (($r1 > 1) ? (11 - $r1) : 0);
       if($vd1 != $cpf[9])
         throw new Exception('Wrong CPF!');

      //2nd Verifying Digit validation
      $vd2=0;
       for ($i=0; $i < 10; $i++)
        {
         $vd2 += ($cpf[$i]*(11 - $i));
        }
      $r2= ($vd2 % 11);
      $vd2 = (($r2 > 1) ? (11 - $r2) : 0);
       if( $vd2 != $cpf[10])
         throw new Exception('Wrong CPF!');
       }catch(Exception $e){
          echo $e->getMessage();
        }
  }
   
  public function validateCNPJ($cnpj)
  {
    try{
      $cnpj = preg_replace('/[^0-9]/', '', (string) $cnpj);

      if (strlen($cnpj) != 14)
        throw new Exception('Wrong CNPJ!');
     
      //1st Verifying Digit validation
      $vd1=0;
      for ($i = 0, $j = 5; $i < 12; $i++)
      {
        $vd1 += $cnpj[$i]*$j;
        $j = ($j == 2) ? 9 : ($j - 1);
      }
      $r1 = $vd1%11;
      $vd1 = $r1 > 1 ? (11 - $r1) : 0;
     
      if ($vd1 != $cnpj[12])
        throw new Exception ('Wrong CNPJ!');
     
      //2nd Verifying Digit validation
      $vd2=0;
      for ($i = 0, $j = 6, $soma = 0; $i < 13; $i++)
      {
        $vd2 += $cnpj[$i]*$j;
        $j = ($j == 2) ? 9 : ($j - 1);
      }
      $r2 = $vd2%11;
      $vd2 = $r2 > 1 ? (11 - $r2) : 0;
      if ($vd2 != $cnpj[13])
        throw new Exception ('Wrong CNPJ!');
      
    }catch(Exception $e){
      echo $e->getMessage();
    }
  }
  //Yii::import('application.util.Validator');
}

?>