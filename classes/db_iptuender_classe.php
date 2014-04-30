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

//MODULO: cadastro
//CLASSE DA ENTIDADE iptuender
class cl_iptuender { 
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
   var $j43_matric = 0; 
   var $j43_munic = null; 
   var $j43_ender = null; 
   var $j43_cep = null; 
   var $j43_uf = null; 
   var $j43_dest = null; 
   var $j43_numimo = 0; 
   var $j43_cxpost = 0; 
   var $j43_comple = null; 
   // cria propriedade com as variaveis do arquivo 
   var $campos = "
                 j43_matric = int4 = Matricula 
                 j43_munic = varchar(20) = Municipio 
                 j43_ender = varchar(40) = Endereco 
                 j43_cep = char(8) = Cep 
                 j43_uf = char(2) = UF 
                 j43_dest = varchar(40) = Destinatario 
                 j43_numimo = int4 = numero do imovel 
                 j43_cxpost = int4 = caixa postal 
                 j43_comple = char(20) = complemento 
                 ";
   //funcao construtor da classe 
   function cl_iptuender() { 
     //classes dos rotulos dos campos
     $this->rotulo = new rotulo("iptuender"); 
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
       $this->j43_matric = ($this->j43_matric == ""?@$GLOBALS["HTTP_POST_VARS"]["j43_matric"]:$this->j43_matric);
       $this->j43_munic = ($this->j43_munic == ""?@$GLOBALS["HTTP_POST_VARS"]["j43_munic"]:$this->j43_munic);
       $this->j43_ender = ($this->j43_ender == ""?@$GLOBALS["HTTP_POST_VARS"]["j43_ender"]:$this->j43_ender);
       $this->j43_cep = ($this->j43_cep == ""?@$GLOBALS["HTTP_POST_VARS"]["j43_cep"]:$this->j43_cep);
       $this->j43_uf = ($this->j43_uf == ""?@$GLOBALS["HTTP_POST_VARS"]["j43_uf"]:$this->j43_uf);
       $this->j43_dest = ($this->j43_dest == ""?@$GLOBALS["HTTP_POST_VARS"]["j43_dest"]:$this->j43_dest);
       $this->j43_numimo = ($this->j43_numimo == ""?@$GLOBALS["HTTP_POST_VARS"]["j43_numimo"]:$this->j43_numimo);
       $this->j43_cxpost = ($this->j43_cxpost == ""?@$GLOBALS["HTTP_POST_VARS"]["j43_cxpost"]:$this->j43_cxpost);
       $this->j43_comple = ($this->j43_comple == ""?@$GLOBALS["HTTP_POST_VARS"]["j43_comple"]:$this->j43_comple);
     }else{
       $this->j43_matric = ($this->j43_matric == ""?@$GLOBALS["HTTP_POST_VARS"]["j43_matric"]:$this->j43_matric);
     }
   }
   // funcao para inclusao
   function incluir ($j43_matric){ 
      $this->atualizacampos();
     if($this->j43_munic == null ){ 
       $this->erro_sql = " Campo Municipio nao Informado.";
       $this->erro_campo = "j43_munic";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j43_ender == null ){ 
       $this->erro_sql = " Campo Endereco nao Informado.";
       $this->erro_campo = "j43_ender";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j43_cep == null ){ 
       $this->erro_sql = " Campo Cep nao Informado.";
       $this->erro_campo = "j43_cep";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j43_uf == null ){ 
       $this->erro_sql = " Campo UF nao Informado.";
       $this->erro_campo = "j43_uf";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j43_dest == null ){ 
       $this->erro_sql = " Campo Destinatario nao Informado.";
       $this->erro_campo = "j43_dest";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j43_numimo == null ){ 
       $this->erro_sql = " Campo numero do imovel nao Informado.";
       $this->erro_campo = "j43_numimo";
       $this->erro_banco = "";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     if($this->j43_cxpost == null ){ 
       $this->j43_cxpost = "0";
     }
       $this->j43_matric = $j43_matric; 
     if(($this->j43_matric == null) || ($this->j43_matric == "") ){ 
       $this->erro_sql = " Campo j43_matric nao declarado.";
       $this->erro_banco = "Chave Primaria zerada.";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }
     $result = @pg_query("insert into iptuender(
                                       j43_matric 
                                      ,j43_munic 
                                      ,j43_ender 
                                      ,j43_cep 
                                      ,j43_uf 
                                      ,j43_dest 
                                      ,j43_numimo 
                                      ,j43_cxpost 
                                      ,j43_comple 
                       )
                values (
                                $this->j43_matric 
                               ,'$this->j43_munic' 
                               ,'$this->j43_ender' 
                               ,'$this->j43_cep' 
                               ,'$this->j43_uf' 
                               ,'$this->j43_dest' 
                               ,$this->j43_numimo 
                               ,$this->j43_cxpost 
                               ,'$this->j43_comple' 
                      )");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = " ($this->j43_matric) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = " j� Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = " ($this->j43_matric) nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->j43_matric;
     $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     return true;
   } 
   // funcao para alteracao
   function alterar ($j43_matric=null) { 
      $this->atualizacampos();
     $sql = " update iptuender set ";
     $virgula = "";
     if(isset($GLOBALS["HTTP_POST_VARS"]["j43_matric"])){ 
       $sql  .= $virgula." j43_matric = $this->j43_matric ";
       $virgula = ",";
       if($this->j43_matric == null ){ 
         $this->erro_sql = " Campo Matricula nao Informado.";
         $this->erro_campo = "j43_matric";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j43_munic"])){ 
       $sql  .= $virgula." j43_munic = '$this->j43_munic' ";
       $virgula = ",";
       if($this->j43_munic == null ){ 
         $this->erro_sql = " Campo Municipio nao Informado.";
         $this->erro_campo = "j43_munic";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j43_ender"])){ 
       $sql  .= $virgula." j43_ender = '$this->j43_ender' ";
       $virgula = ",";
       if($this->j43_ender == null ){ 
         $this->erro_sql = " Campo Endereco nao Informado.";
         $this->erro_campo = "j43_ender";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j43_cep"])){ 
       $sql  .= $virgula." j43_cep = '$this->j43_cep' ";
       $virgula = ",";
       if($this->j43_cep == null ){ 
         $this->erro_sql = " Campo Cep nao Informado.";
         $this->erro_campo = "j43_cep";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j43_uf"])){ 
       $sql  .= $virgula." j43_uf = '$this->j43_uf' ";
       $virgula = ",";
       if($this->j43_uf == null ){ 
         $this->erro_sql = " Campo UF nao Informado.";
         $this->erro_campo = "j43_uf";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j43_dest"])){ 
       $sql  .= $virgula." j43_dest = '$this->j43_dest' ";
       $virgula = ",";
       if($this->j43_dest == null ){ 
         $this->erro_sql = " Campo Destinatario nao Informado.";
         $this->erro_campo = "j43_dest";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j43_numimo"])){ 
       $sql  .= $virgula." j43_numimo = $this->j43_numimo ";
       $virgula = ",";
       if($this->j43_numimo == null ){ 
         $this->erro_sql = " Campo numero do imovel nao Informado.";
         $this->erro_campo = "j43_numimo";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j43_cxpost"])){ 
       $sql  .= $virgula." j43_cxpost = $this->j43_cxpost ";
       $virgula = ",";
     }
     if(isset($GLOBALS["HTTP_POST_VARS"]["j43_comple"])){ 
       $sql  .= $virgula." j43_comple = '$this->j43_comple' ";
       $virgula = ",";
     }
     $sql .= " where  j43_matric = $this->j43_matric
";
     $result = @pg_exec($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Alterado. Alteracao Abortada.\\n";
         $this->erro_sql .= "Valores : ".$this->j43_matric;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_sql .= "Valores : ".$this->j43_matric;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Altera��o Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->j43_matric;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ($j43_matric=null) { 
     $this->atualizacampos(true);
     $result = @pg_exec(" delete from iptuender
                    where  j43_matric = $this->j43_matric
                    ");
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = " nao Exclu�do. Exclus�o Abortada.\\n";
       $this->erro_sql .= "Valores : ".$this->j43_matric;
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = " nao Encontrado. Exclus�o n�o Efetuada.\\n";
         $this->erro_sql .= "Valores : ".$this->j43_matric;
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclus�o Efetivada com Sucesso\\n";
         $this->erro_sql .= "Valores : ".$this->j43_matric;
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
   function sql_query ( $j43_matric=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from iptuender ";
     $sql .= "      inner join iptubase  on  iptubase.j01_matric = iptuender.j43_matric";
     $sql .= "      inner join lote  on  lote.j34_idbql = iptubase.j01_idbql";
     $sql .= "      inner join cgm  on  cgm.z01_numcgm = iptubase.j01_numcgm";
     $sql2 = "";
     if($dbwhere==""){
       if($j43_matric!=null ){
         $sql2 .= " where iptuender.j43_matric = $j43_matric "; 
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
   // funcao do sql 
   function sql_query_file ( $j43_matric=null,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from iptuender ";
     $sql2 = "";
     if($dbwhere==""){
       if($j43_matric!=null ){
         $sql2 .= " where iptuender.j43_matric = $j43_matric "; 
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