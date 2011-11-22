<?php 

class FormComponent implements GuiComponent
{

	protected $form_fields;
	protected $submit_form;
	protected $on_click;
	protected $send_to_api;

	function __construct(  )
	{
		
		$this->send_to_api 		= null;
		$this->on_click 		= null;
	 	$this->submit_form 		= null;
		$this->form_fields      = array(  );
	}

	function addField( $id, $caption, $type, $value = "", $name = null )
	{
		array_push( $this->form_fields, new FormComponentField($id, $caption, $type, $value, $name ) );
	}

	function renderCmp()
	{
		
		//sort fields by the necesary attribute
		usort( $this->form_fields, array( "FormComponentField", "obligatorySort"  ));
		
		$html = "";
		
		if( !is_null($this->send_to_api)){
			
			$html.= "<script>";
			$html .= "function sendToApi( ){";
			$html.= "	POS.API.POST(\"". $this->send_to_api ."\", ";
			$html.= "	{" ;
			
			foreach( $this->form_fields as $f )
			{
				$html .= "	" . $f->id . " : Ext.get('". $f->id . "').getValue()," ;
			}
			
			$html.= "	},{";
			$html.= "		callback : function( a ){ ";
			$html.= "			";
			$html.= "			console.log('OKAY');";
			$html.= "			";
			$html.= "			";									
			$html.= "	 	}";
			$html.= "	});";
			$html.= "}";
			$html.= "</script>";			
			
		}
			
		$html .= "<table width=100%>";

		if( !is_null ( $this->submit_form ) ){
			$html .= "<form method='". $this->submit_form["method"] . "' action='". $this->submit_form["submit_form_url"] . "'>";

		}else{
			$html .= "<form >";	
			
		}
		
		$new_row = 0;
		$html .= "<tr>";
		foreach( $this->form_fields as $f )
		{
			//incrementar el calculo de la fila actual
			$new_row++;
			
			if($f->type !== "hidden"){
				$html .= "<td>";
				if($f->obligatory === true) $html .= "<b>";
				$html .= $f->caption;
				if($f->obligatory === true) $html .= "</b>";
				$html .= "</td><td>";				
			}

			switch( $f->type ){
				case "combo" :
					$html .= "<select id='". $f->id  ."'>";
					
					foreach($f->value as $o)
						$html .= "<option>".$o."</option>";
					
					$html .= "</select>";
					//$this->form_fields[$i]->value
				break;
				
				default:
					$html .= "<input id='" . $f->id .  "' name='" . $f->name .  "' value='" . $f->value .  "' type='". $f->type ."' >";				
			}

			
			if($f->type !== "hidden"){
				$html .= "</td>";
			}
			
			if($new_row == 2){
				$html .= "</tr><tr>";
				$new_row = 0;
			}
		}
		
		$html .= "</tr>";

		if( !is_null ( $this->submit_form 	) ){
			$html .= "<tr><td>";
			$html .= "</td><td align=right>";
			$html .= "<input value='" . $this->submit_form["caption"] .  "' type='submit'  >";
			$html .= "</td></tr>";
		}

		if( !is_null ( $this->on_click 		) ){
			$html .= "<tr><td>";
			$html .= "</td><td align=right>";
			$html .= "<input value='" . $this->on_click["caption"] .  "' type='button' onClick='". $this->on_click["function"] ."' >";
			$html .= "</td></tr>";
		}

		if( !is_null ( $this->send_to_api	) ){
			$html .= "<tr><td>";
			$html .= "</td><td align=right>";
			$html .= "<input value='Aceptar' type='button' onClick='sendToApi()' >";
			$html .= "</td></tr>";			
			
		}

		$html .= "</form></table>";

		return $html;

	}


	public function addSubmit( $caption, $submit_form_url = "", $method = "GET"){
		$this->submit_form = array( "caption" => $caption, "submit_form_url" => $submit_form_url, "method" => $method );
	}

	public function addOnClick( $caption, $js_function){
		$this->on_click = array( "caption" => $caption, "function" => $js_function );
	}

	public function addApiCall( $method_name ){
		$this->send_to_api = $method_name;
		
	}

	public function renameField( $field_array ){
		
		$found = false;
		foreach ($field_array as $old_name => $new_name) {
			$found = false;
			$sof = sizeof( $this->form_fields );

			for ($i=0; $i < $sof; $i++) { 
				
				if( $this->form_fields[$i]->id === $old_name )
				{
					$this->form_fields[$i]->id = $new_name;
					$this->form_fields[$i]->caption = ucwords(str_replace ( "_" , " " , $new_name ));

					
					$found = true;
					break;
				}//if

			}//for
			
			if($found === false) throw new Exception("Field `".$old_name."` not found in the VO object.");
			
		}//foreach field in the array
	}

	public function makeObligatory( $field_array ){
		
		foreach ($field_array as $field) {
			
			$sof = sizeof( $this->form_fields );

			for ($i=0; $i < $sof; $i++) { 

				if( $this->form_fields[$i]->id === $field )
				{
					$this->form_fields[$i]->obligatory = true;
				}//if

			}//for
		}
	}

	public function createComboBoxJoin( $field_name, $field_name_in_values, $values_array ){
		if( sizeof( $values_array ) == 0 ){
			//do something
		}

		$sof = sizeof( $this->form_fields );

		for ($i=0; $i < $sof; $i++) { 
			
			if( $this->form_fields[$i]->id === $field_name )
			{
				$this->form_fields[$i]->type  = "combo";
				
				$end_values = array();

				foreach ($values_array as $v ){
					$v = $v->asArray();
					array_push( $end_values, $v["$field_name_in_values"] );

				}
				
				$this->form_fields[$i]->value =  $end_values;

				break;
			}//if
		}//for

	}

	public function createComboBox( $field_name, $values){
		
	}

}




class FormComponentField{

	public $id;
	public $caption;
	public $type;
	public $value;
	public $name;
	public $obligatory;

	public function __construct( $id, $caption, $type, $value = "", $name = null, $obligatory = false ){
			$this->id 		= $id;
			$this->caption 	= $caption;
			$this->type 	= $type;
			$this->value 	= $value;
			$this->name 	= $name;
			$this->obligatory 	= $obligatory;
	}
	
	
	public static function obligatorySort( $f1, $f2 ){
	
		if ($f1->obligatory == $f2->obligatory) {
			return 0;
		}
		
		if( $f1->obligatory ) return -1;

		return 1;
	}
}


