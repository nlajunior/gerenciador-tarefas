<?php
    include "cabecalho.php";

    // Filter the excel data 
    function filterData(&$str){ 
        $str = preg_replace("/\t/", "\\t", $str); 
        $str = preg_replace("/\r?\n/", "\\n", $str); 
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"'; 
    } 
     
    // Excel file name for download 
    $fileName = "tarefas-data_" . date('Y-m-d') . ".xls"; 
     
    // Column names 
    $fields = array('Nome', 'Descrição', 'Prazo', 'Prioridade', 'Concluida'); 
     
    // Display column names as first row 
    $excelData = implode("\t", array_values($fields)) . "\n"; 
     
    // Fetch records from database 
    $lista_tarefas = $_SESSION['lista_tarefas'];

    foreach ($lista_tarefas as $tarefa) : 
        $linha = array($tarefa['nome'], $tarefa['descricao'], $tarefa['prazo'], $tarefa['prioridade'], $tarefa['concluida']);
        array_walk($linha, 'filterData');
        $excelData .= implode("\t", array_values($linha)) . "\n"; 
    endforeach;
    
    header("Content-Type: application/vnd.ms-excel"); 
    header("Content-Disposition: attachment; filename=\"$fileName\""); 
 

    echo $excelData; 
   

     
    exit;
    