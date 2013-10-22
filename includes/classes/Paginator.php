<?php
class Paginator
{
	public  $sql;
	public  $total; // Cantidad total de resultados.
	private $limit; // Limite de resultados por pagina.
	private $links; // Cantidad de links que muestra el paginador.
	private $html;
	private $url;
	private $url_vars;
	private $p;
	private $pg_actual;
	private $pg_total;

	function __construct($limit, $links, $total)
	{
		$this->limit = $limit;
		$this->links = $links;
		$this->total = $total;

		$this->url 		 = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

		$this->pg_actual = (isset($_GET['p']) && is_numeric($_GET['p'])) ? $_GET['p'] : 1;
		$this->pg_total  = ceil($this->total / $this->limit);

		$this->sql = ' LIMIT '. (($this->pg_actual - 1) * $this->limit) .','.$this->limit;

		if(is_array($_GET))
		{
			$x = 0;
			foreach($_GET as $key => $value)
			{
				if($key=='p'){continue;}
				$this->url_vars.= (++$x == 1) ? '?'.$key.'='.$value : '&amp;'.$key.'='.$value;
			}
			$this->p = ($this->url_vars=='') ? '?p=' : '&amp;p=';
		}
	}

	// Le pasamos un formato para armar el pie:
	private function build($formato)
	{
		$inicio = $anterior = $siguiente = $fin = '';
		if($this->pg_actual != 1)
		{
			$inicio   = str_replace('##', $this->url . $this->url_vars, $formato['inicio']);

			$x = ($this->pg_actual>2) ? $this->p . ($this->pg_actual-1) : '';
			$anterior = str_replace('##', $this->url . $this->url_vars . $x, $formato['anterior']);
		}

		if($this->pg_actual < $this->pg_total)
		{
			$siguiente = str_replace('##', $this->url . $this->url_vars . $this->p . ($this->pg_actual+1), $formato['siguiente']);
			$fin 	   = str_replace('##', $this->url . $this->url_vars . $this->p . $this->pg_total, $formato['fin']);
		}

		if($this->links == 0) $numeracion = str_replace(array('{A}','{T}'), array($this->pg_actual,$this->pg_total), $formato['page_alt']);
		else
		{
		    for($i=$this->links; $i>=1; $i--)
		    {
		        $page = $this->pg_actual-$i;
                if($page<1) continue;
                
		        $url = ($page>1) ? $this->url .$this->url_vars.$this->p.$page : $this->url.$this->url_vars;
			    $numeracion.= str_replace(array('##','{P}'), array($url, $page), $formato['paginas']);
			}

			$numeracion.= str_replace('{P}', $this->pg_actual, $formato['selected']);

			for($i=1; $i<=$this->links; $i++)
		    {
                $page = $this->pg_actual+$i;
                if($page>$this->pg_total) continue;
		    
		        $url  = $this->url .$this->url_vars.$this->p.$page;
			    $numeracion.= str_replace(array('##','{P}'), array($url, $page), $formato['paginas']);
			}
		}

		$this->html = $inicio.' '.$anterior.' '.$numeracion.' '.$siguiente.' '.$fin;
	}

	// Devuelve el paginador:
	public function show($type='', $formato=array())
	{
		if(empty($formato))
		{
		    switch($type)
		    {
		        case 1:
			        $formato['anterior']  = '<a href="##">Anterior</a>';
			        $formato['siguiente'] = '<a href="##">Siguiente</a>';
			        $formato['page_alt']  = '<span>{A} / {T}</span>';
			        $formato['paginas']   = '<a href="##">{P}</a>';
			        $formato['selected']  = '<span class="strong">{P}</span>';
			        break;

			    default:
			        $formato['inicio']    = '<a href="##" title="primera"><img src="'.HOST.'static/icons/control-stop-180.png" alt="" /></a>';
			        $formato['anterior']  = '<a href="##" title="anterior"><img src="'.HOST.'static/icons/control-double-180.png" alt="" /></a>';
			        $formato['siguiente'] = '<a href="##" title="siguiente"><img src="'.HOST.'static/icons/control-double.png" alt="" /></a>';
			        $formato['fin'] 	  = '<a href="##" title="última"><img src="'.HOST.'static/icons/control-stop.png" alt="" /></a>';
			        $formato['page_alt']  = '<span>{A} / {T}</span>';
			        $formato['paginas']   = '<a href="##">{P}</a>';
			        $formato['selected']  = '<span class="strong">{P}</span>';
			        break;
			}
		}

		$this->build($formato);
		return $this->html;
	}
}

