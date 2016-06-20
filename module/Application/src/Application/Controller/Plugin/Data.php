<?php

namespace Application\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class Data extends AbstractPlugin {

    public function dateToUser($dateTime, $useHora = TRUE) { //Mostra a data do Banco para o Usuário
        $data = substr(str_replace("-", "", $dateTime), 0);

        $ano = substr($data, 0, 4);
        $mes = substr($data, 4, 2);
        $dia = substr($data, 6, 2);

        $hora = substr($data, -8);
        if ($useHora) {
            return $dia . "/" . $mes . "/" . $ano . " " . $hora;
        } else {
            return $dia . "/" . $mes . "/" . $ano;
        }
    }//dateToUser

    public function dateToDB($dateTime, $useHora = TRUE) {//Converte a data do Usuário para o Banco
        $data = substr(str_replace("/", "", $dateTime), 0);

        $ano = substr($data, 4, 4);
        $mes = substr($data, 2, 2);
        $dia = substr($data, 0, 2);

        $hora = substr($data, -8);

        if ($useHora) {
            return $ano . "-" . $mes . "-" . $dia . " " . $hora;
        } else {
            return $ano . "-" . $mes . "-" . $dia;
        }
    }//dateToDB
    
    /*
     * Função que retorna a difereça entre duas datas
     * O retorno do tipo do intervalo pode ser em ano('y'), mes('m'), dia('d'), hora('h'), minuto('i'), segundo('s');   
     * Recebe as datas no formato YYYY-MM-DD
     * Retorna como padrão em segundos.
     * data2 > data1
     */
    public function dateDifference($data1, $data2, $tp_intervalo) {
        switch ($tp_intervalo) {
            case 'y':
                $Q = 86400*365;
                break; //ano
            case 'm':
                $Q = 2592000;
                break; //mes
            case 'd':
                $Q = 86400;
                break; //dia
            case 'h':
                $Q = 3600;
                break; //hora
            case 'i':
                $Q = 60;
                break; //minuto
            default:
                $Q = 1;
                break; //segundo
        }//switch 
        return round((strtotime($data2) - strtotime($data1)) / $Q);
    }//Diferença entre as datas
    
    /*
     * Função que retorna um array com intervalo de datas de um determinado período
     * Recebe as datas no formato YYYY-MM-DD
     * Retorna um array com as datas do intervalo.
     */
    function intervaloDatas($dataIni, $dataFim)
    {   
        $arrData = array();

        $intervaloDataIni = mktime(1,0,0,substr($dataIni,5,2), substr($dataIni,8,2), substr($dataIni,0,4));
        $intervaloDataFim = mktime(1,0,0,substr($dataFim,5,2), substr($dataFim,8,2), substr($dataFim,0,4));

        if ($intervaloDataFim >= $intervaloDataIni)
        {
            array_push($arrData,date('Y-m-d',$intervaloDataIni));
            while ($intervaloDataIni < $intervaloDataFim)
            {
                $intervaloDataIni+=86400; // add 24 hours
                array_push($arrData,date('Y-m-d',$intervaloDataIni));
            }
        }
        return $arrData;
    }//Intervalo de Datas

    /*
     * Função que retorna o dia da semana abreviado
     * Recebe a data no formato YYYY-MM-DD
     * Retorna um dos possíveis valores: dom | seg | ter | qua | qui | sex | sab
     */
    public function retornaDiaSemana($data){       
        $verif = strftime("%w", strtotime($data)); 
        
        $arrSemana = array(
            0 => 'dom',
            1 => 'seg',
            2 => 'ter',
            3 => 'qua',
            4 => 'qui',
            5 => 'sex',
            6 => 'sab'           
        );
        
        return $arrSemana[$verif];
    }//Retorna dia da semana
    
    public function dateToDateTime($data){
        
        return \DateTime::createFromFormat('d/m/Y', $data);
        
    }
    
    /**
     * getAge: Função que recupera a idade entre datas.
     * @author Evandro Oliveira
     * 
     * @version 0.1
     * 
     * @param $bornParam int timestamp: Data de nascimento.
     * 
     * @param $compareParam int timestamp: Data de comparação.
     * 		Se não for fornecida, a data assumida é o dia de hoje.
     * 
     * @return int A idade comparada.
     */
    public function getAge($bornParam, $compareParam = null) {
        $born = explode('-', date('d-m-Y', $bornParam));
        $compare = explode('-', date('d-m-Y', empty($compareParam) ? time() : $compareParam));
        $age = $compare[2] - $born[2];
        if ($compare[1] > $born[1]) {
            return $age;
        }
        if ($compare[1] == $born[1] && $compare[0] > $born[0]) {
            return $age;
        }
        return --$age;
    }
    
    /**
     * 
     * @param type $dat
     * @return boolean
     */
    public function validarData($dat){
	$data = explode("/","$dat"); // fatia a string $dat em pedados, usando / como referência
	$d = $data[0];
	$m = $data[1];
	$y = $data[2];
 
	// verifica se a data é válida!
	// 1 = true (válida)
	// 0 = false (inválida)
	$res = checkdate($m,$d,$y);
	if ($res == 1){
            $stData = true;
	} else {
            $stData = false;
	}
        return $stData;
    }

}
