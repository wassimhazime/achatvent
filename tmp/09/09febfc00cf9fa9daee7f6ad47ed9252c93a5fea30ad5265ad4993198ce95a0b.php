<?php

/* theme_1/stricture.twig */
class __TwigTemplate_e200537350568c54353e95309c5657a871313217f6d1e0485af14ef40af553d1 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
            'headcss' => array($this, 'block_headcss'),
            'Navigation' => array($this, 'block_Navigation'),
            'controle' => array($this, 'block_controle'),
            'container' => array($this, 'block_container'),
            'footer' => array($this, 'block_footer'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html lang=\"fr\">

    <head>



        <meta charset=\"utf-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <meta name=\"description\" content=\"\">
        <meta name=\"author\" content=\"\">

        <title>   ";
        // line 14
        echo twig_escape_filter($this->env, ($context["_page"] ?? null), "html", null, true);
        echo "</title>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>
            <script src=\"https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js\"></script>
        <![endif]-->
        <!-- Bootstrap Core CSS -->

        <link href=\"/";
        // line 24
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/Bootstrap3/css/bootstrap.min.css\" rel=\"stylesheet\" type=\"text/css\"/>
        <link href=\"/";
        // line 25
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "AWA/over-bootstrap.css\" rel=\"stylesheet\" type=\"text/css\"/>
        <!-- MetisMenu CSS -->
        <link href=\"/";
        // line 27
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/MetisMenu/metisMenu.min.css\" rel=\"stylesheet\" type=\"text/css\"/>

        <!-- Custom CSS -->
        <link href=\"/";
        // line 30
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "AWA/sb-admin-2.css\" rel=\"stylesheet\" type=\"text/css\"/>
        <!-- Custom Fonts -->
        <link href=\"/";
        // line 32
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/FontAwesome/css/font-awesome.min.css\" rel=\"stylesheet\" type=\"text/css\"/>
        <link href=\"/";
        // line 33
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "AWA/shadow.css\" rel=\"stylesheet\" type=\"text/css\"/>



        ";
        // line 37
        $this->displayBlock('headcss', $context, $blocks);
        // line 41
        echo "

    </head>

    <body style=\"padding-top: 14px ;     font-size: 13px;\">
        <div id=\"wrapper\">



            ";
        // line 50
        $this->displayBlock('Navigation', $context, $blocks);
        // line 53
        echo "
            <div id=\"page-wrapper\">
                <div class=\"row\">
                    <div class=\"col-lg-12\">
                        <h1 class=\"page-header\">";
        // line 57
        echo twig_escape_filter($this->env, ($context["_page"] ?? null), "html", null, true);
        echo " <small>plus info</small></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class=\"row\">

                    ";
        // line 64
        $this->displayBlock('controle', $context, $blocks);
        // line 67
        echo "                </div>
                <div class=\"row\">
                    <div class=\"col-lg-12\">
                        <div class=\"panel panel-success\" style=\"overflow: auto ; padding:  15px ;\">

                            ";
        // line 72
        $this->displayBlock('container', $context, $blocks);
        // line 75
        echo "                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

            </div>





        </div>
        <!-- /#wrapper -->
        <!-- jQuery -->

        <script src=\"/";
        // line 90
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/Jquery/jquery.min.js\" type=\"text/javascript\"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src=\"/";
        // line 92
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/Bootstrap3/js/bootstrap.min.js\" type=\"text/javascript\"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src=\"/";
        // line 94
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/MetisMenu/metisMenu.min.js\" type=\"text/javascript\"></script>
        <!-- Custom Theme JavaScript -->
        <script src=\"/";
        // line 96
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "AWA/sb-admin-2.js\" type=\"text/javascript\"></script>
        ";
        // line 97
        $this->displayBlock('footer', $context, $blocks);
        // line 101
        echo "        <!-- cache menu or mobile -->
        <script>

            \$(document).ready(function() {
                \$(\".sidebar-nav\").removeClass(\"in\").addClass(\"collapse\");
            });

        </script>
    </body>

</html>
";
    }

    // line 37
    public function block_headcss($context, array $blocks = array())
    {
        // line 38
        echo "

        ";
    }

    // line 50
    public function block_Navigation($context, array $blocks = array())
    {
        // line 51
        echo "
            ";
    }

    // line 64
    public function block_controle($context, array $blocks = array())
    {
        // line 65
        echo "
                    ";
    }

    // line 72
    public function block_container($context, array $blocks = array())
    {
        // line 73
        echo "
                            ";
    }

    // line 97
    public function block_footer($context, array $blocks = array())
    {
        // line 98
        echo "

        ";
    }

    public function getTemplateName()
    {
        return "theme_1/stricture.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  218 => 98,  215 => 97,  210 => 73,  207 => 72,  202 => 65,  199 => 64,  194 => 51,  191 => 50,  185 => 38,  182 => 37,  167 => 101,  165 => 97,  161 => 96,  156 => 94,  151 => 92,  146 => 90,  129 => 75,  127 => 72,  120 => 67,  118 => 64,  108 => 57,  102 => 53,  100 => 50,  89 => 41,  87 => 37,  80 => 33,  76 => 32,  71 => 30,  65 => 27,  60 => 25,  56 => 24,  43 => 14,  28 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("<!DOCTYPE html>
<html lang=\"fr\">

    <head>



        <meta charset=\"utf-8\">
        <meta http-equiv=\"X-UA-Compatible\" content=\"IE=edge\">
        <meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">
        <meta name=\"description\" content=\"\">
        <meta name=\"author\" content=\"\">

        <title>   {{_page}}</title>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src=\"https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js\"></script>
            <script src=\"https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js\"></script>
        <![endif]-->
        <!-- Bootstrap Core CSS -->

        <link href=\"/{{_ROOTWEB}}Framework/Bootstrap3/css/bootstrap.min.css\" rel=\"stylesheet\" type=\"text/css\"/>
        <link href=\"/{{_ROOTWEB}}AWA/over-bootstrap.css\" rel=\"stylesheet\" type=\"text/css\"/>
        <!-- MetisMenu CSS -->
        <link href=\"/{{_ROOTWEB}}Framework/MetisMenu/metisMenu.min.css\" rel=\"stylesheet\" type=\"text/css\"/>

        <!-- Custom CSS -->
        <link href=\"/{{_ROOTWEB}}AWA/sb-admin-2.css\" rel=\"stylesheet\" type=\"text/css\"/>
        <!-- Custom Fonts -->
        <link href=\"/{{_ROOTWEB}}Framework/FontAwesome/css/font-awesome.min.css\" rel=\"stylesheet\" type=\"text/css\"/>
        <link href=\"/{{_ROOTWEB}}AWA/shadow.css\" rel=\"stylesheet\" type=\"text/css\"/>



        {% block headcss %}


        {% endblock %}


    </head>

    <body style=\"padding-top: 14px ;     font-size: 13px;\">
        <div id=\"wrapper\">



            {% block Navigation %}

            {% endblock %}

            <div id=\"page-wrapper\">
                <div class=\"row\">
                    <div class=\"col-lg-12\">
                        <h1 class=\"page-header\">{{_page}} <small>plus info</small></h1>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
                <div class=\"row\">

                    {% block controle %}

                    {% endblock %}
                </div>
                <div class=\"row\">
                    <div class=\"col-lg-12\">
                        <div class=\"panel panel-success\" style=\"overflow: auto ; padding:  15px ;\">

                            {% block container %}

                            {% endblock %}
                        </div>
                    </div>
                    <!-- /.col-lg-12 -->
                </div>

            </div>





        </div>
        <!-- /#wrapper -->
        <!-- jQuery -->

        <script src=\"/{{_ROOTWEB}}Framework/Jquery/jquery.min.js\" type=\"text/javascript\"></script>
        <!-- Bootstrap Core JavaScript -->
        <script src=\"/{{_ROOTWEB}}Framework/Bootstrap3/js/bootstrap.min.js\" type=\"text/javascript\"></script>
        <!-- Metis Menu Plugin JavaScript -->
        <script src=\"/{{_ROOTWEB}}Framework/MetisMenu/metisMenu.min.js\" type=\"text/javascript\"></script>
        <!-- Custom Theme JavaScript -->
        <script src=\"/{{_ROOTWEB}}AWA/sb-admin-2.js\" type=\"text/javascript\"></script>
        {% block footer %}


        {% endblock %}
        <!-- cache menu or mobile -->
        <script>

            \$(document).ready(function() {
                \$(\".sidebar-nav\").removeClass(\"in\").addClass(\"collapse\");
            });

        </script>
    </body>

</html>
", "theme_1/stricture.twig", "/home/wassim/php/achatvent/App/TEMPLETE/theme_1/stricture.twig");
    }
}
