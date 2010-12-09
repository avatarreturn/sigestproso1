<?php
// Nombre:Proyecto
// Descripcion: Clase que representa la entidad proyecto del dominio del problema y ofrece las operaciones correspondientes para su manejo

//Clases de negocio
include_once('Participacion.php');
include_once('Trabajador.php');
include_once('Fase.php');
include_once('Iteracion.php');
include_once('Actividad.php');
include_once('Tarea.php');
//Clase de persistencia
include_once('Persistencia/PProyecto.php');

class Proyecto {

	private $idProyecto;
  	private $nombre;
  	private $objetivos;
  	private $estado;
	private $fases;
 	private $responsable;
  	private $participaciones;
	
	public function __construct($n_nombre,$n_objetivos,$n_estado, $n_responsable){
		$this->idProyecto=0;
  		$this->nombre=$n_nombre;
  		$this->objetivos=$n_objetivos;
  		$this->estado=$n_estado;
  		$this->fases=array();
		$this->responsable=$n_responsable;
  		//Se crea siembre vacio, hay que usar el add para a�adir
		$this->participaciones=array();

	}
	
	
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	// Getters y Setters
	/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	public function getId(){
		return $this->idProyecto;
	}

	public function getNombre(){
		return $this->nombre;
	}
	public function setNombre($nombre){
		return $this->nombre=$nombre;
	}
	
	public function getObjetivos(){
		return $this->objetivos;
	}
	public function setObjetivos($objetivos){
		return $this->objetivos=$objetivos;
	}
	public function getEstado(){
		return $this->estado;
	}
	public function setEstado($estado){
		return $this->estado=$estado;
	}
	public function getFaseInicio()
	{
		$fases=$this->getFases();
		foreach($fases as $fase)
		{
			if($fase->getNombre()=="Inicio")
			$retorno = $fase;		
		}	
		return $retorno;
	}
	public function getFaseConstruccion()
	{
		$fases=$this->getFases();
		foreach($fases as $fase)
		{
			if($fase->getNombre()=="Construccion")
			$retorno = $fase;		
		}	
		return $retorno;
	}
	public function getFaseElaboracion()
	{
		$fases=$this->getFases();
		foreach($fases as $fase)
		{
			if($fase->getNombre()=="Elaboracion")
			$retorno = $fase;		
		}	
		return $retorno;
	}
	public function getFaseTransicion()
	{
		$fases=$this->getFases();
		foreach($fases as $fase)
		{
			if($fase->getNombre()=="Transicion")
			$retorno = $fase;		
		}	
		return $retorno;
	}

        public function searchFase($idFase)
	{
		$fases=$this->getFases();
		foreach($fases as $fase)
		{
			if($fase->getId()==$idFase)
			$retorno = $fase;
		}
		return $retorno;
	}
	
	public function perteneceFase(&$infase){
		$fases=$this->getFases();
		$idFase = $infase->getId();
		$retorno = false;
		foreach($fases as $fase)
		{
			if($fase->getId()==$idFase)
			$retorno = true;
		}
		return $retorno;
	}

	public function perteneceIteracion(&$initeracion){
			$fases=$this->getFases();
			$retorno = false;
			foreach($fases as $fase)
			{
				if($fase->perteneceIteracion($initeracion)){
					$retorno = true;
				}
			}
			return $retorno;
	}

	public function perteneceActividad(&$inactividad){
		$fases=$this->getFases();
		$retorno = false;
		foreach($fases as $fase)
		{
			$iteraciones = $fase->getIteraciones();
			foreach($iteraciones as $iteracion){				
				if($iteracion->perteneceActividad($inactividad)){
					$retorno = true;
				}
			}
		}
		return $retorno;
	}


	public function perteneceTarea(&$intarea){
		$fases=$this->getFases();
		$retorno = false;
		foreach($fases as $fase)
		{
			$iteraciones = $fase->getIteraciones();
			foreach($iteraciones as $iteracion){
				$actividades = $iteracion->getActividades();
				foreach($actividades as $actividad){				
					if($actividad->perteneceTarea($intarea)){
						$retorno = true;
					}
				}
			}
		}
		return $retorno;
	}
	
	public function finalizable(){
		$retorno = true;
		$fases = $this->getFases();
		foreach($fases as $fase)
		{
			if($fase->getEstado() != 2)
			$retorno = false;
		}
		if (($this->estado==2)||($this->estado==0)){
			$retorno = false;
		}
		return $retorno;
	}

        public function searchParticipacion($idTrabajador)
	{
		$participaciones = $this->getParticipaciones();
                $idParticipacion = $this->getId()."_".$idTrabajador;
		foreach($participaciones as $participacion)
		{
			if($participacion->getId()==$idParticipacion)
			$retorno = $participacion;
		}
		return $retorno;
	}
	
	//Instaciacion perezosa
	public function getFases(){
		if ($this->fases==NULL)
     		$this->fases=Fase::GetFasesByProyecto($this);
		return $this->fases;
	}

	//Funcion para a�adir fases,a�ade un elemento al array
	public function addFase(&$fase){
		try{
			//Me aseguro que esten cargadas
			$this->getFases();
			array_push($this->fases,$fase);
			return true;
		}catch(Exception $e)
		{
			return false;
		}
	}
	
	public function getResponsable(){
		return $this->responsable;
	}

	public function setResponsable($responsable){
		return $this->responsable=$responsable;
	}
		
	public function deleteParticipacion($id)
	{
		try{
			$aux=array();
			foreach($this->getParticipaciones() as $participacion)
			{
				if($participacion->getId()==$id)
				  $participacion->Borrar();
				else
					array_push($aux,$participacion);
			}
			$this->participaciones = $aux; 
			return true;			
		}
		catch(Exception $e)
		{
			return false;		
		}
	}
	

	//Instaciacion perezosa
	public function getParticipaciones(){

	if ($this->participaciones==NULL)
    	{
		$this->participaciones=Participacion::GetParticipacionesByProyecto($this);
	}
	return $this->participaciones;
	}
	
	//Funcion para a�dir participaciones,a�ade un elemento al array
	public function addParticipacion(&$participacion){
		try{
			//Me aseguro que esten cargadas
			$this->getParticipaciones();
			array_push($this->participaciones,$participacion);
			return true;
		}catch(Exception $e)
		{
			return false;
		}
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////METODOS/////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	//Funcion que se encarga de hacer persistente el objeto, devuelve true si lo guard� y false si no, faltaria meter el update
	public function Guardar(){
			//Guardo las fases
			foreach($this->getFases() as $fase)
			{
				$fase->Guardar($this);
			}
			
			//Guardo las participaciones
			foreach($this->getParticipaciones() as $participacion)
			{
				$participacion->Guardar($this);
			}

		//Si el id es 0 inserto y si no actualizo el registro
		if($this->idProyecto==0)
		{
		
			//Invoco al metodo guardar est�tico de pproyecto, que me devuelve true si interta y false si no	
			$retorno=PProyecto::Guardar($this->nombre,$this->objetivos,$this->estado,$this->responsable->getIdTrabajador());
			if($retorno ==0)
				return false;
			else
			{
				$this->idProyecto=$retorno;
				return true;
			}		
		}
		else
		{
			$retorno=PProyecto::Actualizar($this->idProyecto,$this->nombre,$this->objetivos,$this->estado,$this->responsable->getIdTrabajador());
			if($retorno ==0)
				return false;
			else
				return true;	
		}	
	}
	
	//Funci�n que elimina el objeto de persistencia, devuelve true si lo borr� y false si no
	public function Borrar(){
			//Si el id es distinto de 0 intento borrar si no ni lo intento
			if($this->idProyecto==0)
				return false;
			else
				{
					
					//Borro las fases
					foreach($this->fases as $fase)
					{			
						$fase->Borrar();
					}				

					//Borro las participaciones
					foreach($this->participaciones as $participacion)
					{			
						$participacion->Borrar();
					}				
					return PProyecto::Borrar($this->idProyecto);
				}
	
	}
	
	
	////////////////////////////////////////////////////////////////////////////////////////////////////////////
	//////////////////////////////////////////////METODOS ESTATICOS////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////

	//Funcion que devuelve todos los proyectos
	public static function getAllProyectos(){
		try{
			//Obtengo datos de los proyectos
			$datos = PProyecto::GetAllProyectos();
			$retorno = array();
			//Para cada proyecto que tengo instacio un objeto
			foreach($datos as $dato)
			{

				$aux = new Proyecto($dato[1],$dato[2],$dato[3],Trabajador::GetTrabajadorById($dato[4]));
				//Asigno el id
				$aux->idProyecto=$dato[0];
				//Cargo participaciones de proyecto
				//Instaciacion perzosa se pone a nulo y se carga en el get
				$aux->participaciones=NULL;
				//Cargo fases de proyecto
				//Instaciacion perzosa se pone a nulo y se carga en el get
				$aux->fases=NULL;
				array_push($retorno,$aux);		
			}
			return 	$retorno;
		}catch(Exception $e)
		{
			return false;
		}
		
	}
	
	//Funcion que devuelve todos los proyectos de un trabajador
	public static function getProyectosByTrabajador(&$Trabajador){
		try{
			//Obtengo datos de los proyectos del trabajador
			$datos = PProyecto::GetProyectosByTrabajador($Trabajador->getIdTrabajador());
			$retorno = array();
			//Para cada proyecto que tengo instacio un objeto
			foreach($datos as $dato)
			{
				$aux = new Proyecto($dato[1],$dato[2],$dato[3],Trabajador::GetTrabajadorById($dato[4]));			
				//Asigno el id
				$aux->idProyecto=$dato[0];
				//Cargo participaciones de proyecto
				//$aux->participaciones=Participacion::GetParticipacionesByProyecto($dato[0]);
				//Instaciacion perzosa se pone a nulo y se carga en el get
				$aux->participaciones=NULL;
				//Cargo fases de proyecto
				//$aux->fases=Fase::GetFasesByProyecto($dato[0]);
				//Instaciacion perzosa se pone a nulo y se carga en el get
				$aux->fases=NULL;
				array_push($retorno,$aux);		
			}
			return 	$retorno;
		}catch(Exception $e)
		{
			return false;
		}
	
	
	}
	
	
		public static function getProyectosFinalizados(){
		try{
			//Obtengo datos de los proyectos del trabajador
			$datos = PProyecto::getProyectosFinalizados();
			$retorno = array();
			//Para cada proyecto que tengo instacio un objeto
			foreach($datos as $dato)
			{
				$aux = new Proyecto($dato[1],$dato[2],$dato[3],Trabajador::GetTrabajadorById($dato[4]));
				//Asigno el id
				$aux->idProyecto=$dato[0];
				//Cargo participaciones de proyecto
				//$aux->participaciones=Participacion::GetParticipacionesByProyecto($dato[0]);
				//Instaciacion perzosa se pone a nulo y se carga en el get
				$aux->participaciones=NULL;
				//Cargo fases de proyecto
				//$aux->fases=Fase::GetFasesByProyecto($dato[0]);
				//Instaciacion perzosa se pone a nulo y se carga en el get
				$aux->fases=NULL;
				array_push($retorno,$aux);		
			}
			//echo count($retorno);
			return 	$retorno;
		}catch(Exception $e)
		{
			return false;
		}
	
	
	}
	
	
	
	
	
	public static function getProyectosFinalizadosByJefeDeProyecto(&$Trabajador){
		try{
			//Obtengo datos de los proyectos del trabajador
			$datos = PProyecto::getProyectosFinalizadosByJefeDeProyecto($Trabajador->getIdTrabajador());
			$retorno = array();
			//Para cada proyecto que tengo instacio un objeto
			foreach($datos as $dato)
			{
				$aux = new Proyecto($dato[1],$dato[2],$dato[3],Trabajador::GetTrabajadorById($dato[4]));
				//Asigno el id
				$aux->idProyecto=$dato[0];
				//Cargo participaciones de proyecto
				//$aux->participaciones=Participacion::GetParticipacionesByProyecto($dato[0]);
				//Instaciacion perzosa se pone a nulo y se carga en el get
				$aux->participaciones=NULL;
				//Cargo fases de proyecto
				//$aux->fases=Fase::GetFasesByProyecto($dato[0]);
				//Instaciacion perzosa se pone a nulo y se carga en el get
				$aux->fases=NULL;
				array_push($retorno,$aux);		
			}
			//echo count($retorno);
			return 	$retorno;
		}catch(Exception $e)
		{
			return false;
		}
	
	
	}

        //Funcion que devuelve el proyecto relacionado con un determinado id
	public static function getProyectoById($id){
		try{
			//Obtengo datos del proyecto
			$dato = PProyecto::GetProyectoById($id);
			$retorno = array();
			//Para cada proyecto que tengo instacio un objeto

				$retorno = new Proyecto($dato[1],$dato[2],$dato[3],Trabajador::GetTrabajadorById($dato[4]));
				//Asigno el id
				$retorno->idProyecto=$dato[0];
				//Cargo participaciones de proyecto
				//$aux->participaciones=Participacion::GetParticipacionesByProyecto($dato[0]);
				//Instaciacion perzosa se pone a nulo y se carga en el get
				$retorno->participaciones=NULL;
				//Cargo fases de proyecto
				//$aux->fases=Fase::GetFasesByProyecto($dato[0]);
				//Instaciacion perzosa se pone a nulo y se carga en el get
				$retorno->fases=NULL;
			return 	$retorno;
		}catch(Exception $e)
		{
			return false;
		}


	}
	
	

		

}
?>
