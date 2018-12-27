<?php

/* @AbstractModules/ajouter_form.twig */
class __TwigTemplate_863d63b363651c29891bff82c6f1ee3edd6652db10d0db1e22d9be7e090f83c8 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("themes.twig", "@AbstractModules/ajouter_form.twig", 1);
        $_trait_0 = $this->loadTemplate("@AbstractModules/plugins/progress.twig", "@AbstractModules/ajouter_form.twig", 2);
        // line 2
        if (!$_trait_0->isTraitable()) {
            throw new Twig_Error_Runtime('Template "'."@AbstractModules/plugins/progress.twig".'" cannot be used as a trait.', 2, $this->source);
        }
        $_trait_0_blocks = $_trait_0->getBlocks();

        $this->traits = $_trait_0_blocks;

        $this->blocks = array_merge(
            $this->traits,
            array(
                'headcss' => array($this, 'block_headcss'),
                'container' => array($this, 'block_container'),
                'footer' => array($this, 'block_footer'),
            )
        );
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "themes.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 5
    public function block_headcss($context, array $blocks = array())
    {
        // line 6
        echo "
    <!-- Bootstrap-select Custom CSS -->
    <link href=\"/";
        // line 8
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/BootstrapSelect/bootstrap-select.min.css\" rel=\"stylesheet\" type=\"text/css\"/>
    <!-- multi-select Custom CSS -->
    <link href=\"/";
        // line 10
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/BootstrapMultiSelect/css/multi-select.dev.css\" rel=\"stylesheet\" type=\"text/css\"/>
    <link href=\"/";
        // line 11
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/JqueryConfirm/jquery-confirm.min.css\" rel=\"stylesheet\" type=\"text/css\"/>

";
    }

    // line 16
    public function block_container($context, array $blocks = array())
    {
        // line 17
        echo "    <div id=\"status\">

        <div class=\"row\" style=\"margin: 5px\">

            <form  action=\"#\"  method='POST'  enctype=\"multipart/form-data\" class=\"form-horizontal\">
                ";
        // line 22
        echo $this->extensions['Kernel\Renderer\Twig_Extension\Form']->form(($context["intent"] ?? null));
        echo "   
                <div class=\"col-sm-12\"> 
                    <!-- par methode ajax -->
                    <label for=\"ajoutdata\"> AJOUTER </label> 
                    <input type=\"submit\"   name=\"ajoutdata\" class=\"btn btn-success btn-lg\">
                    <label for=\"reset\"> VIDE </label>    
                    <input type=\"reset\" name=\"reset\"  class=\"btn btn-success btn-lg\">
                </div>
            </form>


        </div>

    </div>
    ";
        // line 36
        $this->displayBlock("progress", $context, $blocks);
        echo "
";
    }

    // line 40
    public function block_footer($context, array $blocks = array())
    {
        // line 41
        echo "    <script src=\"/";
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/BootstrapMultiSelect/js/jquery.quicksearch.js\" type=\"text/javascript\"></script>
    <script src=\"/";
        // line 42
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/BootstrapMultiSelect/js/jquery.multi-select.js\" type=\"text/javascript\"></script>
    <script src=\"/";
        // line 43
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/BootstrapSelect/bootstrap-select.min.js\" type=\"text/javascript\"></script>
    <script src=\"/";
        // line 44
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/BootstrapSelect/i18n/defaults-fr_FR.min.js\" type=\"text/javascript\"></script>
    <script src=\"/";
        // line 45
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/JqueryConfirm/jquery-confirm.min.js\"></script>

    <script src=\"/";
        // line 47
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "AWA/set_data_par_ajax.js\" type=\"text/javascript\"></script>

     <script src=\"/";
        // line 49
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "AWA/AWA_CalculeAutoInput.js\" type=\"text/javascript\"></script>
      <script src=\"/";
        // line 50
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "AWA/AWA_ConfigMultiSelect.js\"></script>
    <script src=\"/";
        // line 51
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "AWA/pluginsMultiSelectCalcule.js\" type=\"text/javascript\"></script>
  

    <script>
       

        new AWA_CalculeAutoInput({
            preffix: \"id_html\"
        });

       

        var configMultiSelect = new AWA_ConfigMultiSelect({
            Calcule: new pluginsMultiSelectCalcule({
                preffixDOM: \"id_html\",
                preffixDATA: \"content_\",
            })

        });
        /// set config multi select
        \$.each(\$('select[multiple]'), function() {
            \$(this).multiSelect(configMultiSelect);
        });
    </script>

";
    }

    public function getTemplateName()
    {
        return "@AbstractModules/ajouter_form.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  141 => 51,  137 => 50,  133 => 49,  128 => 47,  123 => 45,  119 => 44,  115 => 43,  111 => 42,  106 => 41,  103 => 40,  97 => 36,  80 => 22,  73 => 17,  70 => 16,  63 => 11,  59 => 10,  54 => 8,  50 => 6,  47 => 5,  38 => 1,  18 => 2,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"themes.twig\" %}
{% use \"@AbstractModules/plugins/progress.twig\" %}


{% block headcss %}

    <!-- Bootstrap-select Custom CSS -->
    <link href=\"/{{_ROOTWEB}}Framework/BootstrapSelect/bootstrap-select.min.css\" rel=\"stylesheet\" type=\"text/css\"/>
    <!-- multi-select Custom CSS -->
    <link href=\"/{{_ROOTWEB}}Framework/BootstrapMultiSelect/css/multi-select.dev.css\" rel=\"stylesheet\" type=\"text/css\"/>
    <link href=\"/{{_ROOTWEB}}Framework/JqueryConfirm/jquery-confirm.min.css\" rel=\"stylesheet\" type=\"text/css\"/>

{% endblock %}


{% block container %}
    <div id=\"status\">

        <div class=\"row\" style=\"margin: 5px\">

            <form  action=\"#\"  method='POST'  enctype=\"multipart/form-data\" class=\"form-horizontal\">
                {{form(intent)}}   
                <div class=\"col-sm-12\"> 
                    <!-- par methode ajax -->
                    <label for=\"ajoutdata\"> AJOUTER </label> 
                    <input type=\"submit\"   name=\"ajoutdata\" class=\"btn btn-success btn-lg\">
                    <label for=\"reset\"> VIDE </label>    
                    <input type=\"reset\" name=\"reset\"  class=\"btn btn-success btn-lg\">
                </div>
            </form>


        </div>

    </div>
    {{ block('progress') }}
{% endblock %}


{% block footer %}
    <script src=\"/{{_ROOTWEB}}Framework/BootstrapMultiSelect/js/jquery.quicksearch.js\" type=\"text/javascript\"></script>
    <script src=\"/{{_ROOTWEB}}Framework/BootstrapMultiSelect/js/jquery.multi-select.js\" type=\"text/javascript\"></script>
    <script src=\"/{{_ROOTWEB}}Framework/BootstrapSelect/bootstrap-select.min.js\" type=\"text/javascript\"></script>
    <script src=\"/{{_ROOTWEB}}Framework/BootstrapSelect/i18n/defaults-fr_FR.min.js\" type=\"text/javascript\"></script>
    <script src=\"/{{_ROOTWEB}}Framework/JqueryConfirm/jquery-confirm.min.js\"></script>

    <script src=\"/{{_ROOTWEB}}AWA/set_data_par_ajax.js\" type=\"text/javascript\"></script>

     <script src=\"/{{_ROOTWEB}}AWA/AWA_CalculeAutoInput.js\" type=\"text/javascript\"></script>
      <script src=\"/{{_ROOTWEB}}AWA/AWA_ConfigMultiSelect.js\"></script>
    <script src=\"/{{_ROOTWEB}}AWA/pluginsMultiSelectCalcule.js\" type=\"text/javascript\"></script>
  

    <script>
       

        new AWA_CalculeAutoInput({
            preffix: \"id_html\"
        });

       

        var configMultiSelect = new AWA_ConfigMultiSelect({
            Calcule: new pluginsMultiSelectCalcule({
                preffixDOM: \"id_html\",
                preffixDATA: \"content_\",
            })

        });
        /// set config multi select
        \$.each(\$('select[multiple]'), function() {
            \$(this).multiSelect(configMultiSelect);
        });
    </script>

{% endblock %}", "@AbstractModules/ajouter_form.twig", "/home/wassim/php/achatvent/App/AbstractModules/views/ajouter_form.twig");
    }
}
