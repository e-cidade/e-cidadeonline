<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2009  DBselller Servicos de Informatica             
 *                            www.dbseller.com.br                     
 *                         e-cidade@dbseller.com.br                   
 *                                                                    
 *  Este programa e software livre; voce pode redistribui-lo e/ou     
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme  
 *  publicada pela Free Software Foundation; tanto a versao 2 da      
 *  Licenca como (a seu criterio) qualquer versao mais nova.          
 *                                                                    
 *  Este programa e distribuido na expectativa de ser util, mas SEM   
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de              
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM           
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais  
 *  detalhes.                                                         
 *                                                                    
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU     
 *  junto com este programa; se nao, escreva para a Free Software     
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA          
 *  02111-1307, USA.                                                  
 *  
 *  Copia da licenca no diretorio licenca/licenca_en.txt 
 *                                licenca/licenca_pt.txt 
 */

//MODULO: inflatores
//CLASSE DA ENTIDADE infla
class cl_infla { 
   // cria variaveis de erro 
   var $rotulo     = null; 
   var $query_sql  = null; 
   var $numrows    = 0; 
   var $erro_status= null; 
   var $erro_sql   = null; 
   var $erro_banco = null;  
   var $erro_msg   = null;  
   var $erro_campo = null;  
   var $pagina_retorno = null; 
   // cria variaveis do arquivo 
   var $i02_codigo = null; 
   var $i02_data_dia = null; 
   var $i02_data_mes = null; 
   var $i02_data_ano = null; 
   var $i02_data = null; 
   var $i02_valor = 0; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 i02_codigo = varchar(5) = codigo do inflator 
                 i02_data = date = data do inflator 
                 i02_valor = float8 = valor do inflator 
                 ";
   //funcao construtor da classe 
   function cl_infla() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("infla"); 
     $this->pagina_retorno =  basename($GLOBALS["HTTP_SERVER_VARS"]["PHP_SELF"]);
   }
   //funcao erro 
   function erro($mostra,$retorna) { 
     if(($this->erro_status == "0") || ($mostra == true && $this->erro_status != null )){
        echo "<script>alert(\"".$this->erro_msg."\");</script>";
        if($retorna==true){
           echo "<script>location.href='".$this->pagina_retorno."'</script>";
        }
     }
   }
   // funcao para atualizar campos
   function atualizacampos($exclusao=false) {
     if($exclusao==false){
       $this->i02_codigo = ($this->i02_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["i02_codigo"]:$this->i02_codigo);
       if($this->i02_data == ""){
         $this->i02_data_dia = @$GLOBALS["HTTP_POST_VARS"]["i02_data_dia"];
         $this->i02_data_mes = @$GLOBALS["HTTP_POST_VARS"]["i02_data_mes"];
         $this->i02_data_ano = @$GLOBALS["HTTP_POST_VARS"]["i02_data_ano"];
         if($this->i02_data_dia != ""){
            $this->i02_data = $this->i02_data_ano."-".$this->i02_data_mes."-".$this->i02_data_dia;
         }
       }
       $this->i02_valor = ($this->i02_valor == ""?@$GLOBALS["HTTP_POST_VARS"]["i02_valor"]:$this->i02_valor);
     }else{
       $this->i02_codigo = ($this->i02_codigo == ""?@$GLOBALS["HTTP_POST_VARS"]["i02_codigo"]:$this->i02_codigo);
       $this->i02_data = ($this->i02_data == ""?@$GLOBALS["HTTP_POST_VARS"]["i02_data_ano"]."-".@$GLOBALS["HTTP_POST_VARS"]["i02_data_mes"]."-".@$GLOBALS["HTTP_POST_VARS"]["i02_data_dia"]:$this->i02_data);
     }
   }
   // funcao para inclusao
   function incluir ($i02_codigo,$i02_data){ 
      $this->atualizacampos();
     if($this->i02_valor == null ){ 
       $this->erro_sql = " Campo valor do inflator nao Informado.";
       $this->erro_campo = "i02_valor";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
       $this->i02_codigo = $i02_codigo; 
       $this->i02_data = $i02_data; 
     if(($this->i02_codigo == null) || ($this->i02_codigo == "") ){ 
       $this->erro_sql = " Campo i02_codigo nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if(($this->i02_data == null) || ($this->i02_data == "") ){ 
       $this->erro_sql = " Campo i02_data nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @pg_query("insert into infla(
                                       i02_codigo 
                                      ,i02_data 
                                      ,i02_valor 
                       )
                values (
                                '$this->i02_codigo' 
                               ,".($this->i02_data == "null" || $this->i02_data == ""?"null":"'".$this->i02_data."'")." 
                               ,$this->i02_valor 
                      )");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " ($this->i02_codigo."-".$this->i02_data) nao Inclu�do. Inclusao Abortada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->i02_codigo."-".$this->i02_data;
     $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     return true;
   } 
   // funcao para alteracao
   function alterar ($i02_codigo=null,$i02_data=null) { 
      $this->atualizacampos();
     $sql = " update infla set ";
     $virgula = "";
     if(isset($GLOBALS["HTTP_POST_VARS"]["i02_codigo"])){ 
       $sql  .= $virgula." i02_codigo = '$this->i02_codigo' ";
       $virgula = ",";
       if($this->i02_codigo == null ){ 
         $this->erro_sql = " Campo codigo do inflator nao Informado.";
         $this->erro_campo = "i02_codigo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["i02_data_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["i02_data_dia"] !="") ){ 
       $sql  .= $virgula." i02_data = '$this->i02_data' ";
       $virgula = ",";
       if($this->i02_data == null ){ 
         $this->erro_sql = " Campo data do inflator nao Informado.";
         $this->erro_campo = "i02_data_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       $sql  .= $virgula." i02_data = null ";
       $virgula = ",";
       if($this->i02_data == null ){ 
         $this->erro_sql = " Campo data do inflator nao Informado.";
         $this->erro_campo = "i02_data_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["i02_valor"])){ 
       $sql  .= $virgula." i02_valor = $this->i02_valor ";
       $virgula = ",";
       if($this->i02_valor == null ){ 
         $this->erro_sql = " Campo valor do inflator nao Informado.";
         $this->erro_campo = "i02_valor";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where  i02_codigo = '$this->i02_codigo'
 and  i02_data = '$this->i02_data'
";
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->i02_codigo."-".$this->i02_data;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->i02_codigo."-".$this->i02_data;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Altera��o Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->i02_codigo."-".$this->i02_data;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($i02_codigo=null,$i02_data=null) { 
     $this->atualizacampos(true);
     $result = @pg_exec(" delete from infla
                    where  i02_codigo = '$this->i02_codigo'
, i02_data = '$this->i02_data'
                    ");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Exclu�do. Exclus�o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->i02_codigo."-".$this->i02_data;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclus�o n�o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$this->i02_codigo."-".$this->i02_data;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclus�o Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->i02_codigo."-".$this->i02_data;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao do recordset 
   function sql_record($sql) { 
     $result = @pg_query($sql);
     if($result==false){
       $this->numrows    = 0;
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "Erro ao selecionar os registros.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $this->numrows = pg_numrows($result);
      if($this->numrows==0){
        $this->erro_banco = "";
        $this->erro_sql   = "Dados do Grupo nao Encontrado";
        $this->erro_msg   = "Usu�rio: \n\n ".$this->erro_sql." \n\n";
        $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
        $this->erro_status = "0";
        return false;
      }
     return $result;
   }
   // funcao do sql 
   function sql_query ( $i02_codigo=null,$i02_data=null,$campos="*",$ordem=null,$dbwhere=""){ 
     $sql = "select ";
     if($campos != "*" ){
       $campos_sql = split("#",$campos);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }else{
       $sql .= $campos;
     }
     $sql .= " from infla ";
     $sql .= "      inner join inflan on  inflan.i01_codigo = infla.i02_codigo";
     $sql2 = "";
     if($dbwhere==""){
       if($i02_codigo!=null ){
         $sql2 .= " where infla.i02_codigo = '$i02_codigo' "; 
       } 
       if($i02_data!=null ){
         if($sql2!=""){
            $sql2 .= " and ";
         }else{
            $sql2 .= " where ";
         } 
         $sql2 .= " infla.i02_data = '$i02_data' "; 
       } 
     }else if($dbwhere != ""){
       $sql2 = " where $dbwhere";
     }
     $sql .= $sql2;
     if($ordem != null ){
       $sql .= " order by ";
       $campos_sql = split("#",$ordem);
       $virgula = "";
       for($i=0;$i<sizeof($campos_sql);$i++){
         $sql .= $virgula.$campos_sql[$i];
         $virgula = ",";
       }
     }
     return $sql;
  }
}
?>