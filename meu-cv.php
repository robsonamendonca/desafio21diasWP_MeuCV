<?php
/*
Meu CV (Desafio21Dias)

Plugin Name: Meu CV (Desafio21Dias)
Plugin URI: http://torneseumprogramador.com.br
Description: Este é o plugin criado pelo Robson aluno muito dedicado que acorda as 5 horas da manhã para evoluir 1% ao dia, esses alunos assim como o Robson são referências para mim: Danilo Aparecido. 
Author: Alunos da Comunidade Torne-se um Programador
Author URI:  https://github.com/robsonamendonca/desafio21diasWP_MeuCV/
Version: 0.0.1
Text Domain: meu-cv
Tags: desafio,21Dias,tornese,programador, robsonamendonca, robson, wordpress, php, torneseumprogramador, programador
Domain Path: /languages
*/

if ( ! defined( 'ABSPATH' ) ) {
    die( 'Invalid request.' );
  }

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
//senão instalado! 
if ( !is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {    
    die( '<h2>Este plugin depende que o Advanced Custom Fields (Campos Personalizados) esteja instalado e ativo!</h2>' );
}
  
  class MeuCV {
    public function __construct() {
      add_action( 'init', Array($this,'create_custom_post_type_modulo') );
      add_action( 'admin_menu', array( $this, 'meu_cv_submenu' ), 101 );
    }

    /* Add MeuCv menu*/
    public function meu_cv_submenu() {      
      add_submenu_page( 'edit.php?post_type=meucv_plugin', __( 'Visualizar CV', 'text_domain' ), __( 'Visualizar CV', 'text_domain' ), 'administrator', 'pre-visualizar', __CLASS__ .'::menu_page_output' ); 
    }

    public static function menu_page_output() {
      //Menu Page output code      
      echo '<div class="update-nag"> Meu CV está disponível! Atualize seu CV agora.  </div>';
      require('include/docs.php');      
    }    

    public function create_custom_post_type_modulo() {
      $labels = array(
        'name'                  => _x( 'Meu CV', 'meucv_plugin', 'text_domain' ),
        'singular_name'         => _x( 'Meu CV', 'meucv_plugin', 'text_domain' ),
        'menu_name'             => __( 'Meu CV', 'text_domain' ),
        'name_admin_bar'        => __( 'Meu CV', 'text_domain' ),
      );
  
      $args = array(
        'label'                 => __( 'Meu CV', 'text_domain' ),
        'description'           => __( 'Crie e adicione sua habilidades , conhecimentos e experiencias', 'text_domain' ),
        'labels'                => $labels,
        'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt'), 
        'taxonomies'            => array( 'category', 'post_tag' ),
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 3,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'menu_icon'             => 'dashicons-id-alt',
        'has_archive'           => true,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'capability_type'       => 'page',    
      );
  
      register_post_type( 'meucv_plugin', $args );
    }
    public function activate() {
      #double check
      $this->create_custom_post_type_modulo();
  
      //copiar arquivos de template
      $plugin_archive_dir = plugin_dir_path( __FILE__ ) . 'archive-meucv_plugin.php';
      $theme_archive_dir = get_stylesheet_directory() . '/archive-meucv_plugin.php';
      //var_dump($plugin_archive_dir);
      //var_dump($theme_archive_dir);
      //archive-meucv_plugin.php 
      if(!file_exists($theme_archive_dir)){
        if (!copy($plugin_archive_dir, $theme_archive_dir)) {
          die ("Falha na Importação do arquivo: $plugin_archive_dir para $theme_archive_dir...\n");
        }  
      }
      $plugin_single_dir = plugin_dir_path( __FILE__ ) . 'single-meucv_plugin.php';
      $theme_single_dir = get_stylesheet_directory() . '/single-meucv_plugin.php';      
      //single-meu-cv
      if(!file_exists($theme_single_dir)){
        if (!copy($plugin_single_dir, $theme_single_dir)) {
          die ("Falha na Importação do arquivo: $plugin_single_dir para $theme_single_dir...\n");
        } 
      }

      flush_rewrite_rules();
  
      # Se vc preciar rodar algo ao iniciar
      global $wpdb;
      $wpdb->get_results("
      INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (NULL, '1', '2020-08-16 18:35:45', '2020-08-16 21:35:45', 'a:7:{s:8:\"location\";a:1:{i:0;a:1:{i:0;a:3:{s:5:\"param\";s:9:\"post_type\";s:8:\"operator\";s:2:\"==\";s:5:\"value\";s:12:\"meucv_plugin\";}}}s:8:\"position\";s:6:\"normal\";s:5:\"style\";s:7:\"default\";s:15:\"label_placement\";s:3:\"top\";s:21:\"instruction_placement\";s:5:\"label\";s:14:\"hide_on_screen\";s:0:\"\";s:11:\"description\";s:0:\"\";}', 'novos campos meu cv', 'novos-campos-meu-cv', 'publish', 'closed', 'closed', '', 'group_5f3eee399c02e', '', '', '2020-08-20 18:42:28', '2020-08-20 21:42:28', '', '0', '#', '0', 'acf-field-group', '', '0')
      ");      
      $pp = $wpdb->insert_id;
      $wpdb->get_results("INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (NULL, '1', '2020-08-16 18:35:46', '2020-08-16 21:35:46', 'a:13:{s:4:\"type\";s:6:\"select\";s:12:\"instructions\";s:71:\"Selecione primeira a seção que deseja alterar/adicionar informações\";s:8:\"required\";i:1;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:7:\"choices\";a:5:{s:14:\"Dados Pessoais\";s:14:\"Dados Pessoais\";s:19:\"Resumo Profissional\";s:19:\"Resumo Profissional\";s:13:\"Experiências\";s:13:\"Experiências\";s:11:\"Habilidades\";s:11:\"Habilidades\";s:12:\"Escolaridade\";s:12:\"Escolaridade\";}s:13:\"default_value\";a:0:{}s:10:\"allow_null\";i:0;s:8:\"multiple\";i:1;s:2:\"ui\";i:0;s:13:\"return_format\";s:5:\"value\";s:4:\"ajax\";i:0;s:11:\"placeholder\";s:0:\"\";}', 'Seção', 'secao', 'publish', 'closed', 'closed', '', 'field_5f39a598f7ea8', '', '', '2020-08-17 06:02:25', '2020-08-17 09:02:25', '', '".$pp."', '#', '0', 'acf-field', '', '0')");
      $wpdb->get_results("INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (NULL, '1', '2020-08-16 20:13:19', '2020-08-16 23:13:19', 'a:10:{s:4:\"type\";s:4:\"text\";s:12:\"instructions\";s:63:\"Preencher conforme o contexto da seleção da Seção definida!\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:7:\"prepend\";s:0:\"\";s:6:\"append\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";}', 'Titulo da descrição', 'descricao_titulo', 'publish', 'closed', 'closed', '', 'field_5f39bd710c86f', '', '', '2020-08-16 20:13:42', '2020-08-16 23:13:42', '', '".$pp."', '#', '1', 'acf-field', '', '0')");
      $wpdb->get_results("INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (NULL, '1', '2020-08-16 18:35:47', '2020-08-16 21:35:47', 'a:10:{s:4:\"type\";s:8:\"textarea\";s:12:\"instructions\";s:63:\"Preencher conforme o contexto da seleção da Seção definida!\";s:8:\"required\";i:0;s:17:\"conditional_logic\";i:0;s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";s:4:\"rows\";s:0:\"\";s:9:\"new_lines\";s:0:\"\";}', 'Descrição', 'descricao', 'publish', 'closed', 'closed', '', 'field_5f39a696f7ea9', '', '', '2020-08-16 20:15:40', '2020-08-16 23:15:40', '', '".$pp."', '#', '2', 'acf-field', '', '0')");
      $wpdb->get_results("INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (NULL, '1', '2020-08-16 18:39:53', '2020-08-16 21:39:53', 'a:10:{s:4:\"type\";s:4:\"text\";s:12:\"instructions\";s:80:\"Informar o inicio do período com o seguinte formato: MM/AAAA, exemplo: 08/2020!\";s:8:\"required\";i:0;s:17:\"conditional_logic\";a:1:{i:0;a:1:{i:0;a:3:{s:5:\"field\";s:19:\"field_5f39a598f7ea8\";s:8:\"operator\";s:10:\"==contains\";s:5:\"value\";s:13:\"Experiências\";}}}s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:7:\"prepend\";s:0:\"\";s:6:\"append\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";}', 'Mês/Ano Inicial', 'mesano_inicial', 'publish', 'closed', 'closed', '', 'field_5f39a726558a1', '', '', '2020-08-17 06:02:25', '2020-08-17 09:02:25', '', '".$pp."', '#', '3', 'acf-field', '', '0')");
      $wpdb->get_results("INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (NULL, '1', '2020-08-16 18:42:08', '2020-08-16 21:42:08', 'a:10:{s:4:\"type\";s:4:\"text\";s:12:\"instructions\";s:80:\"Informar o inicio do período com o seguinte formato: MM/AAAA, exemplo: 08/2020!\";s:8:\"required\";i:0;s:17:\"conditional_logic\";a:1:{i:0;a:1:{i:0;a:3:{s:5:\"field\";s:19:\"field_5f39a598f7ea8\";s:8:\"operator\";s:10:\"==contains\";s:5:\"value\";s:13:\"Experiências\";}}}s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:7:\"prepend\";s:0:\"\";s:6:\"append\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";}', 'Mês/Ano Final', 'mesano_final', 'publish', 'closed', 'closed', '', 'field_5f39a8116fc86', '', '', '2020-08-16 21:06:20', '2020-08-17 00:06:20', '', '".$pp."', '#', '4', 'acf-field', '', '0')");
      $wpdb->get_results("INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (NULL, '1', '2020-08-16 18:43:31', '2020-08-16 21:43:31', 'a:10:{s:4:\"type\";s:4:\"text\";s:12:\"instructions\";s:25:\"Informe seu Nome Completo\";s:8:\"required\";i:1;s:17:\"conditional_logic\";a:1:{i:0;a:1:{i:0;a:3:{s:5:\"field\";s:19:\"field_5f39a598f7ea8\";s:8:\"operator\";s:10:\"==contains\";s:5:\"value\";s:14:\"Dados Pessoais\";}}}s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:7:\"prepend\";s:0:\"\";s:6:\"append\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";}', 'Nome Completo', 'nome_completo', 'publish', 'closed', 'closed', '', 'field_5f39a857f5565', '', '', '2020-08-16 20:13:20', '2020-08-16 23:13:20', '', '".$pp."', '#', '5', 'acf-field', '', '0')");
      $wpdb->get_results("INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (NULL, '1', '2020-08-16 19:09:26', '2020-08-16 22:09:26', 'a:10:{s:4:\"type\";s:4:\"text\";s:12:\"instructions\";s:38:\"Informe sua Profissão ou Cargo atual.\";s:8:\"required\";i:1;s:17:\"conditional_logic\";a:1:{i:0;a:1:{i:0;a:3:{s:5:\"field\";s:19:\"field_5f39a598f7ea8\";s:8:\"operator\";s:10:\"==contains\";s:5:\"value\";s:14:\"Dados Pessoais\";}}}s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:7:\"prepend\";s:0:\"\";s:6:\"append\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";}', 'Profissão', 'profissao', 'publish', 'closed', 'closed', '', 'field_5f39ae5bd99ef', '', '', '2020-08-16 20:13:20', '2020-08-16 23:13:20', '', '".$pp."', '#', '6', 'acf-field', '', '0')");
      $wpdb->get_results("INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (NULL, '1', '2020-08-16 19:10:34', '2020-08-16 22:10:34', 'a:10:{s:4:\"type\";s:4:\"text\";s:12:\"instructions\";s:18:\"Informe seu e-mail\";s:8:\"required\";i:0;s:17:\"conditional_logic\";a:1:{i:0;a:1:{i:0;a:3:{s:5:\"field\";s:19:\"field_5f39a598f7ea8\";s:8:\"operator\";s:10:\"==contains\";s:5:\"value\";s:14:\"Dados Pessoais\";}}}s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:7:\"prepend\";s:0:\"\";s:6:\"append\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";}', 'E-mail', 'email', 'publish', 'closed', 'closed', '', 'field_5f39aebb1b924', '', '', '2020-08-16 20:13:21', '2020-08-16 23:13:21', '', '".$pp."', '#', '7', 'acf-field', '', '0')");
      $wpdb->get_results("INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (NULL, '1', '2020-08-16 19:11:25', '2020-08-16 22:11:25', 'a:10:{s:4:\"type\";s:4:\"text\";s:12:\"instructions\";s:39:\"Informe seu site / blog / perfil online\";s:8:\"required\";i:0;s:17:\"conditional_logic\";a:1:{i:0;a:1:{i:0;a:3:{s:5:\"field\";s:19:\"field_5f39a598f7ea8\";s:8:\"operator\";s:10:\"==contains\";s:5:\"value\";s:14:\"Dados Pessoais\";}}}s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:7:\"prepend\";s:0:\"\";s:6:\"append\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";}', 'Site', 'site', 'publish', 'closed', 'closed', '', 'field_5f39aeec58978', '', '', '2020-08-16 20:13:21', '2020-08-16 23:13:21', '', '".$pp."', '#', '8', 'acf-field', '', '0')");
      $wpdb->get_results("INSERT INTO `wp_posts` (`ID`, `post_author`, `post_date`, `post_date_gmt`, `post_content`, `post_title`, `post_excerpt`, `post_status`, `comment_status`, `ping_status`, `post_password`, `post_name`, `to_ping`, `pinged`, `post_modified`, `post_modified_gmt`, `post_content_filtered`, `post_parent`, `guid`, `menu_order`, `post_type`, `post_mime_type`, `comment_count`) VALUES (NULL, '1', '2020-08-16 19:12:02', '2020-08-16 22:12:02', 'a:10:{s:4:\"type\";s:4:\"text\";s:12:\"instructions\";s:41:\"Informe seu telefone / celular / whatsapp\";s:8:\"required\";i:0;s:17:\"conditional_logic\";a:1:{i:0;a:1:{i:0;a:3:{s:5:\"field\";s:19:\"field_5f39a598f7ea8\";s:8:\"operator\";s:10:\"==contains\";s:5:\"value\";s:14:\"Dados Pessoais\";}}}s:7:\"wrapper\";a:3:{s:5:\"width\";s:0:\"\";s:5:\"class\";s:0:\"\";s:2:\"id\";s:0:\"\";}s:13:\"default_value\";s:0:\"\";s:11:\"placeholder\";s:0:\"\";s:7:\"prepend\";s:0:\"\";s:6:\"append\";s:0:\"\";s:9:\"maxlength\";s:0:\"\";}', 'Celular', 'celular', 'publish', 'closed', 'closed', '', 'field_5f39af124198c', '', '', '2020-08-16 20:13:21', '2020-08-16 23:13:21', '', '".$pp."', '#', '9', 'acf-field', '', '0')");                                                                                                                                                          


    }
  
    public function deactivate() {
      flush_rewrite_rules();
      # Se vc preciar desabilitar algo
      global $wpdb;
      $wpdb->get_results("delete from wp_posts where post_type='meucv_plugin';");
      $table_name = $wpdb->prefix . 'posts';     
      $field_name = 'ID';
      $where = "novos campos meu cv";     
      $prepared_statement = $wpdb->prepare( "SELECT                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                         {$field_name} FROM {$table_name} WHERE  post_status = 'publish' and post_title = '%s'", $where );
      $pp = $wpdb->get_col( $prepared_statement );    
      //novos campos meu cv -> acf (grupo)
      $wpdb->get_results("delete from wp_posts where post_title='novos campos meu cv';");
      //novos campos meu cv -> acf (campos)
      $wpdb->get_results("delete from wp_posts where post_parent=".$pp[0].";");      
    }
  
    public static function uninstall() {
      flush_rewrite_rules();
      global $wpdb;
      $wpdb->get_results("delete from wp_posts where post_type='meucv_plugin';");
      $table_name = $wpdb->prefix . 'posts';     
      $field_name = 'ID';
      $where = "novos campos meu cv";     
      $prepared_statement = $wpdb->prepare( "SELECT {$field_name} FROM {$table_name} WHERE  post_status = 'publish' and post_title = '%s'", $where );
      $pp = $wpdb->get_col( $prepared_statement );    
      //novos campos meu cv -> acf (grupo)
      $wpdb->get_results("delete from wp_posts where post_title='novos campos meu cv';");
      //novos campos meu cv -> acf (campos)
      $wpdb->get_results("delete from wp_posts where post_parent=".$pp[0].";");

      $theme_archive_dir = get_stylesheet_directory() . '/archive-meucv_plugin.php';     
      $theme_single_dir = get_stylesheet_directory() . '/single-meucv_plugin.php';             
      // Use unlink() function to delete a file  
      if (!unlink($theme_archive_dir)) {  
        die ("$theme_archive_dir cannot be deleted due to an error");  
      }       
      if (!unlink($theme_single_dir)) {  
        die ("$theme_single_dir cannot be deleted due to an error");  
      }      

    }
  }
  
  if ( class_exists( 'MeuCV' ) ){
    $didoxModulo = new MeuCV();
    register_activation_hook( __FILE__, array( $didoxModulo, 'activate' ) );
    register_deactivation_hook( __FILE__, array( $didoxModulo, 'deactivate' ) );
    register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );
  }