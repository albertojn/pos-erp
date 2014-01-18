package mx.caffeina.pos.AdminPAQProxy;

import java.io.*;
import com.linuxense.javadbf.*;
import java.util.ArrayList;
import mx.caffeina.pos.*;
import mx.caffeina.pos.MD5Checksum;
import java.util.*;
import java.text.DateFormat;
import java.net.URLEncoder;
import java.net.URLDecoder;



public class AdminPAQProxy extends HttpResponder{

	private String ruta;
	private DBFReader reader;
	private FileInputStream inputStream;
	private boolean explorer;
	private String sql;
	private String last_error;


	public AdminPAQProxy(String [] path, String [] query){
		super(path, query);
		this.ruta = null;
		last_error = null;
	}


    /**
    * Despachador
    */
    public String getResponse(){
        //dispatch submodules

        if(( path.length > 2 )  && path[2].equals("dbdiff")){
            
            System.out.println("dbdiff nigga");
            
            bootstrapJson();
            

            
            if(searchInQuery("queryDB") != null){
                DBDiff dbdiff = new DBDiff(searchInQuery("path"));
                return  dbdiff.queryDB();
                
            } else{
                return DBDiff.renderFrontEnd();
                
            }

        }



        if(( path.length > 2 )  && path[2].equals("sdk")){
            
            System.out.println("sdk nigga");
            return sdk();

        }

        if(( path.length > 2 )  && path[2].equals("ping")){
            
            System.out.println("-- ping --");
            if(searchInQuery("callback") != null){
                return (searchInQuery("callback") + "(" + ping() + ");");

            }else{
                return ping() ;

            }

        }

        if((path.length > 2 ) && path[2].equals("updateCteProv")){
            System.out.println("-- updateCteProv --");
            if(searchInQuery("callback") !=null){
                return (searchInQuery("callback") + "(" + updateCteProv() + ");");
            }else{
                return updateCteProv();
            }
        }


        if(( path.length > 2 )  && path[2].equals("loadClientes")){
            
            System.out.println("-- loadClientes --");
            if(searchInQuery("callback") != null){
                return (searchInQuery("callback") + "(" + loadCteProv() + ");");
            }else{
                return loadCteProv() ;
            }

        }


        if(( path.length > 2 )  && path[2].equals("loadProveedores")){
            
            System.out.println("-- loadProveedores --");
            if(searchInQuery("callback") != null){
                return (searchInQuery("callback") + "(" + loadProveedores() + ");");
            }else{
                return loadProveedores();
            }

        }


        if(( path.length > 2 )  && path[2].equals("loadProductos")){
            
            System.out.println("-- loadProductos --");
            if(searchInQuery("callback") != null){
                return (searchInQuery("callback") + "(" + loadProductos() + ");");
            }else{
                return loadProductos() ;
            }

        }

        if(( path.length > 2 )  && path[2].equals("nuevoCteProv")){
            
            System.out.println("-- nuevo CteProv --");
            if(searchInQuery("callback") != null){
                return (searchInQuery("callback") + "(" + nuevoCteProv() + ");");
            }else{
                return nuevoCteProv() ;
            }

        }

        if(( path.length > 2 )  && path[2].equals("nuevaCompraVenta")){
            
            System.out.println("-- nueva Compra Venta --");
            if(searchInQuery("callback") != null){
                return (searchInQuery("callback") + "(" + nuevaCompraVenta() + ");");
            }else{
                return nuevaCompraVenta() ;
            }

        }


        if(dataType.equals("json")) {

            bootstrapJson();

            if(searchInQuery("callback") != null){
                return (searchInQuery("callback") + "(" + getJson() + ");");

            }else{
                return getJson() ;

            }
            
        }

        bootstrapHtml();
        return getHtml();
    }


    private String sdk(){   

        //System.out.println("--- 1 ---");  

        // https://127.0.0.1:16001/json/adminpaq/sdk/?param=1
        // String s = searchInQuery("param") ; // s = "1";

        //------DATOS OBLIGATORIOS
        String params = "";
        String numEmpresa = searchInQuery("numEmpresa");
        String path = searchInQuery("path");
        String accion = searchInQuery("accion");
        String numDatos = searchInQuery("numDatos");
        Calendar c = new GregorianCalendar();
        String fechaActual = (c.get(Calendar.MONTH) >= 9 ? "" + (c.get(Calendar.MONTH) + 1) : "0" + (c.get(Calendar.MONTH) + 1)) + "/" + (c.get(Calendar.DATE) >= 10 ? "" + c.get(Calendar.DATE) : "0" + c.get(Calendar.DATE)) + "/" + Integer.toString(c.get(Calendar.YEAR));
        String fechaActual2 = (c.get(Calendar.DATE) >= 10 ? "" + c.get(Calendar.DATE) : "0" + c.get(Calendar.DATE)) + "/" + (c.get(Calendar.MONTH) >= 9 ? "" + (c.get(Calendar.MONTH) + 1) : "0" + (c.get(Calendar.MONTH) + 1)) + "/" + Integer.toString(c.get(Calendar.YEAR));

        String r = "";
        
        //System.out.println("--- 2 ---");

        if(path == null){
            r = "{\"success\" : false, \"reason\":\"indique la ubicacion del recurso\"}"; 
            System.out.println(r);
            return r; 
        }

        if(numEmpresa == null){            
            r = "{\"success\" : false, \"reason\":\"falta numero de empresa\"}"; 
            System.out.println(r);
            return r;
        }

        //System.out.println("--- 3 ---");

        if(numDatos == null){
            r = "{\"success\" : false, \"reason\":\"falta indicar el numero de movimientos a realizar.\"}";
            System.out.println(r);
            return r;
        }

        //System.out.println("--- 4 ---");


        int a = 0;

        try{

            a = Integer.parseInt(accion);

        }catch(NumberFormatException e){
            r = "{\"success\" : false, \"reason\":\"Indique el numero de movimientos a realizar, mas informacion - " + e.getMessage().replace("\"", "'") + " \"}";
            System.out.println(r);
            return r;
        }

        //System.out.println("--- 5 ---");

        switch(a){
            //alta de un cliente 
            case 1 :                                          
                String codigo_cliente = searchInQuery("codCteProv"); //2 OK

                if(codigo_cliente == null){
                    r = "{\"success\" : false, \"reason\":\"falta indicar el codigo de cliente.\"}"; 
                    System.out.println(r);
                    return r;
                }

                String razon_social = searchInQuery("razonSocial");; //3 OK

                if(razon_social == null){
                    r = "{\"success\" : false, \"reason\":\"falta indicar la razon social.\"}"; 
                    System.out.println(r);
                    return r;
                }

                String rfc = searchInQuery("rfc");//4 OK

                if(rfc == null){
                    r = "{\"success\" : false, \"reason\":\"falta indicar el RFC.\"}"; 
                    System.out.println(r);
                    return r;
                }

                String curp = searchInQuery("curp");;//5

                if(curp == null){
                    razon_social = "";
                }    

                String denominacion_comercial = searchInQuery("denCom");//6

                if(denominacion_comercial == null){
                    denominacion_comercial = "";
                } 

                String representante_legal = searchInQuery("repLegal");//7

                if(representante_legal == null){
                    representante_legal = "";
                } 

                String venta_credito = searchInQuery("ventaCredito");//8

                if(venta_credito == null){
                    venta_credito = "";
                }

                String tipo_cliente = searchInQuery("tipo");//9

                if(tipo_cliente == null){
                    r = "{\"success\" : false, \"reason\":\"falta indicar el tipo de CteProv.\"}"; 
                    System.out.println(r);
                    return r;
                }

                try{

                    a = Integer.parseInt(tipo_cliente);

                }catch(NumberFormatException e){
                    r = "{\"success\" : false, \"reason\":\"El tipo de CteProv debe de ser un valor entero - " + e.getMessage().replace("\"", "'") + " \"}";
                    System.out.println(r);
                    return r;
                }
                System.out.println("-->" + a + "<--");
                switch(a){
                    case 1: //cliente
                    break;
                    case 2: //cliente-proveedor
                    break;
                    case 3: //proveedor
                    break;
                    default :
                        r = "{\"success\" : false, \"reason\":\"Tipo CteProv invalido\"}";
                        System.out.println(r);
                        return r; 
                }

                String estatus = searchInQuery("status");//10

                if(estatus == null){
                    r = "{\"success\" : false, \"reason\":\"falta indicar el estatus del CteProv.\"}"; 
                    System.out.println(r);
                    return r;
                }

                String limite_credito = searchInQuery("limiteCredito");//11

                if(limite_credito == null){
                     limite_credito = "0";
                }

                String fecha_alta = fechaActual2;//12
                
                params = path + " " + numEmpresa + " " + codigo_cliente + " " + razon_social + " " + rfc + " " + curp + " " + denominacion_comercial + " " + representante_legal + " " + venta_credito + " " + tipo_cliente + " " + estatus + " " + limite_credito + " " + fecha_alta;
            
                break;

            case 2 :               
                String serieDocumento = searchInQuery("serieDocumento");

                if(serieDocumento == null){
                    r = "{\"success\" : false, \"reason\":\"falta indicar la serie del documento.\"}"; 
                    System.out.println(r);
                    return r;
                }

                String fechaDocumento = fechaActual; //mm/dd/aaaa                

                String codCteProv = searchInQuery("codCteProv");

                if(codCteProv == null){
                    r = "{\"success\" : false, \"reason\":\"falta indicar el codigo del CteProv.\"}";
                    System.out.println(r);
                    return r; 
                }

                String codProdSer = searchInQuery("codProdSer");

                if(codProdSer == null){
                    r = "{\"success\" : false, \"reason\":\"falta indicar el codigo del ProdSer.\"}"; 
                    System.out.println(r);
                    return r;
                }

                String codAlmacen = searchInQuery("docAlmacen");

                if(codAlmacen == null){
                    r = "{\"success\" : false, \"reason\":\"falta indicar el codigo del Almacen.\"}"; 
                    System.out.println(r);
                    return r;
                }

                String numUnidades = searchInQuery("numUnidades");
        
                if(numUnidades == null){
                    r = "{\"success\" : false, \"reason\":\"falta indicar el numero de unidades.\"}"; 
                    System.out.println(r);
                    return r;
                }

                String precioUnitario = searchInQuery("precioUnitario");

                if(precioUnitario == null){
                    r = "{\"success\" : false, \"reason\":\"falta indicar el precio unitario.\"}"; 
                    System.out.println(r);
                    return r;
                }

                String codConcepto = searchInQuery("codConcepto"); ////(Tabla MGW10006) 5 Factura de contado, 4 Factura a credito, 21 Compra a Proveedor 

                if(codConcepto == null){
                    r = "{\"success\" : false, \"reason\":\"falta indicar el codigo del concepto.\"}"; 
                    System.out.println(r);
                    return r;
                }

                try{

                    a = Integer.parseInt(codConcepto);

                }catch(NumberFormatException e){
                    r = "{\"success\" : false, \"reason\":\"El codigo de concepto debe de ser un valor entero - " + e.getMessage().replace("\"", "'") + " \"}";
                    System.out.println(r);
                    return r;
                }

                switch(a){
                    case 4: //factura a credito
                    break;
                    case 5: //factura de contado
                    break;
                    case 21: //compra a proveedor
                    break;
                    default :
                        r = "{\"success\" : false, \"reason\":\"Codigo de concepto invalido\"}";
                        System.out.println(r);
                        return r; 
                }

                params = path + " " + numEmpresa + " " + serieDocumento + " " + fechaDocumento + " " + codCteProv + " " + codProdSer + " " + codAlmacen + " " + numUnidades + " " + precioUnitario + " " + codConcepto;

                break;   

                default :    

                r = "{\"success\" : false, \"reason\":\"Accion desconocida.\"}";
                System.out.println(r);
                return r;                              
        }

        //System.out.println("--- 6aa ---");

        TestRuntime test = new TestRuntime(params);

        //System.out.println("--- 7 ---");

        //System.out.println(s);

        r = "{\"success\" : " + test.success + ", \"code\" : " + test.code + ", \"reason\":\"" + test.reason + "\"}"; 
        System.out.println(r);

        //System.out.println("--- 8 ---");

        return r;
        
    }


    /**
    * Prueba la conexion entre la aplicacion web y el server
    */
    private String ping(){  

        String params = "";
        String numEmpresa = searchInQuery("numEmpresa");
        String path = searchInQuery("path");
        String r = "";
        String reason = "";
        
        if(path == null){
            r = "{\"success\" : false, \"reason\":\"indique el path del programa de conexion\"}";
            System.out.println(r);
            return r;
        }
        
        if(numEmpresa == null){
            r = "{\"success\" : false, \"reason\":\"falta numero de empresa\"}";
            System.out.println(r);
            return r;
        }

        //System.out.println("SOLOOOOOOOOOOOOO : " + path);       
        //System.out.println("SOLIIIIIIIIIIIII : " + URLDecoder.decode(path));       

        params = URLDecoder.decode(path) + "\\Test_Conexion_SDK\\InitTestConnnectionSDK.exe " + numEmpresa ;
        //path = "C:/Documents and Settings/Manuel/Desktop/Compartida/CONNECTION_SDK/Test_Conexion_SDK/InitTestConnnectionSDK.exe";        

        //params = path + " " + numEmpresa ;
        
        //C:\Documents and Settings\Manuel\Desktop\Compartida\CONNECTION_SDK\Test_Conexion_SDK\InitTestConnnectionSDK.exe

        TestRuntime test = new TestRuntime(params);     
        
        //reason = test.reason;

        System.out.println("===========================================");
        System.out.println("LA EMPRESA ES: " + test.reason);
        System.out.println("===========================================");
        //-------------------------
        if (test.success == true){

            //String[] arrayResponse = test.reason.split(" ");
            try{
                //reason = arrayResponse[1];
                /*
                for (int i = 1; i < arrayResponse.length; i++) {
                    reason += arrayResponse[i] + " ";
                }*/
                reason = test.reason.substring(4);
            }catch(Exception e){
                r = "{\"success\" : false, \"reason\":\"Respuesta inesperada -> " + e.getMessage().replace("\"", "'") + "\"}";
                System.out.println(r);
                return r;
            }
        }
        //------------------------
                //Comprueba si existe una lista de esa empresa
        boolean existeLista = (new File("C:\\Caffeina\\Files\\CteProv_" + numEmpresa + ".txt").exists());
        System.out.println("Archivo de lista de clientes: " + existeLista);

        r = "{\"success\" : " + test.success + ", \"code\" : " + test.code + ", \"reason\":\"" + reason + "\",\"existeLista\":" + existeLista + "}"; 
        System.out.println(r);
        if(!existeLista){
            //Si no existe la lista, crea automaticamente el archivo
            params = URLDecoder.decode(path) + "\\Lista_Clientes_SDK\\InitListaClientes.EXE " + numEmpresa + " " + "1500"; 
            
            System.out.println("Llamando a WriteClientes con los parametros : " + params);
            WriteClientes clientes = new WriteClientes(params);
        }

        return r;

    }

    /*
    * Actualiza la lista de clientes (el archivo CteProv_X.txt)
    */
    private String updateCteProv(){
        String params = "";
        String numEmpresa = searchInQuery("numEmpresa");
        String path = searchInQuery("path");
        String r ="";

        params = URLDecoder.decode(path) + "\\Lista_Clientes_SDK\\InitListaClientes.EXE " + numEmpresa + " " + "1500"; 
        
        System.out.println("Llamando a WriteClientes con los parametros : " + params);

        WriteClientes clientes = new WriteClientes(params);
        r = "{\"success\" : " + clientes.success + ", \"code\" : \"" + clientes.code + "\", \"reason\":\"" + clientes.reason + "\"}"; 
        return r;
    }


    /**
    * Lee los clientes y proveedores del server
    */
    private String loadCteProv(){  

        String params = "";
        String numEmpresa = searchInQuery("numEmpresa");
        //String numEmpresa = "1";
        //String path = "C:/Documents and Settings/Manuel/Desktop/Compartida/CONNECTION_SDK/Lista_Clientes_SDK/InitListaClientes.EXE"/*searchInQuery("path")*/;

        String path = searchInQuery("path") + "/Lista_Clientes_SDK/InitListaClientes.EXE";
        params = path + " " + numEmpresa + " " + "1500";

        System.out.println("Estoy en loadCteProv : se enviara como parametros : " + params);

        LoadClientes clientes = new LoadClientes(params);


        //String r = "{\"totalCount\":1, \"datos\":[{\"CRAZONSO01\":\"Juan Manuel Garcia\",\"CIDCLIEN01\":\"CLI0099\",\"CCODIGO01\":\"CLI0099\",\"CFECHAALTA\":\"12/12/2012\",\"CRFC\":\"GACJ121212123\",\"CCURP\":\"\",\"CDENCOME01\":\"PCSYSTEMS\",\"CREPLEGAL\":\"JUAN CARLOS\"}]}";
        //String r = "{\"totalCount\":" + clientes.totalCount + ", \"datos\":" + clientes.usuariosJSON + "}";
        String r = "{\"totalCount\":" + clientes.totalCount + ", \"finish\" : " + clientes.finish + ", \"datos\":" + clientes.usuariosJSON + "}";
        //System.out.println(r); 
        return r;

    }

    /**
    * Lee los proveedores del server
    */
    private String loadProveedores(){  


        String params = "";
        String numEmpresa = searchInQuery("numEmpresa");
        //String path = "C:/Documents and Settings/Administrador/Escritorio/CONNECTION_SDK/Lista_Proveedores_SDK/InitListaClientes.EXE"/*searchInQuery("path")*/;
        String path = searchInQuery("path") + "/Lista_Clientes_SDK/InitListaClientes.EXE";

        params = path + " " + numEmpresa;

        LoadProveedores proveedores = new LoadProveedores(params);


        //String r = "{\"totalCount\":1, \"datos\":[{\"CRAZONSO01\":\"Juan Manuel Garcia\",\"CIDCLIEN01\":\"CLI0099\",\"CCODIGO01\":\"CLI0099\",\"CFECHAALTA\":\"12/12/2012\",\"CRFC\":\"GACJ121212123\",\"CCURP\":\"\",\"CDENCOME01\":\"PCSYSTEMS\",\"CREPLEGAL\":\"JUAN CARLOS\"}]}";
        String r = "{\"totalCount\":" + proveedores.totalCount + ", \"datos\":" + proveedores.usuariosJSON + "}";
        System.out.println(r); 
        return r;

    }


    private String loadProductos(){  
        

        String params = "";
        String numEmpresa = searchInQuery("numEmpresa");
        //String path = "C:/Documents and Settings/Administrador/Escritorio/CONNECTION_SDK/Lista_Proveedores_SDK/InitListaClientes.EXE"/*searchInQuery("path")*/;
        String path = searchInQuery("path") + "/Lista_Productos_SDK/InitListaProductosSDK.EXE";

        params = path + " " + numEmpresa;

        System.out.println("ENVIANDO : " + params);

        LoadProductos productos = new LoadProductos(params);

        //String r = "{\"totalCount\":2, \"datos\":[{\"Codigo\":\"Prod001\",\"Nombre\":\"Pagina Web\", \"Precio1\": \"1200\"}, {\"Codigo\":\"Prod002\",\"Nombre\":\"Software a la medida\", \"Precio1\": \"5000\"}]}";
        String r = "{\"totalCount\":" + productos.totalCount + ", \"datos\":" + productos.productosJSON + "}";
        //System.out.println(r); 
        return r;

    }


	private String nuevoCteProv(){

        String params = "";
        String numEmpresa = searchInQuery("numEmpresa");
        //String path = "C:/Documents and Settings/Administrador/Escritorio/CONNECTION_SDK/Lista_Proveedores_SDK/InitListaClientes.EXE"/*searchInQuery("path")*/;
        String path = searchInQuery("path") + "/Nuevo_Cliente_Proveedor_SDK/InitNuevoClienteProveedor.EXE";

        params = path + " " + numEmpresa + " " + searchInQuery("codigo_cliente") + " \"" + searchInQuery("razon_social") + "\" " + searchInQuery("rfc");

        System.out.println("ENVIANDO : " + params);

        TestRuntime CteProv = new TestRuntime(params);


        //String r = "{\"totalCount\":1, \"datos\":[{\"CRAZONSO01\":\"Juan Manuel Garcia\",\"CIDCLIEN01\":\"CLI0099\",\"CCODIGO01\":\"CLI0099\",\"CFECHAALTA\":\"12/12/2012\",\"CRFC\":\"GACJ121212123\",\"CCURP\":\"\",\"CDENCOME01\":\"PCSYSTEMS\",\"CREPLEGAL\":\"JUAN CARLOS\"}]}";
        String r = "{\"success\" : " + CteProv.success + ", \"code\" : " + CteProv.code + ", \"reason\":\"" + CteProv.reason + "\"}"; 
        System.out.println(r);

        return r;

    }

    private String nuevaCompraVenta(){

        Calendar c = new GregorianCalendar();
        String fechaActual = (c.get(Calendar.MONTH) >= 9 ? "" + (c.get(Calendar.MONTH) + 1) : "0" + (c.get(Calendar.MONTH) + 1)) + "/" + (c.get(Calendar.DATE) >= 10 ? "" + c.get(Calendar.DATE) : "0" + c.get(Calendar.DATE)) + "/" + Integer.toString(c.get(Calendar.YEAR));

        String params = "";        
        //String path = "C:/Documents and Settings/Administrador/Escritorio/CONNECTION_SDK/Lista_Proveedores_SDK/InitListaClientes.EXE"/*searchInQuery("path")*/;
        String path = searchInQuery("path") + "/Nueva_Compra_Venta_SDK/InitCompraVenta.EXE";

        params = path + " " + searchInQuery("numEmpresa") + " " + searchInQuery("folio_documento") + " " + fechaActual + " " + searchInQuery("codigo_cliente_proveedor") + " " + searchInQuery("codigo_producto_servicio") + " " + searchInQuery("codigo_almacen") + " " + searchInQuery("numero_unidades") + " " + searchInQuery("precio_unitario") + " " + searchInQuery("codigo_concepto") + " " + searchInQuery("serie_documento");
        
        /*
         * 1) Numero de empresa
         * 2) Folio del documento
         * 3) Fecha actual
         * 4) Codigo cliente-proveedor
         * 5) Codigo de producto-servicio
         * 6) Codigo de almacen
         * 7) Numero de unidades
         * 8) Precio unitario
         * 9) Codigo del concepto
         *10) Serie del documento
        */
        System.out.println("ENVIANDO : " + params);

        TestRuntime CompraVenta = new TestRuntime(params);


        //String r = "{\"totalCount\":1, \"datos\":[{\"CRAZONSO01\":\"Juan Manuel Garcia\",\"CIDCLIEN01\":\"CLI0099\",\"CCODIGO01\":\"CLI0099\",\"CFECHAALTA\":\"12/12/2012\",\"CRFC\":\"GACJ121212123\",\"CCURP\":\"\",\"CDENCOME01\":\"PCSYSTEMS\",\"CREPLEGAL\":\"JUAN CARLOS\"}]}";
        String r = "{\"success\" : " + CompraVenta.success + ", \"code\" : " + CompraVenta.code + ", \"reason\":\"" + CompraVenta.reason + "\"}"; 
        System.out.println(r);

        return r;

    }




class TestRuntime {

    public String code = "";
    public Boolean success = false;
    public String reason = "";

    /**
     * Creates a new instance of PruebaRuntime
     */
    public TestRuntime(String params) {

        

        System.out.println("Se ejecutara : " + params);

        try {
            // Se lanza el ejecutable. 
            Process p = Runtime.getRuntime().exec(params);

            // Se obtiene el stream de salida del programa 
            InputStream is = p.getInputStream();

            /*
             * Se prepara un bufferedReader para poder leer la salida más
             * comodamente.
             */
            BufferedReader br = new BufferedReader(new InputStreamReader(is));

            //System.out.println("--- 6.1 ---");

            // Se lee la primera linea 
            String aux = br.readLine();
            System.out.println("EXE : " + aux);

            //System.out.println("--- 6.2 ---");

            // Mientras se haya leido alguna linea 
            /*while (aux != null) {
                // Se escribe la linea en pantalla 
                System.out.println(aux);

                // y se lee la siguiente. 
                aux = br.readLine();
            }*/

            if(aux == null){
                this.success = false;
                this.reason = "Error Fatal en la ejecución del programa";
                this.code = "200";
            }

            //System.out.println("--- 6.3 ---");

            StringTokenizer tokens = new StringTokenizer(aux);

            Boolean param = true;
            String token = "";
            while(tokens.hasMoreTokens()){
            
                token = tokens.nextToken();
                
                if(param == true){                                           
                    
                    this.code = new String(token);

                    //System.out.println("-->" + token + "<--");
                    
                    if(token.equals("100")){   
                        //System.out.println("-->ENTRO<--");                 
                        this.success = true;
                        //this.reason = "Ok";
                        //break;
                    }else{
                        //System.out.println("-->NO ENTRO<--");        
                        this.success = false;   
                        token = "Error " + token + ",";;
                    }                
                }

                this.reason += (token + " ");

                param = false;         
                
            }

            //System.out.println("--- 6.4 ---");            

            //------------------------------------------

            /*File archivo = new File("C:\\sdk_adminpaq\\cteprov");
            FileReader fr = new FileReader(archivo);
            br = new BufferedReader(fr);
            
            String linea = br.readLine();
            
            System.out.println(linea);*/

            //------------------------------------------


        } catch (Exception e) {
            // Excepciones si hay algún problema al arrancar el ejecutable o al leer su salida.*/
            //e.printStackTrace();
            this.success = false;
            this.code = "300";
            this.reason = "Error : " + e.getMessage().replace("\"", "'");
        }
    }

    TestRuntime() {
        throw new UnsupportedOperationException("Not yet implemented");
    }
    
}


class LoadClientes {

    public String code = "";
    public Boolean success = false;
    public String reason = "";
    public ArrayList usuarios;
    public String usuariosJSON = "[]"; 
    public int totalCount = 0;
    public Boolean finish = false;

    /**
     * Creates a new instance of PruebaRuntime
     */
    public LoadClientes(String params) {

        System.out.println("Estoy en LoadClientes");

        int start = Integer.parseInt(searchInQuery("start"));
        int limit = Integer.parseInt(searchInQuery("limit"));
        int numEmpresa = Integer.parseInt(searchInQuery("numEmpresa"));

          File archivo = null;
          FileReader fr = null;
          BufferedReader br = null;

          try {
             // Apertura del fichero y creacion de BufferedReader para poder
             // hacer una lectura comoda (disponer del metodo readLine()).

            System.out.println("Abriendo archivo: C:\\Caffeina\\Files\\CteProv_" + numEmpresa + ".txt");

             archivo = new File ("C:\\Caffeina\\Files\\CteProv_" + numEmpresa + ".txt");
             fr = new FileReader (archivo);
             br = new BufferedReader(fr);

             // Lectura del fichero
             String linea = "";

             String buffer = "";
//LoadClientes
             int pointer = 0;
             int cont = 0;

             while((linea=br.readLine())!=null){

                if(pointer > limit){
                    break;
                }

                if( pointer >= start && pointer <= limit){
                    buffer += (linea + ", ");
                    cont++;
                }

                pointer++;

             }

             if( linea == null ){
                this.finish = true;
             }

             this.usuariosJSON = "[" + buffer.substring(0, (buffer.length() - 2) ) + "]";

             this.totalCount = cont;
                
          }
          catch(Exception e){
             e.printStackTrace();
          }finally{
             // En el finally cerramos el fichero, para asegurarnos
             // que se cierra tanto si todo va bien como si salta 
             // una excepcion.
             try{                    
                if( null != fr ){   
                   fr.close();     
                }                  
             }catch (Exception e2){ 
                e2.printStackTrace();
             }
          }
        
    }

    LoadClientes() {
        throw new UnsupportedOperationException("Not yet implemented");
    }
    
}

class WriteClientes {   

    public String code = "";
    public Boolean success = false;
    public String reason = "";

    /**
     * Creates a new instance of PruebaRuntime
     */
    public WriteClientes(String params) {

        System.out.println("En constructor de WriteClientes");        

        try {
            // Se lanza el ejecutable. 
            Process p = Runtime.getRuntime().exec(params);

            // Se obtiene el stream de salida del programa 
            InputStream is = p.getInputStream();

            /*
             * Se prepara un bufferedReader para poder leer la salida más
             * comodamente.
             */
            BufferedReader br = new BufferedReader(new InputStreamReader(is));

            System.out.println("--- 6.1 ---");

            // Se lee la primera linea 
            String aux = br.readLine();
            System.out.println("--- 6.2 ---");

            // Mientras se haya leido alguna linea 

            FileWriter fichero = null;
            PrintWriter pw = null;
            try
            {
                System.out.println("Creando nuevo fichero C:\\Caffeina\\Files\\CteProv_" + searchInQuery("numEmpresa") + ".txt");               
                fichero = new FileWriter("C:\\Caffeina\\Files\\CteProv_" + searchInQuery("numEmpresa") + ".txt");
                pw = new PrintWriter(fichero);

                //System.out.println("aux = " + aux);
            System.out.println("--- 6.3 ---");
                while (aux != null) {
                    //System.out.println("aux = " + aux);
                    pw.println(aux);
                    aux = br.readLine();
                }                    
            System.out.println("--- 6.4 ---");
                if(new File("C:\\Caffeina\\Files\\CteProv_" + searchInQuery("numEmpresa") + ".txt").exists()){
                    this.code="100";
                    this.success=true;
                    this.reason="OK";
                }
            } catch (Exception e) {
                e.printStackTrace();
            } finally {
                try {
                // Nuevamente aprovechamos el finally para 
                // asegurarnos que se cierra el fichero.
                if (null != fichero)
                    fichero.close();
                } catch (Exception e2) {
                   e2.printStackTrace();
                }
            }                            

            //------------------------------------------


        } catch (Exception e) {
            // Excepciones si hay algún problema al arrancar el ejecutable o al leer su salida.*/
            //e.printStackTrace();
            this.success = false;
            this.code = "300";
            this.reason = "Error : " + e.getMessage().replace("\"", "'");
        }
    }

    WriteClientes() {
        throw new UnsupportedOperationException("Not yet implemented");
    }
    
}

class LoadProveedores {

    public String code = "";
    public Boolean success = false;
    public String reason = "";
    public ArrayList usuarios;
    public String usuariosJSON = "[]"; 
    public int totalCount = 0;

    /**
     * Creates a new instance of PruebaRuntime
     */
    public LoadProveedores(String params) {

        

        //System.out.println("Se ejecutara : " + params);

        try {
            // Se lanza el ejecutable. 
            Process p = Runtime.getRuntime().exec(params);

            // Se obtiene el stream de salida del programa 
            InputStream is = p.getInputStream();

            /*
             * Se prepara un bufferedReader para poder leer la salida más
             * comodamente.
             */
            BufferedReader br = new BufferedReader(new InputStreamReader(is));

            //System.out.println("--- 6.1 ---");

            // Se lee la primera linea 
            String aux = br.readLine();
            this.usuarios = new ArrayList();

            //System.out.println("--- 6.2 ---");

            // Mientras se haya leido alguna linea 
            while (aux != null) {
                // Se escribe la linea en pantalla 
                System.out.println(aux);

                usuarios.add(new Usuario(aux));

                // y se lee la siguiente. 
                aux = br.readLine();
            }
           
            String json = "[";
            
            boolean flag = false;
            
            for (int i = 0; i < usuarios.size(); i++) {
                
                flag = true;
                
                Usuario u = (Usuario)usuarios.get(i);
                
                json += "{";
                
                json += ("\"Codigo\":\"" + u.Codigo + "\",");
                json += ("\"RazonSocial\":\"" + u.RazonSocial + "\",");
                json += ("\"Tipo\":\"" + u.Tipo + "\",");
                json += ("\"RFC\":\"" + u.RFC + "\"");
                
                json += "},";
            }
            if(flag){
                json = json.substring(0, json.length() - 1);
            }
                        
            json += "]";

            this.usuariosJSON = json;

            this.totalCount = usuarios.size();

            //------------------------------------------


        } catch (Exception e) {
            // Excepciones si hay algún problema al arrancar el ejecutable o al leer su salida.*/
            //e.printStackTrace();
            this.success = false;
            this.code = "300";
            this.reason = "Error : " + e.getMessage().replace("\"", "'");
        }
    }

    LoadProveedores() {
        throw new UnsupportedOperationException("Not yet implemented");
    }
    
}

class Usuario{

    public String RazonSocial = "";
    public String RFC = "";
    public String Codigo = "";
    public String Tipo = "";
    public String Direccion = "";

    public Usuario(String aux){

        StringTokenizer tokens = new StringTokenizer(aux, "**");
        String token = "";

        int pointer = 1;

        while( tokens.hasMoreTokens() ){

            token = tokens.nextToken();

            switch(pointer){
                case 1 : 
                    this.Codigo = token;
                    break;
                case 2 : 
                    this.RazonSocial = token;
                    break;
                case 3 : 
                    this.RFC = token;
                    break; 
                case 4 : 
                    this.Direccion = token;
                    break;                
            }

            pointer++;

        }

    }

}



class LoadProductos{

    public String code = "";
    public Boolean success = false;
    public String reason = "";
    public ArrayList productos;
    public String productosJSON = "[]"; 
    public int totalCount = 0;

    /**
     * Creates a new instance of PruebaRuntime
     */
    public LoadProductos(String params) {

        

        //System.out.println("Se ejecutara : " + params);

        try {
            // Se lanza el ejecutable. 
            Process p = Runtime.getRuntime().exec(params);

            // Se obtiene el stream de salida del programa 
            InputStream is = p.getInputStream();

            /*
             * Se prepara un bufferedReader para poder leer la salida más
             * comodamente.
             */
            BufferedReader br = new BufferedReader(new InputStreamReader(is));

            //System.out.println("--- 6.1 ---");

            // Se lee la primera linea 
            String aux = br.readLine();
            this.productos = new ArrayList();

            //System.out.println("--- 6.2 ---");

            // Mientras se haya leido alguna linea 
            while (aux != null) {
                // Se escribe la linea en pantalla 
                //System.out.println(aux);

                productos.add(new Producto(aux));

                // y se lee la siguiente. 
                aux = br.readLine();
            }
           
            String json = "[";
            
            boolean flag = false;
            
            for (int i = 0; i < productos.size(); i++) {
                
                flag = true;
                
                Producto pr = (Producto)productos.get(i);
                
                json += "{";
                
                json += ("\"Codigo\":\"" + pr.Codigo + "\",");
                json += ("\"Nombre\":\"" + pr.Nombre + "\",");                
                json += ("\"Precio1\":\"" + pr.Precio1 + "\"");
                
                json += "},";
            }
            if(flag){
                json = json.substring(0, json.length() - 1);
            }
                        
            json += "]";

            this.productosJSON = json;

            this.totalCount = productos.size();

            //------------------------------------------


        } catch (Exception e) {
            // Excepciones si hay algún problema al arrancar el ejecutable o al leer su salida.*/
            //e.printStackTrace();
            this.success = false;
            this.code = "300";
            this.reason = "Error : " + e.getMessage().replace("\"", "'");
        }
    }

    LoadProductos() {
        throw new UnsupportedOperationException("Not yet implemented");
    }
    
}


class Producto{

    public String Nombre = "";
    public String Precio1 = "";
    public String Codigo = "";

    public Producto(String aux){

        StringTokenizer tokens = new StringTokenizer(aux, "**");
        String token = "";

        int pointer = 1;

        while( tokens.hasMoreTokens() ){

            token = tokens.nextToken();

            switch(pointer){
                case 1 : 
                    this.Codigo = token;
                    break;
                case 2 : 
                    this.Nombre = token;
                    break;
                case 3 : 
                    this.Precio1 = token;
                    break;               
            }

            pointer++;

        }

    }

}




















//----------------------- PROGRAMACION DE ALAN ----------------------------

private String getHtml(){

        if(last_error != null){
            return renderError("html");
        }

        String rawHtml = searchHtmlBase("AdminPAQProxy"),
                outHtml = "";

        outHtml = rawHtml.replaceAll("\\{sql\\}",  ""+searchInQuery("sql") );

        outHtml = outHtml.replaceAll("\\{path\\}", ""+searchInQuery("path") );


        if(searchInQuery("sql") != null){
            outHtml = outHtml.replaceAll("\\{tabla\\}", query(searchInQuery("sql")) );

        }else{
            outHtml = outHtml.replaceAll("\\{tabla\\}", "" );
        }

        return buildHtml( outHtml );
    }





    private String getJson(){
        if(last_error != null){
            return renderError("json");
        }
        return query(searchInQuery("sql"));
    }






    private String renderError(String type){
        if(type.equals("html")){
            return "<h1>Error</h1><p>" + last_error + "</p>";

        }else{
            return "{\"status\":\"error\", \"error\": \""+last_error+"\"}";

        }
    }




    private void bootstrapHtml(){
        if(
            (searchInQuery("sql") != null)
            && 
            (searchInQuery("path") == null)
        ){
            last_error = "Enviaste sql pero no la ruta";
            return;
        }


        this.ruta = searchInQuery("path");
    }


    private void bootstrapJson(){

        this.ruta = searchInQuery("path");

        if(this.ruta == null){
            last_error = "No enviaste la ruta";
            Logger.log("No enviaste la ruta, necesitas enviar path.");
            return;
        }


        File f = new File( this.ruta );

        if(!f.isDirectory()){
            last_error = "La ruta `"+f+"` no existe.";
            Logger.log(last_error);
            return;
        }

        return;
    }





























    public String explorer(  ){
        return createExplorer( );
    }
    

    private void startCon(String file){
        Logger.log( "AdminPAQProxy: Conectando con ... " + this.ruta + "" + file + ".dbf" );

        try {

            // create a DBFReader object
            //
            inputStream = new FileInputStream( this.ruta + "" + file + ".dbf");
            reader = new DBFReader( inputStream ); 

        }catch( DBFException e){
            System.out.println( "E1:" + e.getMessage());
            Logger.log(e.getMessage());
            
        }catch( IOException e){
            System.out.println("E2:" + e.getMessage());
            Logger.log(e.getMessage());
        }
    }
    
    private void closeCon(){
        try{
            inputStream.close();
        }catch(Exception e){
            System.out.println(e);
        }
    }
    


    public String query(String sql ){
        
        Logger.log("Doing query:" + sql);

        this.sql = sql;

        String [] sql_tokens = sql.trim().split( " " );

        //buscar el from


        String out = "";

        //first level
        if(sql_tokens[0].equals("select")){
            int i = -1;
            while( !sql_tokens[++i].equals("from") );
            i++;
            startCon( sql_tokens[i] );

            out += select(sql_tokens);  
        } 
        
        if(sql_tokens[0].equals("update")) out += update(sql_tokens);
        
        if(sql_tokens[0].equals("insert")){
            int i = -1;
            while( !sql_tokens[++i].equals("into") );
            i++;
            startCon( sql_tokens[i] );

            out += insert(sql_tokens);  
        } 
        
        return out;
    }







    private String insert (String [] sql){


        String rawSql = "";
        for ( int a = 0; a < sql.length;  a++) {
            rawSql += sql [a] + " ";

        }

        Logger.log("looking for fields");

        int i = 0;
        while( i < rawSql.length() && (rawSql.charAt(i) != '(' )) i++;



        if((i+1) == rawSql.length()){
            
        }

        String [] fields = rawSql.substring( rawSql.indexOf("(")+1, rawSql.indexOf(")") ).split(",");
        for (int z = 0; z < fields.length ; z++ ){
            //System.out.println("--> " + fields[z].trim() );
        }

        String [] values = rawSql.substring( rawSql.lastIndexOf("(")+1, rawSql.lastIndexOf(")") ).split(",");
        for (int z = 0; z < fields.length ; z++ ){
            //System.out.println("--> " + values[z].trim() );
        }

        

        if(values.length != fields.length){
            return "NOPE";
        }
        
        Logger.log("found " + fields.length +  " values to insert..");



        Logger.log("retriving actual table structure...");

        //ok, vamos a buscar que tabla quieres, y vamos a leer sus 
        //Fields
        int numberOfFields = -1;

        try{
            numberOfFields = reader.getFieldCount();

        }catch( DBFException dbfe ){
            System.out.println( "E3:" + dbfe );

        }catch(NullPointerException npe){
            Logger.error("ADMINPAQPROXY:" + npe);

        }

        Logger.log("got " + numberOfFields + " fields on structure.");

        String fieldNames []    = new String[ numberOfFields ];
        Object fieldToInsert [] = new Object[ numberOfFields ];
        int structureLoopIndex;
        int sqlLoopIndex;
        int j;

        nextField:
        for( i = 0, structureLoopIndex = 0; i < numberOfFields; i++, structureLoopIndex++) {

            DBFField field = null;

            try{

                //Logger.log("writing field ..." + reader.getField(structureLoopIndex).getName() );

                for( j = 0, sqlLoopIndex = 0; j < fields.length; j++, sqlLoopIndex++ ){
                    

                    if(fields[sqlLoopIndex].trim().equals( reader.getField(structureLoopIndex).getName().trim() )){
                        
                        //Logger.log("Found field in value in sql...");
                        
                        fieldToInsert[ structureLoopIndex ] = values[ sqlLoopIndex ].toString().trim().toString();
                        
                        switch( reader.getField(structureLoopIndex).getDataType() ){
                            case 'D':
                                Logger.log("Date !");
                                if(
                                    (( fieldToInsert[ structureLoopIndex ].toString().charAt(0) == '\"' )
                                    && 
                                    (fieldToInsert[ structureLoopIndex ].toString().charAt( fieldToInsert[ structureLoopIndex ].toString().length() -1  ) == '\"' ))
                                    ||
                                    (( fieldToInsert[ structureLoopIndex ].toString().charAt(0) == '\'' )
                                    && 
                                    (fieldToInsert[ structureLoopIndex ].toString().charAt( fieldToInsert[ structureLoopIndex ].toString().length() -1  ) == '\'' ))
                                ){

                                    fieldToInsert[ structureLoopIndex ] = fieldToInsert[ structureLoopIndex ].toString().substring( 1, fieldToInsert[ structureLoopIndex ].toString().length() -1 );
                                    DateFormat df = DateFormat.getDateInstance();

                                    try{
                                        fieldToInsert[ structureLoopIndex ] = df.parse(fieldToInsert[ structureLoopIndex ].toString()); 
                                    }catch( java.text.ParseException pe){
                                        Logger.error( pe);
                                    }
                                    


                                } else if( fieldToInsert[ structureLoopIndex ].toString().trim().equals("NOW()")){
                                        fieldToInsert[ structureLoopIndex ] = new Date();

                                }
                                
                            break;

                            case 'C':
                                Logger.log("Char");
                                if(
                                    ( fieldToInsert[ structureLoopIndex ].toString().charAt(0) == '\"' )
                                    && 
                                    (fieldToInsert[ structureLoopIndex ].toString().charAt( fieldToInsert[ structureLoopIndex ].toString().length() -1  ) == '\"' )
                                ){

                                        Logger.log("its string !, removing quotes");
                                        fieldToInsert[ structureLoopIndex ] = fieldToInsert[ structureLoopIndex ].toString().substring( 1, fieldToInsert[ structureLoopIndex ].toString().length() -1 );

                                } else if(
                                    ( fieldToInsert[ structureLoopIndex ].toString().charAt(0) == '\'' )
                                    && 
                                    (fieldToInsert[ structureLoopIndex ].toString().charAt( fieldToInsert[ structureLoopIndex ].toString().length() -1  ) == '\'' )
                                ){
                                        Logger.log("its string !, removing quotes");
                                        fieldToInsert[ structureLoopIndex ] = fieldToInsert[ structureLoopIndex ].toString().substring( 1, fieldToInsert[ structureLoopIndex ].toString().length() -1 );

                                } else{
                                        fieldToInsert[ structureLoopIndex ] = "";

                                }

                            break;
                            case 'N':
                            case 'B':
                            case 'F':
                                Logger.log("NBF");
                                //fieldToInsert[ i ] = "0.0";
                            break;

                        }

                        continue nextField;
                    }
                }//for fields in query
                
                //Logger.log("writing default value");

                //no lo encontre, insertemos el valor default
                switch( reader.getField(structureLoopIndex).getDataType() ){
                    
                    case 'D':
                        fieldToInsert[ structureLoopIndex ] = new Date();   
                    break;

                    case 'C':
                        fieldToInsert[ structureLoopIndex ] = "";
                    break;
                    
                    case 'N':
                        fieldToInsert[ structureLoopIndex ] = null;
                    break;

                    case 'B':
                    case 'F':
                        fieldToInsert[ structureLoopIndex ] = 0.0;
                    break;

                    default:
                        fieldToInsert[ structureLoopIndex ] = "null";
                }

            }catch(com.linuxense.javadbf.DBFException dbfe){
                Logger.error(dbfe);
                System.out.println(dbfe);
                return "{ \"status\" : \"error\" }";

            }

        }//for structure fields



        Logger.log("Closing file for reading..");

        closeCon();

        /*for (int o = 0; o < fieldToInsert.length; o++ ) {
            System.out.println(" :::  " + fieldToInsert[ o]);
        }*/

        DBFWriter writer= null;
        try{

            Logger.log("buscare la tabla a la que insertare..");

            int p = -1;
            while( !sql[++p].trim().equals("into") );
            p++;

            String ruta = this.ruta  + sql[p] + ".dbf";

            System.out.println("ahora si escribiento en :" +  ruta );

            Logger.log( "ahora si escribiento en :" +  ruta );

            writer = new DBFWriter(new File( ruta ));

            writer.addRecord( fieldToInsert);

        }catch(Exception e){
            System.out.println( "E6:" + e );

        }




        return "{ \"status\" : \"ok\" }";

    }

    private String update(String [] sql){
        return "0";
    }
    
    private String createExplorer(){
        String out = Dispatcher.searchModuleInHtml("AdminPAQProxy");

        return out;
    }
    

    private String selectField(){
        return "";
    }


    private String select(String [] sql){
        
        //Seleccionar que tablas?
        if(!sql[1].equals("*")){

        }


        StringBuilder output = new StringBuilder();
        
        
        if(dataType.equals("html")){
            output.append("<table style='font-size:10px'><tr style='background-color: green'>");

        }else{
            output.append("{ \"estructura\" : [ "); 

        }
        
        
        int numberOfFields = -1;

        try{
            numberOfFields = reader.getFieldCount();

        }catch( DBFException dbfe ){
            System.out.println( "E3:" + dbfe );

        }catch(NullPointerException npe){
            Logger.error("ADMINPAQPROXY:" + npe);

        }

        String fieldNames [] = new String[ numberOfFields ];

        for( int i=0; i<numberOfFields; i++) {

            DBFField field = null;
            try{
                if(i>0) {
                    if(dataType.equals("html")){
                        output.append(" ");
                    }else{
                        output.append(",");                     
                    }

                }
                
                if(dataType.equals("html")){
                    output.append( "<td>" 
                        + reader.getField( i).getName( ) 
                        + " ("+ (char)reader.getField(i).getDataType() + " " + reader.getField(i).getFieldLength() +")</td>" );
                }else{
                    output.append( "\"" + reader.getField( i).getName( ) + "\"" );                  
                }
                
                fieldNames[i] = reader.getField( i).getName( );
                
            }catch( DBFException dbfe ){
                System.out.println( "E4:" + dbfe );
                break;
            }
        }
        

        // Now, lets us start reading the rows
        Object []rowObjects = null;

        
        
        if(dataType.equals("html")){
            output.append( "</tr>" );
        }else{
            output.append( "] ,  \"datos\" : [");
        }

        
        int cRecord = 0;
        while( true ) {

            cRecord ++;
            
            try{
                rowObjects = reader.nextRecord(  );

            }catch( DBFException dbfe ){
                System.out.println( "E5:" + dbfe.getMessage() );

            }

            if(rowObjects == null){
                break;
            }

 
            

            if(dataType.equals("html")){
                if(cRecord % 2 == 0){
                    output.append( "<tr style='background-color: gray'>" );
                }else{
                    output.append( "<tr>" );
                }

            }else{
                if(cRecord > 1) output.append(", ");
                output.append("{");
            }

            for( int i=0; i<rowObjects.length; i++) {
                if(i>0){
                    
                    
                    if(dataType.equals("html")){

                    }else{
                        output.append(", ");
                    }
                }
                
                
                if(dataType.equals("html")){
                    output.append( " <td>" + String.valueOf(rowObjects[i]).replaceAll("\\p{Cntrl}", "").replaceAll("[^\\p{ASCII}]", "?") + "</td> ");   
                }else{
                    
                    output.append(" \""+fieldNames[i]+"\" : "
                                    + " \"" + String.valueOf(rowObjects[i]).replaceAll("\\p{Cntrl}", "").replaceAll("[^\\p{ASCII}]", "?") + "\" ");
                }
                
            

            }

            
            if(dataType.equals("html")){
                output.append( "</tr>");
            }else{
                output.append( "}");
            }       
        }   

        if(dataType.equals("html")){
            output.append( "</table>");
        }else{
            output.append("]}");
        }


        // By now, we have itereated through all of the rows
        try{
            inputStream.close();    

        }catch(Exception e){
            System.out.println( "E6:" + e );
        }
        
        return output.toString();
    }
    


    private String getStructure(  ){
        int numberOfFields = -1;

        try{
            numberOfFields = reader.getFieldCount();
            System.out.println( reader.getFieldCount() + " fields.");
            System.out.println( reader.getRecordCount() + " records.");

        }catch( DBFException dbfe ){
            System.out.println( "E3:" + dbfe );

        }


        // use this count to fetch all field information
        // if required
        //
        ArrayList <String>tFields = new ArrayList<String>();

        String output = "{ \"estructura\" : [ ";

        for( int i=0; i<numberOfFields; i++) {

            DBFField field = null;

            try{
                field = reader.getField( i);

            }catch( DBFException dbfe ){
                System.out.println( "E4:" + dbfe );
                break;
            }

            // do something with it if you want
            // refer the JavaDoc API reference for more details
            //
            //System.out.println( "F: " + field.getName() );
            if(i>0){
                output += ",";
            }
            output += " \"" + field.getName( ) + "\" ";

            tFields.add(  field.getName( ) );
            
        }

        output += " }";

        try{
            inputStream.close();    

        }catch(Exception e){
            System.out.println( "E6:" + e );
        }

        return output;
    }

    

}




