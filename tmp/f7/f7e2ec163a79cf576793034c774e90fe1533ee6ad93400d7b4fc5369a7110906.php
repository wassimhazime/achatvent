<?php

/* @AbstractModules/show.twig */
class __TwigTemplate_77ce4e90f034464e5d8e5737254e2d4d160bfaf6944182038b1f251f9988d712 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("themes.twig", "@AbstractModules/show.twig", 1);
        $_trait_0 = $this->loadTemplate("@AbstractModules/plugins/showmode.twig", "@AbstractModules/show.twig", 3);
        // line 3
        if (!$_trait_0->isTraitable()) {
            throw new Twig_Error_Runtime('Template "'."@AbstractModules/plugins/showmode.twig".'" cannot be used as a trait.', 3, $this->source);
        }
        $_trait_0_blocks = $_trait_0->getBlocks();

        $this->traits = $_trait_0_blocks;

        $this->blocks = array_merge(
            $this->traits,
            array(
                'headcss' => array($this, 'block_headcss'),
                'controle' => array($this, 'block_controle'),
                'container' => array($this, 'block_container'),
                'table' => array($this, 'block_table'),
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
    <link rel=\"stylesheet\" type=\"text/css\" href=\"/";
        // line 7
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/DataTables/css/dataTables.bootstrap.min.css\"/>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"/";
        // line 8
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/Buttons/css/buttons.bootstrap.min.css\"/>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"/";
        // line 9
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/Responsive/css/responsive.bootstrap.min.css\"/>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"/";
        // line 10
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/Select/css/select.bootstrap.min.css\"/>

    <link href=\"/";
        // line 12
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/BootstrapSelect/bootstrap-select.min.css\" rel=\"stylesheet\" type=\"text/css\"/>
    <link href=\"/";
        // line 13
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/JqueryConfirm/jquery-confirm.min.css\" rel=\"stylesheet\" type=\"text/css\"/>

    <style>
        .DataTableJs {
            width:95% ; 
            margin: auto ;
        }
    </style>
";
    }

    // line 25
    public function block_controle($context, array $blocks = array())
    {
        // line 26
        echo "    ";
        $this->displayBlock("showmode", $context, $blocks);
        echo " 
";
    }

    // line 29
    public function block_container($context, array $blocks = array())
    {
        // line 30
        echo "


    <div class =\"\">

        <div class=\"row\" style=\"width:90% ; margin: auto ;    margin-top: 10px;\">
            <table id=\"DataTableJs\"  class=\"DataTableJs table table-striped table-bordered dt-responsive nowrap \">




                ";
        // line 41
        $this->displayBlock('table', $context, $blocks);
        // line 48
        echo "


            </table>
        </div>

    </div>   
";
    }

    // line 41
    public function block_table($context, array $blocks = array())
    {
        // line 42
        echo "                    ";
        if ((($context["Html_or_Json"] ?? null) == "json")) {
            // line 43
            echo "
                    ";
        } elseif ((        // line 44
($context["Html_or_Json"] ?? null) == "HTML")) {
            // line 45
            echo "                        ";
            echo $this->extensions['Kernel\Renderer\Twig_Extension\Table']->table_intent(($context["intent"] ?? null), $this->extensions['Kernel\Renderer\Twig_Extension\Inpute_Table']->input_tableHtml($context));
            echo "
                    ";
        }
        // line 46
        echo "  
                ";
    }

    // line 57
    public function block_footer($context, array $blocks = array())
    {
        // line 58
        echo "    <!-- Custom datatables -->


    <script  src=\"/";
        // line 61
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/DataTables/js/jquery.dataTables.min.js\"></script>
    <script  src=\"/";
        // line 62
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/DataTables/js/dataTables.bootstrap.min.js\"></script>



    ";
        // line 66
        if ((twig_get_attribute($this->env, $this->source, ($context["jsCharges"] ?? null), "excel", array()) == true)) {
            // line 67
            echo "        <script  src=\"/";
            echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
            echo "Framework/JSZip-2.5.0/jszip.min.js\"></script>
    ";
        }
        // line 69
        echo "    ";
        if ((twig_get_attribute($this->env, $this->source, ($context["jsCharges"] ?? null), "pdf", array()) == true)) {
            // line 70
            echo "        <script  src=\"/";
            echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
            echo "Framework/pdfmake-0.1.32/pdfmake.min.js\"></script>
        <script  src=\"/";
            // line 71
            echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
            echo "Framework/pdfmake-0.1.32/vfs_fonts.js\"></script>
    ";
        }
        // line 73
        echo "    <script  src=\"/";
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/Buttons/js/dataTables.buttons.min.js\"></script>
    <script  src=\"/";
        // line 74
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/Buttons/js/buttons.bootstrap.min.js\"></script>
    <script  src=\"/";
        // line 75
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/Buttons/js/buttons.colVis.min.js\"></script>
    <script  src=\"/";
        // line 76
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/Buttons/js/buttons.html5.min.js\"></script>
    ";
        // line 77
        if ((twig_get_attribute($this->env, $this->source, ($context["jsCharges"] ?? null), "print", array()) == true)) {
            // line 78
            echo "        <script  src=\"/Framework/Buttons/js/buttons.print.min.js\"></script>
    ";
        }
        // line 80
        echo "    <script  src=\"/";
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/Responsive/js/dataTables.responsive.min.js\"></script>
    <script  src=\"/";
        // line 81
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/Responsive/js/responsive.bootstrap.min.js\"></script>
    <script  src=\"/";
        // line 82
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/Select/js/dataTables.select.min.js\"></script>


    <script src=\"/";
        // line 85
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "AWA/DataTable.js\" ></script>

    ";
        // line 87
        if ((($context["Html_or_Json"] ?? null) == "json")) {
            // line 88
            echo "
        <script>DataTable_awa('#DataTableJs',
                    \"";
            // line 90
            echo twig_escape_filter($this->env, ($context["btnDataTable"] ?? null), "html", null, true);
            echo "\",
                    '";
            // line 91
            echo $this->extensions['Kernel\Renderer\Twig_Extension\Inpute_Table']->input_tableJson($context);
            echo "',
                    \"";
            // line 92
            echo twig_escape_filter($this->env, ($context["ajax"] ?? null), "html", null, true);
            echo "\");</script>
        ";
        } elseif ((        // line 93
($context["Html_or_Json"] ?? null) == "HTML")) {
            // line 94
            echo "        <script>DataTable_awa('#DataTableJs',
                    \"";
            // line 95
            echo twig_escape_filter($this->env, ($context["btnDataTable"] ?? null), "html", null, true);
            echo "\",
                    '";
            // line 96
            echo $this->extensions['Kernel\Renderer\Twig_Extension\Inpute_Table']->input_tableJson($context);
            echo "'
                    );</script>
        ";
        }
        // line 98
        echo " 
    <!-- end dataTables -->  

    <script src=\"/";
        // line 101
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/BootstrapSelect/bootstrap-select.min.js\" ></script>
    <script src=\"/";
        // line 102
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "Framework/JqueryConfirm/jquery-confirm.min.js\"></script>
    <script src=\"/";
        // line 103
        echo twig_escape_filter($this->env, ($context["_ROOTWEB"] ?? null), "html", null, true);
        echo "AWA/modeAffichageTable.js\" ></script>

";
    }

    public function getTemplateName()
    {
        return "@AbstractModules/show.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  279 => 103,  275 => 102,  271 => 101,  266 => 98,  260 => 96,  256 => 95,  253 => 94,  251 => 93,  247 => 92,  243 => 91,  239 => 90,  235 => 88,  233 => 87,  228 => 85,  222 => 82,  218 => 81,  213 => 80,  209 => 78,  207 => 77,  203 => 76,  199 => 75,  195 => 74,  190 => 73,  185 => 71,  180 => 70,  177 => 69,  171 => 67,  169 => 66,  162 => 62,  158 => 61,  153 => 58,  150 => 57,  145 => 46,  139 => 45,  137 => 44,  134 => 43,  131 => 42,  128 => 41,  117 => 48,  115 => 41,  102 => 30,  99 => 29,  92 => 26,  89 => 25,  76 => 13,  72 => 12,  67 => 10,  63 => 9,  59 => 8,  55 => 7,  52 => 6,  49 => 5,  40 => 1,  18 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"themes.twig\" %}

{% use \"@AbstractModules/plugins/showmode.twig\" %}

{% block headcss %}

    <link rel=\"stylesheet\" type=\"text/css\" href=\"/{{_ROOTWEB}}Framework/DataTables/css/dataTables.bootstrap.min.css\"/>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"/{{_ROOTWEB}}Framework/Buttons/css/buttons.bootstrap.min.css\"/>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"/{{_ROOTWEB}}Framework/Responsive/css/responsive.bootstrap.min.css\"/>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"/{{_ROOTWEB}}Framework/Select/css/select.bootstrap.min.css\"/>

    <link href=\"/{{_ROOTWEB}}Framework/BootstrapSelect/bootstrap-select.min.css\" rel=\"stylesheet\" type=\"text/css\"/>
    <link href=\"/{{_ROOTWEB}}Framework/JqueryConfirm/jquery-confirm.min.css\" rel=\"stylesheet\" type=\"text/css\"/>

    <style>
        .DataTableJs {
            width:95% ; 
            margin: auto ;
        }
    </style>
{% endblock %}



{% block controle %}
    {{ block('showmode') }} 
{% endblock %}

{% block container %}



    <div class =\"\">

        <div class=\"row\" style=\"width:90% ; margin: auto ;    margin-top: 10px;\">
            <table id=\"DataTableJs\"  class=\"DataTableJs table table-striped table-bordered dt-responsive nowrap \">




                {% block table %}
                    {% if Html_or_Json=='json' %}

                    {% elseif Html_or_Json=='HTML' %}
                        {{ table_intent(intent,input_tableHtml())}}
                    {% endif %}  
                {% endblock %}



            </table>
        </div>

    </div>   
{% endblock %}

{% block footer %}
    <!-- Custom datatables -->


    <script  src=\"/{{_ROOTWEB}}Framework/DataTables/js/jquery.dataTables.min.js\"></script>
    <script  src=\"/{{_ROOTWEB}}Framework/DataTables/js/dataTables.bootstrap.min.js\"></script>



    {% if jsCharges.excel == true %}
        <script  src=\"/{{_ROOTWEB}}Framework/JSZip-2.5.0/jszip.min.js\"></script>
    {% endif %}
    {% if jsCharges.pdf == true %}
        <script  src=\"/{{_ROOTWEB}}Framework/pdfmake-0.1.32/pdfmake.min.js\"></script>
        <script  src=\"/{{_ROOTWEB}}Framework/pdfmake-0.1.32/vfs_fonts.js\"></script>
    {% endif %}
    <script  src=\"/{{_ROOTWEB}}Framework/Buttons/js/dataTables.buttons.min.js\"></script>
    <script  src=\"/{{_ROOTWEB}}Framework/Buttons/js/buttons.bootstrap.min.js\"></script>
    <script  src=\"/{{_ROOTWEB}}Framework/Buttons/js/buttons.colVis.min.js\"></script>
    <script  src=\"/{{_ROOTWEB}}Framework/Buttons/js/buttons.html5.min.js\"></script>
    {% if jsCharges.print == true %}
        <script  src=\"/Framework/Buttons/js/buttons.print.min.js\"></script>
    {% endif %}
    <script  src=\"/{{_ROOTWEB}}Framework/Responsive/js/dataTables.responsive.min.js\"></script>
    <script  src=\"/{{_ROOTWEB}}Framework/Responsive/js/responsive.bootstrap.min.js\"></script>
    <script  src=\"/{{_ROOTWEB}}Framework/Select/js/dataTables.select.min.js\"></script>


    <script src=\"/{{_ROOTWEB}}AWA/DataTable.js\" ></script>

    {% if Html_or_Json=='json' %}

        <script>DataTable_awa('#DataTableJs',
                    \"{{btnDataTable}}\",
                    '{{input_tableJson()}}',
                    \"{{ajax}}\");</script>
        {% elseif Html_or_Json=='HTML' %}
        <script>DataTable_awa('#DataTableJs',
                    \"{{btnDataTable}}\",
                    '{{input_tableJson()}}'
                    );</script>
        {% endif %} 
    <!-- end dataTables -->  

    <script src=\"/{{_ROOTWEB}}Framework/BootstrapSelect/bootstrap-select.min.js\" ></script>
    <script src=\"/{{_ROOTWEB}}Framework/JqueryConfirm/jquery-confirm.min.js\"></script>
    <script src=\"/{{_ROOTWEB}}AWA/modeAffichageTable.js\" ></script>

{% endblock %}", "@AbstractModules/show.twig", "/home/wassim/php/achatvent/App/AbstractModules/views/show.twig");
    }
}
