<?
/*
 *     E-cidade Software Publico para Gestao Municipal                
 *  Copyright (C) 2013  DBselller Servicos de Informatica             
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

  //MODULO: prefeitura
  //CLASSE DA ENTIDADE db_certidaoweb
  class cl_db_certidaoweb { 
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
     var $codcert = null; 
     var $tipocer = 0; 
     var $cerdtemite_dia = null; 
     var $cerdtemite_mes = null; 
     var $cerdtemite_ano = null; 
     var $cerdtemite = null; 
     var $cerhora = null; 
     var $cerdtvenc_dia = null; 
     var $cerdtvenc_mes = null; 
     var $cerdtvenc_ano = null; 
     var $cerdtvenc = null; 
     var $cerip = null; 
     var $ceracesso = null; 
     var $cercertidao = 0; 
     var $cernomecontr = null; 
     var $cerhtml = null; 
     var $cerweb = 'f'; 
     // cria propriedade com as variaveis do arquivo 
     var $campos = "
                   codcert = varchar(50) = C�digo da certid�o 
                   tipocer = int8 = tipo de certidao 
                   cerdtemite = date = data da emissao 
                   cerhora = varchar(8) = hora da emissao 
                   cerdtvenc = date = data de venc 
                   cerip = varchar(40) = ip 
                   ceracesso = varchar(40) = Acesso 
                   cercertidao = oid = Certid�o 
                   cernomecontr = varchar(100) = Nome 
                   cerhtml = text = Certid�o HTML 
                   cerweb = bool = Web 
                   ";
     //funcao construtor da classe 
     function cl_db_certidaoweb() { 
       //classes dos rotulos dos campos
       $this->rotulo = new rotulo("db_certidaoweb"); 
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
     // funcao para inclusao
     function incluir (){ 
       if($this->codcert == null ){
         $this->erro_sql = " Campo C�digo da certid�o nao Informado.";
         $this->erro_campo = "codcert";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       if($this->tipocer == null ){ 
         $this->erro_sql = " Campo tipo de certidao nao Informado.";
         $this->erro_campo = "tipocer";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       if($this->cerdtemite == null ){ 
         $this->erro_sql = " Campo data da emissao nao Informado.";
         $this->erro_campo = "cerdtemite_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       if($this->cerhora == null ){ 
         $this->erro_sql = " Campo hora da emissao nao Informado.";
         $this->erro_campo = "cerhora";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       if($this->cerdtvenc == null ){ 
         $this->erro_sql = " Campo data de venc nao Informado.";
         $this->erro_campo = "cerdtvenc_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       if($this->cerip == null ){ 
         $this->erro_sql = " Campo ip nao Informado.";
         $this->erro_campo = "cerip";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       if($this->ceracesso == null ){ 
         $this->erro_sql = " Campo Acesso nao Informado.";
         $this->erro_campo = "ceracesso";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       if($this->cernomecontr == null ){ 
         $this->erro_sql = " Campo Nome nao Informado.";
         $this->erro_campo = "cernomecontr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
       if($this->cerweb == null ){ 
         $this->erro_sql = " Campo Web nao Informado.";
         $this->erro_campo = "cerweb";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }

       $sql = "insert into db_certidaoweb(
                                         codcert 
                                        ,tipocer 
                                        ,cerdtemite 
                                        ,cerhora 
                                        ,cerdtvenc 
                                        ,cerip 
                                        ,ceracesso 
                                        ,cercertidao 
                                        ,cernomecontr 
                                        ,cerweb 
                                        ,cerhtml 
                         )
                  values (
                               '$this->codcert' 
                               ,$this->tipocer 
                               ,".($this->cerdtemite == "null" || $this->cerdtemite == ""?"null":"'".$this->cerdtemite."'")." 
                               ,'$this->cerhora' 
                               ,".($this->cerdtvenc == "null" || $this->cerdtvenc == ""?"null":"'".$this->cerdtvenc."'")." 
                               ,'$this->cerip' 
                               ,'$this->ceracesso' 
                               ,$this->cercertidao 
                               ,'$this->cernomecontr' 
                               ,'$this->cerweb' 
                               ,'$this->cerhtml' 
                      )";

       
     $result = db_query($sql);
       
     if($result==false){
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       if( strpos(strtolower($this->erro_banco),"duplicate key") != 0 ){
         $this->erro_sql   = "certidao_web () nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_banco = "certidao_web j� Cadastrado";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }else{
         $this->erro_sql   = "certidao_web () nao Inclu�do. Inclusao Abortada.";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       }
       $this->erro_status = "0";
       return false;
     }
     $this->erro_banco = "";
     $this->erro_sql = "Inclusao Efetivada com Sucesso\\n";
     $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
     $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
     $this->erro_status = "1";
     return true;
   } 
   // funcao para alteracao
   function alterar ( $oid=null ) { 
      $this->atualizacampos();
     $sql = " update db_certidaoweb set ";
     $virgula = "";
     if($this->codcert!="" || isset($GLOBALS["HTTP_POST_VARS"]["codcert"])){ 
       $sql  .= $virgula." codcert = '$this->codcert' ";
       $virgula = ",";
       if($this->codcert == null ){ 
         $this->erro_sql = " Campo C�digo da certid�o nao Informado.";
         $this->erro_campo = "codcert";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if($this->tipocer!="" || isset($GLOBALS["HTTP_POST_VARS"]["tipocer"])){ 
       $sql  .= $virgula." tipocer = $this->tipocer ";
       $virgula = ",";
       if($this->tipocer == null ){ 
         $this->erro_sql = " Campo tipo de certidao nao Informado.";
         $this->erro_campo = "tipocer";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if($this->cerdtemite!="" || isset($GLOBALS["HTTP_POST_VARS"]["cerdtemite_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["cerdtemite_dia"] !="") ){ 
       $sql  .= $virgula." cerdtemite = '$this->cerdtemite' ";
       $virgula = ",";
       if($this->cerdtemite == null ){ 
         $this->erro_sql = " Campo data da emissao nao Informado.";
         $this->erro_campo = "cerdtemite_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if($this->cerdtemite!="" || isset($GLOBALS["HTTP_POST_VARS"]["cerdtemite"])){ 
         $sql  .= $virgula." cerdtemite = null ";
         $virgula = ",";
         if($this->cerdtemite == null ){ 
           $this->erro_sql = " Campo data da emissao nao Informado.";
           $this->erro_campo = "cerdtemite_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if($this->cerhora!="" || isset($GLOBALS["HTTP_POST_VARS"]["cerhora"])){ 
       $sql  .= $virgula." cerhora = '$this->cerhora' ";
       $virgula = ",";
       if($this->cerhora == null ){ 
         $this->erro_sql = " Campo hora da emissao nao Informado.";
         $this->erro_campo = "cerhora";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if($this->cerdtvenc!="" || isset($GLOBALS["HTTP_POST_VARS"]["cerdtvenc_dia"]) &&  ($GLOBALS["HTTP_POST_VARS"]["cerdtvenc_dia"] !="") ){ 
       $sql  .= $virgula." cerdtvenc = '$this->cerdtvenc' ";
       $virgula = ",";
       if($this->cerdtvenc == null ){ 
         $this->erro_sql = " Campo data de venc nao Informado.";
         $this->erro_campo = "cerdtvenc_dia";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }     else{ 
       if($this->cerdtvenc!="" || isset($GLOBALS["HTTP_POST_VARS"]["cerdtvenc"])){ 
         $sql  .= $virgula." cerdtvenc = null ";
         $virgula = ",";
         if($this->cerdtvenc == null ){ 
           $this->erro_sql = " Campo data de venc nao Informado.";
           $this->erro_campo = "cerdtvenc_dia";
           $this->erro_banco = "";
           $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
           $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
           $this->erro_status = "0";
           return false;
         }
       }
     }
     if($this->cerip!="" || isset($GLOBALS["HTTP_POST_VARS"]["cerip"])){ 
       $sql  .= $virgula." cerip = '$this->cerip' ";
       $virgula = ",";
       if($this->cerip == null ){ 
         $this->erro_sql = " Campo ip nao Informado.";
         $this->erro_campo = "cerip";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if($this->ceracesso!="" || isset($GLOBALS["HTTP_POST_VARS"]["ceracesso"])){ 
       $sql  .= $virgula." ceracesso = '$this->ceracesso' ";
       $virgula = ",";
       if($this->ceracesso == null ){ 
         $this->erro_sql = " Campo Acesso nao Informado.";
         $this->erro_campo = "ceracesso";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if($this->cercertidao!="" || isset($GLOBALS["HTTP_POST_VARS"]["cercertidao"])){ 
       $sql  .= $virgula." cercertidao = $this->cercertidao ";
       $virgula = ",";
       if($this->cercertidao == null ){ 
         $this->erro_sql = " Campo Certid�o nao Informado.";
         $this->erro_campo = "cercertidao";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if($this->cernomecontr!="" || isset($GLOBALS["HTTP_POST_VARS"]["cernomecontr"])){ 
       $sql  .= $virgula." cernomecontr = '$this->cernomecontr' ";
       $virgula = ",";
       if($this->cernomecontr == null ){ 
         $this->erro_sql = " Campo Nome nao Informado.";
         $this->erro_campo = "cernomecontr";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if($this->cerhtml!="" || isset($GLOBALS["HTTP_POST_VARS"]["cerhtml"])){ 
       $sql  .= $virgula." cerhtml = '$this->cerhtml' ";
       $virgula = ",";
       if($this->cerhtml == null ){ 
         $this->erro_sql = " Campo Certid�o HTML nao Informado.";
         $this->erro_campo = "cerhtml";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     if($this->cerweb!="" || isset($GLOBALS["HTTP_POST_VARS"]["cerweb"])){ 
       $sql  .= $virgula." cerweb = '$this->cerweb' ";
       $virgula = ",";
       if($this->cerweb == null ){ 
         $this->erro_sql = " Campo Web nao Informado.";
         $this->erro_campo = "cerweb";
         $this->erro_banco = "";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "0";
         return false;
       }
     }
     $sql .= " where oid = $oid ";
     $result = @db_query($sql);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "certidao_web nao Alterado. Alteracao Abortada.\\n";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "certidao_web nao foi Alterado. Alteracao Executada.\\n";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Altera��o Efetivada com Sucesso\\n";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao para exclusao 
   function excluir ( $oid=null ) { 
     $this->atualizacampos(true);
     $sql = " delete from db_certidaoweb
                    where ";
     $sql2 = "";
     $result = @db_query($sql.$sql2);
     if($result==false){ 
       $this->erro_banco = str_replace("\n","",@pg_last_error());
       $this->erro_sql   = "certidao_web nao Exclu�do. Exclus�o Abortada.\\n";
       $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
       $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
       $this->erro_status = "0";
       return false;
     }else{
       if(pg_affected_rows($result)==0){
         $this->erro_banco = "";
         $this->erro_sql = "certidao_web nao Encontrado. Exclus�o n�o Efetuada.\\n";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       }else{
         $this->erro_banco = "";
         $this->erro_sql = "Exclus�o Efetivada com Sucesso\\n";
         $this->erro_msg   = "Usu�rio: \\n\\n ".$this->erro_sql." \\n\\n";
         $this->erro_msg   .=  str_replace('"',"",str_replace("'","",  "Administrador: \\n\\n ".$this->erro_banco." \\n"));
         $this->erro_status = "1";
         return true;
       } 
     } 
   } 
   // funcao do recordset 
   function sql_record($sql) { 
     $result = @db_query($sql);
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
   function sql_query ( $oid,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from db_certidaoweb ";
     $sql2 = "";
     if($dbwhere==""){
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
   function sql_query_file ( $oid,$campos="*",$ordem=null,$dbwhere=""){ 
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
     $sql .= " from db_certidaoweb ";
     $sql2 = "";
     if($dbwhere==""){
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