<?php

/**
    Powered by Ator:
    Clase para utilizar en todos los exports de CSV.
    Así están unificados los delimitadores, etc.

    ------------------------------------------------------

    Ejemplo 1:

    $csv = new CSVExport();
    $csv->putResultset($result);
    $csv->export();
    exit;

    ------------------------------------------------------

    Ejemplo 2: Mando un arreglo completo, por ejemplo, cuando tengo
               que procesar los resultados antes de exportarlos

    $csv = new CSVExport('participaciones');
    $csv->firstline($result);

    // proceso renglon por renglon generando un gran arreglo de arreglos
    while($row = mysql_fetch_assoc($result))
    {
        $array = array();
        foreach($row as $key => $value)
        {
            if($key == 'codigo') $array[] = codigo($value);
            else $array[] = $value;
        }

        $arrays[] = $array;
    }

    // Exporto el arreglo de arreglos de una
    $csv->putAll($arrays);
    $csv->export();
    exit;

    ------------------------------------------------------
*/

class CSVExport
{
    public $delimiter  = ';';          // Separador de columnas
    public $enclosure  = '"';          // Encapsulador de datos
    public $filename   = 'export';     // Filename
    protected $path;                   // Path
    protected $fp;


    // Inicio:
    public function __construct($filename='')
    {
        if($filename!='') $this->filename = $filename;

        $this->path = DIR_FILE_UPLOAD.'/'.$this->filename.'.csv';
        $this->fp   = fopen($this->path, 'w');
    }

    // Agrego resultset completo de la consulta:
    public function putResultset($resultset, $firstLineIsHeader=true)
    {
        if($firstLineIsHeader) $this->firstLine($resultset);
        while($row = mysql_fetch_assoc($resultset)) $this->put($row);
    }

    // First Line:
    public function firstLine($resultset)
    {
        while($row = mysql_fetch_field($resultset)) $rows[] = $row->name;
        $this->put($rows);
    }

    // Agrego fila:
    public function put($row=array())
    {
        // Esto se hace porque el fputcsv no encierra todos los campos con el enclosure. Y algunos campos después se ven mal.
        // Entonces le agregamos este string para forzar el enclosure y después se lo quitamos.
        foreach($row as $value) $row2[] = $value.'#@ @#';
        fputcsv($this->fp, $row2, $this->delimiter, $this->enclosure);
    }

    // Agrego todas las filas:
    public function putAll($rows=array())
    {
        foreach($rows as $row) $this->put($row);
    }

    // Export / Download:
    function export($zip=true)
    {
        fclose($this->fp);

        $contents = file_get_contents($this->path);
        $contents = str_replace('#@ @#', '', $contents);
        file_put_contents($this->path, $contents);

        ob_clean(); // WTF!!! Esto soluciona una línea en blanco que aparece en seleccionesMX y arruina todo.
        
        if($zip)
        {
            $zp = gzopen($this->path.'.gz', 'w9');
            gzwrite($zp, file_get_contents($this->path));
            gzclose($zp);

            header('Cache-Control: no-store, no-cache');
            header('Content-Encoding: zip');
            header('Content-Disposition: attachment; filename="'.$this->filename.'.csv.gz"');
            echo file_get_contents($this->path.'.gz');
        }
        else
        {
            header('Cache-Control: no-store, no-cache');
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="'.$this->filename.'.csv"');
            echo file_get_contents($this->path);
        }
    }

    // Fin:
    public function __destruct()
    {
        unlink($this->path);
        @unlink($this->path.'.gz');
    }
}

set_time_limit(0);
ini_set('memory_limit', '1024M'); // Comprimir consume bastante...
?>
