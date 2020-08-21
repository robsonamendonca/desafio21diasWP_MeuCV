<?php
/**
 * Tema construido no Desafio21Dias
 *
 * @link http://torneseumprogramador.com.br
 *
 * @package WordPress
 * @subpackage Desafio21Dias
 * @since Desafio21Dias
 */
$url = get_stylesheet_directory_uri();
$nome="";
$profissao="";
$email="";
$site ="";
$celular="";
$resumo ="";
$experiencias="";
$habilidades="";
$escolaridade="";
$template_experiencias ='<article>
<h2>#cargo_empresa</h2>
<p class="subDetails">#de_ate</p>
<p>#descricao</p>
</article>';
$template_habilidades="<li>#habilidade</li>";
$template_escolaridade='<article>
<h2>#instituicao</h2>
<p class="subDetails">#curso</p>
<p>#descricao</p>
</article>';

if( have_posts() ) :
while ( have_posts() ) :
    the_post(); 			
        if (get_field('secao')){
            $secao = get_field('secao')[0]; 
		}  

        if ( $secao == "Dados Pessoais"){
            $nome = get_field('nome_completo') ? get_field('nome_completo') : "SEU NOME AQUI";
            $profissao=get_field('profissao') ? get_field('profissao') : "SUA PROFISSAO";
            $email=get_field('email') ? get_field('email') : "SEU EMAIL";
            $site =get_field('site') ? get_field('site') : "SEU SITE";
			$celular=get_field('celular') ? get_field('celular') : "SEU CELULAR";
        }
        if ( $secao == "Resumo Profissional"){
			$resumo = get_field('descricao') ? get_field('descricao') : "SEU RESUMO";
        }
        if ( $secao == "Experiências"){		
            $cargo_empresa=get_field('descricao_titulo') ? get_field('descricao_titulo') : ".";
            $de=get_field('mesano_inicial') ? get_field('mesano_inicial') : ".";
            $ate=get_field('mesano_final') ? get_field('mesano_final') : ".";
			$descricao=get_field('descricao') ? get_field('descricao') : ".";

			$tmpl = $template_experiencias;
			if($cargo_empresa != ".") :
				$tmpl = str_replace("#cargo_empresa",$cargo_empresa,$tmpl);
			endif;	
			if($de != "." && $ate != ".") :
			  $tmpl = str_replace("#de_ate",$de .' - '.$ate,$tmpl);
			endif;
			if($descricao != ".")  :
				$tmpl = str_replace("#descricao",$descricao,$tmpl);
			endif;	
            $experiencias.= $tmpl;
        }        
        if ( $secao == "Habilidades"){
			$descricao = get_field('descricao') ? get_field('descricao') : ".";
			$tmpl = $template_habilidades;
			if($descricao !="."):
				$tmpl = str_replace("#habilidade",$descricao,$tmpl);	
			endif;            
            $habilidades.= $tmpl;
		}		
        if ( $secao == "Escolaridade"){
			$instituicao = get_field('descricao_titulo') ? get_field('descricao_titulo') : ".";		
			$curso = get_field('descricao') ? get_field('descricao') : ".";
			$descricao = !empty(get_the_content())?get_the_content():".";		
			$tmpl = $template_escolaridade;
			if($instituicao !="."):
				$tmpl = !empty($instituicao)? str_replace("#instituicao",$instituicao,$tmpl):$tmpl;
			endif;
			if($curso !=".")	:
				$tmpl = !empty($curso)? str_replace("#curso",$curso,$tmpl): $tmpl;
			endif;	
			if($descricao!="."):
				$tmpl = ($descricao !="")? str_replace("#descricao",$descricao,$tmpl) : $tmpl;
			endif;	
			$escolaridade.= $tmpl;
        }        

    endwhile;
else:?>
<p> Nenhum post encontrado!</p>
<?php
endif;   
?>
<!DOCTYPE html>
<html>

<head>
    <title>Robson Mendonça - Curriculum Vitae</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="<?php echo $url;?>/assets/img/favicon.ico" />
    <meta name="viewport" content="width=device-width" />
    <meta name="description" content="Curriculum Vitae de Robson Mendonça." />
    <meta charset="UTF-8">

    <link type="text/css" rel="stylesheet" href="<?php echo $url;?>/assets/css/cv/style.css">
    <link href='http://fonts.googleapis.com/css?family=Rokkitt:400,700|Lato:400,300' rel='stylesheet' type='text/css'>

    <!--[if lt IE 9]>
<script src="//html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
    <!-- 
	O restante do cabeçalho que virá dentro da head. 
	Criado automaticamente pelo WordPress. 
	-->
    <?php wp_head(); ?>
</head>

<body id="top">
    <div id="cv" class="instaFade">
        <div class="mainDetails">
            <div id="headshot" class="quickFade">
                <img src="<?php echo $url;?>/assets/img/robson.png" alt="Robson Mendonça" />
            </div>
            <div id="name">
                <h1 class="quickFade delayTwo"><?php echo $secao;?></h1>
                <h2 class="quickFade delayThree"><?php the_title();?></h2>
            </div>

            <div id="contactDetails" class="quickFade delayFour">
                <ul>
                    <li><a href="#" onclick="javascript:window.history.go(-1);">
                            << Voltar </a>
                    </li>
                </ul>
            </div>
            <div class="clear"></div>
        </div>

        <div id="mainArea" class="quickFade delayFive">
            <section>
                <article>
                    <div class="sectionTitle">
                        <h1>O que tenho para oferecer</h1>
                    </div>

                    <div class="sectionContent">
                        <p><?php echo $resumo;?></p>
                    </div>
                </article>
                <div class="clear"></div>
            </section>


            <section>
                <div class="sectionTitle">
                    <h1>EXPERIÊNCIA RELEVANTE</h1>
                </div>

                <div class="sectionContent">
                    <?php echo $experiencias;?>
                </div>
                <div class="clear"></div>
            </section>


            <section>
                <div class="sectionTitle">
                    <h1>HABILIDADE TÉCNICAS</h1>
                </div>

                <div class="sectionContent">
                    <ul class="keySkills">
                        <?php echo $habilidades;?>
                    </ul>
                </div>
                <div class="clear"></div>
            </section>


            <section>
                <div class="sectionTitle">
                    <h1>FORMAÇÃO ACADÊMICA</h1>
                </div>

                <div class="sectionContent">
                    <?php echo $escolaridade;?>
                </div>
                <div class="clear"></div>
            </section>

        </div>
    </div>
    <script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost +
        "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
    </script>
    <script type="text/javascript">
    var pageTracker = _gat._getTracker("UA-3753241-1");
    pageTracker._initData();
    pageTracker._trackPageview();
    </script>

    <!-- 
O restante do rodapé que virá dentro do body. 
Criado automaticamente pelo WordPress. 
-->
    <?php wp_footer(); ?>

</body>

</html>