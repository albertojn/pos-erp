<?php
/**
  * 
  * @author Alan Gonzalez
  *
  *
  **/

class FormComponent implements GuiComponent {
	protected $form_fields;
	protected $submit_form;
	protected $on_click;
	protected $send_to_api;
	private $send_to_api_http_method;
	private $send_to_api_callback;
	private $send_to_api_redirect;
	private $is_editable;
	private $hide_not_obligatory;
	private $guiComponentId;
	private $special_sort;
	private $js_function;
	private $style;

	/**
	 *
	 *
	 * */
	public function __construct( ){
		$this->send_to_api          = null;
		$this->on_click             = null;
		$this->submit_form          = null;
		$this->send_to_api_callback = null;
		$this->send_to_api_redirect = null;

		//defaults
		$this->is_editable			= true;
		$this->form_fields			= array();
		$this->hide_not_obligatory	= false;
		$this->special_sort		 	= null;
		$this->js_function 			= NULL;
		$this->style 				= "compact";

		//para eviar id's repetidos 
		//@todo esto esta de la verga, hacer una variable estatica con conteo
		$this->guiComponentId = "_"  . (rand() + rand());
	}

	/**
	 *
	 *
	 * */
	public function sortOrder(Array $order) {
		$this->removeDuplicates();
		$found_needed = $fn = sizeof( $this->form_fields );
		$error = "";
		$out = array();

		for ($i=0; $i < $fn; $i++) {
			
			if( $i >= sizeof( $order ) ) {
				throw new Exception("te faltan parametros ");
			}
			
			if( $this->form_fields[$i]->hidden ) continue;
			
			if( !in_array( $this->form_fields[$i]->id , $order ) ) {
				$error .= "`".$this->form_fields[$i]->id."`, ";

			}else{
				$out[array_search( $this->form_fields[$i]->id, $order )] = $this->form_fields[$i];

			}
		}
		
		if(strlen($error) > 0) {
			throw new Exception("fields: $error not found in your ordered array."); 
		}

		$this->special_sort = $order;
		$this->form_fields = $out;
	}

	public function beforeSend( $jsFunction) {
		$this->js_function = $jsFunction;
	}

	public function getGuiComponentId() {
		return $this->guiComponentId;
	}

	public function setStyle($style) {
		switch($style) {
			case "compact" :
			case "big" :
				$this->style = $style;
			break;

			default:
				throw new Exception("Este estilo no existe");

		}
		
	}

	/**
	 *
	 *
	 * */
	public function hideNotObligatory( ) {
		$this->hide_not_obligatory = true;
	}

	/**
	 * 
	 * 
	 * */
	public function setEditable($editable) {
		$this->is_editable = $editable;
	}

	/**
	 * 
	 * 
	 * */
	public function addField($id, $caption, $type, $value = "", $name = null) {
		array_push($this->form_fields, new FormComponentField($id, $caption, $type, $value, $name));
		return true;
	}

	/**
	 * 
	 * 
	 * */
	protected function removeDuplicates() {
		usort($this->form_fields, array( "FormComponentField","idSort" ));
		
		$top_i = 0;
		
		
		for ($i = 1; $i < sizeof($this->form_fields); $i++)
		{
			if (($this->form_fields[$i]->id != $this->form_fields[$top_i]->id))
			{
				$this->form_fields[++$top_i] = $this->form_fields[$i];
			}
		}
		
		$this->form_fields = array_slice($this->form_fields, 0, $top_i + 1, true);
	}

	private function sortFields(){
		//remove fields with the same id
		$this->removeDuplicates();

		if(!is_null($this->special_sort)){
			/* for ($i=0; $i < sizeof( ); $i++) { 
				# code...
			}*/
			
		}else{
			//sort fields by the necesary attribute
			usort($this->form_fields, array(
				"FormComponentField",
				"obligatorySort"
			));
			
		}
	}

	public function sendHidden( $field_name ){
		if( is_array( $field_name ) ){
			foreach ($field_name as $field ) {
				$this->sendHidden( $field );
			}
			return;
		}
		
		
		$sof = sizeof($this->form_fields);

		for ($i=0; $i < $sof; $i++) { 

			if( $this->form_fields[$i]->id == $field_name )
			{
				$this->form_fields[$i]->send_as_hidden = true;
				$this->form_fields[$i]->hidden = true;
				$this->form_fields[$i]->type = "hidden";
				return true;
			}
		}
		
		throw new Exception("Field `".$field_name."` not found in the VO object.");
	}

	public function hideField( $field_name ){
		$this->removeDuplicates();
		
		if( is_array( $field_name ) ){
			foreach ($field_name as $field ) {
				$this->hideField( $field );
			}
			return;
		}

		$sof = sizeof($this->form_fields);

		for ($i=0; $i < $sof; $i++) {
			if( $this->form_fields[$i]->id == $field_name ) {
				$this->form_fields[$i]->type = "hidden";
				$this->form_fields[$i]->send_as_hidden = false;
				$this->form_fields[$i]->hidden = true;
				return true;
			}
		}
		
		throw new Exception("Field `".$field_name."` not found in the VO object.");
	}

	/**
	 * 
	 * 
	 * */
	function renderCmp( ) {
		$this->sortFields();

		$html = "";

		// enviaremos al api o hay onclick
		if( !is_null( $this->send_to_api ) || !is_null( $this->on_click ) ) {

			$html = "\n<script>";
			$html .= 'if(HtmlEncode===undefined){ var HtmlEncode=function(a){var b=a.length,c=[];while(b--){var d=a[b].charCodeAt();if(d>127||d>90&&d<97){c[b]="&#"+d+";"}else{c[b]=a[b]}}return c.join("")}} ';
			$html .= "\n\nvar ".$this->guiComponentId."obligatory = [];\n";

			foreach ( $this->form_fields as $f ) {
				if ( $f->obligatory ) {
					$html .= $this->guiComponentId . "obligatory.push( '" . $this->guiComponentId . $f->id . "' );\n";
				}
			}

			//javascript: getparams()
			$html .= "\nfunction ". $this->guiComponentId ."getParams(){\n";
			$html .= "\tvar ". $this->guiComponentId ."p = {};\n";
			$html .= "\tvar ". $this->guiComponentId ."found = false;\n";

			//cicle fields
			for( $i = 0; $i < sizeof($this->form_fields); $i++ ) {
				$f = $this->form_fields[$i];
				//if this  component is invisible, continue
				if ($f->hidden === true){
					if ($f->send_as_hidden === true) {
						if(is_array($f->value)){
							$html .= "\t". $this->guiComponentId ."p." . $f->id . " = null;\n";
						}else{
							$html .= "\t". $this->guiComponentId ."p." . $f->id . " = " . $f->value . ";\n";
						}
					}
					continue;
				}
				
				///*(Ext.get('" . $f->id . "').getValue().length > 0 ) ||*/

				if( !is_array( $f->value ) ){

					if($f->type == "textarea"){
						$html .= "if(true){ ";
					}else{
						$html .= "\n\tif(  (Ext.get('" . $this->guiComponentId . $f->id . "').getValue() != '". $f->value ."') ){";
					}

				}else{
					//combo boxes are arrays
					$html .= "if(true){ ";
				}

				if($f->type == "date"){
					$html .= "\n\t\t". $this->guiComponentId ."p." . $f->id . " = ( Ext.getCmp('". $this->guiComponentId . $f->id . "').getValue() ); \n\t} else{\n ";

				}else{
					$html .= "\n\t\t". $this->guiComponentId ."p." . $f->id . " = HtmlEncode( Ext.get('". $this->guiComponentId . $f->id . "').getValue() ); \n\t} else{\n ";

				}

				//else si no esta lleno de datos, vamos a buscarlo en los obligatorios, 
				//si esta en los obligatorios entonces mandamos el error
				$html .= "\n\t\tfor (var i = ".$this->guiComponentId."obligatory.length - 1; i >= 0; i--){\n";
				$html .= "	\t\tif( ".$this->guiComponentId."obligatory[i] == '" .  $this->guiComponentId . $f->id . "') {\n";
				$html .= "	\t\t\t". $this->guiComponentId ."found = true; console.log('found it');\n";
				$html .= "\t\t\t\tExt.get('" . $this->guiComponentId . $f->id . "').highlight('#DD4B39');\n";
				$html .= "\n\t\t\t}\n";
				$html .= "\t\t}\n";
				$html .= "\t}\n";
				
			}

			if(is_null($this->js_function)){
				if(is_null($this->on_click)){
					$html .= "	if(!".$this->guiComponentId."found){ ". $this->guiComponentId ."sendToApi( ". $this->js_function . "(" . $this->guiComponentId."p ) ); }else{console.log('you have missing data');}\n";					
				}else{
					//$html .= "	if(!".$this->guiComponentId."found){ ". $this->on_click["function"] ."(" . $this->guiComponentId."p  ); }else{console.log('you have missing data');}\n";
					$html .= "return {}";
				}

			}else{
				$html .= "	if(!".$this->guiComponentId."found){ ". $this->guiComponentId ."sendToApi( ". $this->js_function . "(" . $this->guiComponentId."p ) ); }else{console.log('you have missing data');}\n";

			}

			$html .= "}\n\n";

			if(!is_null($this->send_to_api) ){
				$html .= "function ". $this->guiComponentId ."sendToApi( params ){\n";
				$html .= "	POS.API." . $this->send_to_api_http_method . "(\"" . $this->send_to_api . "\", params, \n";
				$html .= "	{\n";
				$html .= "		callback : function( a ){ \n";
				$html .= "			";
				$html .= "			/* remove unload event */\n";
				$html .= "			window.onbeforeunload = function(){ return;	};\n";
			
				if (!is_null($this->send_to_api_callback))
					$html .= "			" . $this->send_to_api_callback . "( a );";
			
				if (!is_null($this->send_to_api_redirect)){
					$html .= "var extra_params= '' ; ";
					$html .= "for(var prop in a) {
					  			  if(a.hasOwnProperty(prop))
										if(prop == 'status') continue;
										extra_params += '&' + prop + '=' + a[prop];
								        /*console.log(prop, a[prop]);*/
								}";
						
					if(strrpos ( $this->send_to_api_redirect , "?" ) === FALSE){
						//no hay '?'
                    	$html .= "			window.location = '" . $this->send_to_api_redirect . "?'+ extra_params +'&previous_action=ok';\n";						
					}else{
						//si hay '?'						
                    	$html .= "			window.location = '" . $this->send_to_api_redirect . "'+ extra_params +'&previous_action=ok';\n";						
					}
					
					
				}else{
					$html .= "Ext.example.msg('Exito', 'Your data was saved!');";
					
				}

				$html .= "			\n";
				$html .= "			\n";
				$html .= "	 	}\n";
				$html .= "	});\n";
				$html .= "}\n";
			}
			$html .= "</script>";
			
		}
		
		$html .= "<table width=100%>";

		if (!is_null($this->submit_form)){
			$html .= "<form method='" . $this->submit_form["method"] . "' action='" . $this->submit_form["submit_form_url"] . "'>";

		}else{
			$html .= "<form >";

		}
		
		$new_row = 0;
		$html .= "<tr>";
		$n_fields = 0;

		// Create html for the fields
		// posible styles are big and compact
		foreach ( $this->form_fields as $f ) {
			if ( $f->hidden ){
				continue;
			}

			$n_fields ++;

			//incrementar el calculo de la fila actual
			$new_row++;

			if ($f->type !== "hidden"){
				if (($f->obligatory === false) && ($this->hide_not_obligatory)){
					$html .= "<td style='display:none' class='hideable'>";
				}else{
					$html .= "<td>";
				}
				
				//if(($f->obligatory === false) && ($this->hide_not_obligatory)) {
				if ( $f->obligatory ){
					$html .= "<b>";

				}else{
					//$html .= "<div style='display:block' class='hideable'>";

				}

				if($this->style == "big") {
					$html .= "<h3>" . $f->caption . "</h3>";
				}else{
					$html .= $f->caption ;
				}
				

				if ($f->obligatory === true){
					$html .= "*</b>";
				}else{
					//$html .= "</div>";
				}

				$html .= "<div style='color:gray;font-size:-2px'>" . $f->help . "</div>";

				if( $this->style == "big") {

				}else{
					if (($f->obligatory === false) && ($this->hide_not_obligatory)){
						$html .= "</td><td style='display:none' class='hideable'>";

					}else{
						$t = 0;
						for ( $i=0 ; $i < sizeof($this->form_fields); $i++) { 
							if( $this->form_fields[$i]->hidden ) continue;
							$t++;
						}
						if($t == 1){
							$html .= "</td><td colspan=4>";
							
						}else{
							$html .= "</td><td >";
						}
					}
				}



			}//hidden

			switch ($f->type){
				// Combo boxes
				case "combo":
				case "enum" :
					$html .= "<select id='" . $this->guiComponentId  . $f->id . "'";

					if ($this->is_editable === false){
						$html .= " disabled='disabled' ";
					}

					$html .= ">";
					$html .= "<option value=''>------------</option>";
					foreach ($f->value as $o) {
						if ($o["selected"])
							$html .= "<option value='" . $o["id"] . "' selected>" . $o["caption"] . "</option>";
						else
							$html .= "<option value='" . $o["id"] . "'>" . $o["caption"] . "</option>";
					}
					
					
					$html .= "</select>";
					
					break;
				// List boxes
				case "listbox":
					$html .= "<select multiple='true' id='" . $this->guiComponentId . $f->id . "' name='" . $f->name . "' size='" . count($f->value)/2 . "'>";
					foreach ($f->value as $o){
						$html .= "<option value='" . $o["id"] . "'>" . $o["caption"] . "</option>";
					}
					
					$html .= "</select>";
				break;

				case "bool":
					$html .= "<select  id='" . $this->guiComponentId . $f->id . "' name='" . $f->name . "'>";
					$html .= "<option value='1'>Si</option>";
					$html .= "<option value='0'>No</option>";
					$html .= "</select>";
				break;
					
				case "textarea":
					if ($this->is_editable === false)
					{
						$html .= $f->value;
					}
					else
					{
						if(is_null($f->placeholder)){
							$ph = "";
						}else{
							$ph = $f->placeholder;
						}

						$html .= "<textarea " ;
						$html .= "		placeholder	=	'$ph' ";
						$html .= "		style='width:100%' ";
						$html .= "		id='" . $this->guiComponentId  . $f->id . "' ";
						$html .= "		name='" . $f->name . "' ";
						if($this->style == "compact"){
							$html .= "		rows=5 ";
						}else if($this->style == "big"){
							$html .= "		rows=15 ";
						}
						
						$html .= "		cols=auto ";
						$html .= "	>".$f->value."</textarea>";
					}
				break;

				case "date":
					$id_datefield = $this->guiComponentId . $f->id ; //"date_" . (rand() + rand());
					$html .= "<div id = \"{$id_datefield}\"></div>";
					$html .= "<script>";
					$html .= "store_component.addExtComponent(";
					$html .= "  Ext.create('Ext.form.field.Date',{  \n";
					$html .= "      anchor: '100%',  \n";
					$html .= "      name: '" . $id_datefield . "',  \n";
					$html .= "      id: '" . $id_datefield . "',  \n";
					$html .= "      value: new Date()  \n";
					$html .= "  }), '{$id_datefield}' \n";
					$html .= ");";
					$html .= "</script>";
				break;

				case "password": 
					$html .= "<input placeholder='Contrasena' id='" . $this->guiComponentId . $f->id . "' name='" . $f->name . "' value='" . $f->value . "' type='password' >";
				break;

				case "markdown":
				case "hidden": 
				case 'text':
				case 'number':
				case 'string':
					if ($this->is_editable === false){
						//$html .= "<input id='" . $f->id .  "' name='" . $f->name .  "' value='" . $f->value .  "' type='". $f->type ."' >";
						$html .= $f->value;
					}else{
						if(is_null($f->placeholder)){
							$ph = "";
						}else{
							$ph = $f->placeholder;
						}
						$html .= "<input placeholder='$ph' id='" . $this->guiComponentId . $f->id . "' name='" . $f->name . "' value='" . $f->value . "' type='" . $f->type . "' >";
					}
				break;

				default:
					throw new Exception($f->type . " is not recognized by the form creator." );
			}//switch

			if ($f->type !== "hidden"){
				$html .= "</td>";
			}


			if( ($this->style == "compact") && ($new_row == 2)) {
				$html .= "</tr><tr>";
				$new_row = 0;

			} else if( ($this->style == "big") && ($new_row == 1)){
				$html .= "</tr><tr>";
				$new_row = 0;

			}

			

		}//foreach

		$html .= "</tr><tr>";

		//action buttons
		if($this->style == "compact") {
			$html .= "<td></td><td></td>";
		}

		if (!is_null($this->submit_form)){
			$html .= "<td align=right style='background-color: #EDEFF4;-webkit-border-radius: 5px;'>";
			$html .= "<input value='" . $this->submit_form["caption"] . "' type='submit'  >";
			$html .= "</td></tr>";
		}
		
		if (!is_null($this->on_click)) {
			$html .= "<td align=right colspan=2 style='background-color: #EDEFF4;-webkit-border-radius: 5px;'>";
			if (($this->hide_not_obligatory))
			{
				$html .= "<div class='POS Boton' onClick='Ext.get(Ext.query(\".hideable\")).show()' >Mas opciones</div>";
			}
			$html .= "<div class='POS Boton OK' onClick='" . $this->on_click["function"] . "(" . $this->guiComponentId . "getParams())' >" . $this->on_click["caption"] . "</div>";			
			$html .= "</td></tr>";
		}
		
		if (!is_null($this->send_to_api))
		{
			$html .= "<td  colspan=2 style='text-align:right; background-color: #EDEFF4;-webkit-border-radius: 5px;'>";
			//$html .= "<div class='POS Boton' onClick=''  >Cancelar</div>";

			if (($this->hide_not_obligatory))
			{
				$html .= "<div align='right' class='POS Boton' onClick='Ext.get(Ext.query(\".hideable\")).show()' >Mas opciones</div>";
			}
			//this.onClick=null;
			$html .= "<div style='margin-right:0px' class='POS Boton OK' onClick='" . $this->guiComponentId . "getParams()'  >Aceptar</div>";
			$html .= "</td></tr>";
		}
		
		
		//Ext.query(".hideable")
		
		//		if( $this->is_editable === false ){
		//			$html .= "<script>var is_editable_now = false; function make_editable(  ){ ";
		//			
		//			$html .= " }</script>";
		//			$html .= "<td></td></tr>";
		//			$html .= "<tr><td colspan='4'>";
		//			$html .= "<div class='POS Boton'>Editar</div>";
		//			$html .="</td></tr>";
		//		
		//		}
		
		$html .= "</form></table>";
		return $html;
	}

	/**
	 *
	 *
	 * */
	public function addSubmit($caption, $submit_form_url = "", $method = "POST") {
		$this->submit_form = array(
			"caption" => $caption,
			"submit_form_url" => $submit_form_url,
			"method" => $method
		);
	}

	/**
	 *
	 *
	 * */
	public function addOnClick($caption, $js_function)
	{
		$this->on_click = array(
			"caption" => $caption,
			"function" => $js_function
		);
	}

	/**
	 *
	 *
	 * */
	public function addApiCall($method_name, $http_method = "POST") {
		if (!($http_method === "POST" || $http_method === "GET")) {
			throw new Exception("Http method must be POST or GET");
		}

		$this->send_to_api             = $method_name;
		$this->send_to_api_http_method = $http_method;
	}

	/**
	 * Esta es una funcion en js que se llamara 
	 * cuando la llamada al api sea exitosa.
	 *
	 * */
	public function onApiCallSuccess($jscallback) {
		$this->send_to_api_callback = $jscallback;
	}

	/**
	 * 
	 * Redirect to a new page on apicall sucess
	 * 
	 * */
	public function onApiCallSuccessRedirect($url, $send_param = null) {
		$this->send_to_api_redirect = $url;
	}

	/**
	 *
	 *
	 * */
	public function renameField($field_array) {
		$found = false;
		foreach ($field_array as $old_name => $new_name)
		{
			$found = false;
			$sof   = sizeof($this->form_fields);
			
			for ($i = 0; $i < $sof; $i++)
			{
				if ($this->form_fields[$i]->id === $old_name)
				{
					$this->form_fields[$i]->id      = $new_name;
					$this->form_fields[$i]->caption = ucwords(str_replace("_", " ", $new_name));
					$found                          = true;
					//no break since there could be plenty of same id's
				} //if
				
			} //for
			
			if ($found === false)
				throw new Exception("Field `" . $old_name . "` not found in the VO object.");
			
		} //foreach field in the array
	}

	/**
	 *
	 * @param array or string
	 *
	 **/
	public function makeObligatory($field_array) {
		if (!is_array($field_array))
		{
			$field_array = array(
				$field_array
			);
		}
		
		foreach ($field_array as $field)
		{
			$sof = sizeof($this->form_fields);
			
			for ($i = 0; $i < $sof; $i++)
			{
				if ($this->form_fields[$i]->id === $field)
				{
					$this->form_fields[$i]->obligatory = true;
				} //if
				
			} //for
		}
	}

	/**
	 *
	 *
	 * */
	public function createRelation( $fkColumn, $pkOtherTable ){
	}

	public function createComboBoxJoin($field_name, $field_name_in_values, $values_array, $selected_value = null) {
		if (sizeof($values_array) == 0)
		{
			//do something
		}
		
		$sof = sizeof($this->form_fields);
		
		for ($i = 0; $i < $sof; $i++)
		{
			if ($this->form_fields[$i]->id === $field_name)
			{
				$this->form_fields[$i]->type = "combo";
				
				$end_values = array();
				
				foreach ($values_array as $v)
				{
					if (!($v instanceof VO))
					{
						if (is_array($v))
						{
							if ($selected_value == $v["id"])
							{
								array_push($end_values, array(
									"id" => $v["id"],
									"caption" => $v["caption"],
									"selected" => true
								));
							}
							else
							{
								array_push($end_values, array(
									"id" => $v["id"],
									"caption" => $v["caption"],
									"selected" => false
								));
							}
						}
						else
						{
							if ($selected_value == $v)
							{
								array_push($end_values, array(
									"id" => $v,
									"caption" => $v,
									"selected" => true
								));
							}
							else
							{
								array_push($end_values, array(
									"id" => $v,
									"caption" => $v,
									"selected" => false
								));
							}
						}
						
					}
					else
					{
						$v = $v->asArray();

						if ($selected_value == $v["$field_name"])
						{
							array_push($end_values, array(
								"id" => $v["$field_name"],
								"caption" => $v["$field_name_in_values"],
								"selected" => true
							));
						}
						else
						{
							array_push($end_values, array(
								"id" => $v["$field_name"],
								"caption" => $v["$field_name_in_values"],
								"selected" => false
							));
						}
					}
				}
				
				$this->form_fields[$i]->value = $end_values;
				
				break;
			} //if
		} //for
		
	}
	
	
	
	/**
	 *
	 *
	 * */
	public function createComboBoxJoinDistintName($field_name, $table_name, $field_name_in_values, $values_array, $selected_value = null) {
		if (sizeof($values_array) == 0)
		{
			//do something
		}
		
		$sof = sizeof($this->form_fields);
		
		for ($i = 0; $i < $sof; $i++)
		{
			if ($this->form_fields[$i]->id === $field_name)
			{
				$this->form_fields[$i]->type = "combo";
				
				$end_values = array();
				
				foreach ($values_array as $v)
				{
					$v = $v->asArray();
					if ($selected_value == $v["$table_name"])
						array_push($end_values, array(
							"id" => $v["$table_name"],
							"caption" => $v["$field_name_in_values"],
							"selected" => true
						));
					else
						array_push($end_values, array(
							"id" => $v["$table_name"],
							"caption" => $v["$field_name_in_values"],
							"selected" => false
						));
					
				}
				
				$this->form_fields[$i]->value = $end_values;
				
				break;
			} //if
		} //for
		
	}
	
	
	/**
	 *
	 *
	 * */
	public function createListBoxJoin($field_name, $field_name_in_values, $values_array) {
		if (sizeof($values_array) == 0)
		{
			//do something
		}
		
		$sof = sizeof($this->form_fields);
		
		for ($i = 0; $i < $sof; $i++)
		{
			if ($this->form_fields[$i]->id === $field_name)
			{
				$this->form_fields[$i]->type = "listbox";
				
				$end_values = array();
				
				foreach ($values_array as $v)
				{
					$v = $v->asArray();
					array_push($end_values, array(
						"id" => $v["$field_name"],
						"caption" => $v["$field_name_in_values"]
					));
					
				}
				
				$this->form_fields[$i]->value = $end_values;
				
				break;
			} //if
		} //for
		
	}


	/**
	 *
	 *
	 * */
	public function createComboBox($field_name, $values) {
	}

	/**
	 *
	 *
	 * */
	public function setValueField($field_name, $value) {
		$sof = sizeof($this->form_fields);
		
		for ($i = 0; $i < $sof; $i++)
		{
			if ($this->form_fields[$i]->id === $field_name)
			{
				$this->form_fields[$i]->value = $value;
				break;
			}
			
		}
		
		if ($i > $sof)
		{
			throw new Exception("Nombre " . $field_name . " no encontrado en los elementos");
		}
	}

    /**
     *
     *  
     */
    public function setType($id, $type) {

        foreach($this->form_fields as $field ) {
            if($field->id == $id) {
                $field->type = $type;
				return;
            }
        }
           
		throw new Exception("$id not found in form");
	}

	/**
     *
     *  
     */
    public function setPlaceholder($id, $phText) {

        foreach($this->form_fields as $field ){
            if($field->id == $id) {
                $field->placeholder = $phText;
				return;
            }
        }
           
		throw new Exception("$id not found in form");
	}

	/**
     *
     *  
     */
    public function setCaption( $id, $phText ) {

        foreach($this->form_fields as $field ){
            if($field->id == $id) {
                $field->caption = $phText;
				return;
            }
        }
           
		throw new Exception("$id not found in form");
	}

	public function setHelp($id, $phText) {

        foreach($this->form_fields as $field ) {
            if($field->id == $id) {
                $field->help = $phText;
				return;
            }
        }
		throw new Exception("$id not found in form");
	}
}




class FormComponentField
{
	public $id;
	public $caption;
	public $type;
	public $value;
	public $name;
	public $obligatory;
	public $send_as_hidden;
	public $hidden;
	public $placeholder;
	public $help;

	public function __construct
	(
		$id, 
		$caption, 
		$type, 
		$value 			= "", 
		$name			= null, 
		$obligatory 	= false, 
		$hidden 		= false, 
		$send_as_hidden = false,
		$planceholder	= null
	)
	{
		$this->id             = $id;
		$this->id = str_replace ( "-" , "_" , $this->id );
		
		$this->caption        = $caption;
		$this->type           = $type;
		$this->value          = $value;
		$this->name           = $name;
		$this->obligatory     = $obligatory;
		$this->hidden         = $hidden;
		$this->send_as_hidden = $send_as_hidden;
		$this->placeholder	  = $planceholder;
		$this->help	 	 		= "";
	}
	
	
	public static function obligatorySort($f1, $f2)
	{
		if ($f1->obligatory == $f2->obligatory)
		{
			return 0;
		}
		
		if ($f1->obligatory)
			return -1;
		
		return 1;
	}
	
	
	public static function idSort($f1, $f2)
	{
		if ($f1->id == $f2->id)
		{
			return 0;
		}
		
		return strcmp($f1->id, $f2->id);
	}
	
} //FormComponentField
