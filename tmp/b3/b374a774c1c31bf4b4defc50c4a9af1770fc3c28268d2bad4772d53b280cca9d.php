<?php

/* @AbstractModules/plugins/showmode.twig */
class __TwigTemplate_ad86b47c0ca21f14d04d5f973bdc3ecfee942e3e313147a55cb5a03da6e5a6ec extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
            'showmode' => array($this, 'block_showmode'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('showmode', $context, $blocks);
    }

    public function block_showmode($context, array $blocks = array())
    {
        // line 2
        echo "    <button type=\"button\" class=\"pull-right glyphicon glyphicon-th-list btn btn-primary\" data-toggle=\"modal\" data-target=\"#boxSelectMode\" style=\"margin-bottom: 10px;margin-right: 10px\">

    </button>



    <div class=\"modal fade\" id=\"boxSelectMode\"  tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
        <div class=\"modal-dialog \" role=\"document\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                    <h4 class=\"modal-title\" id=\"myModalLabel\"><span class=\"glyphicon glyphicon-list\" aria-hidden=\"true\"></span> Les Paramètres d'affichage </h4>
                </div>
                <div class=\"modal-body\">
                    <form action=\"\" method=\"GET\" class=\"\">
                        <div class=\"row\">
                            
                            <div class=\"btn-group col-sm-12\" data-toggle=\"buttons\">

                                <label class=\"not_focus btn btn-primary ";
        // line 21
        if ((twig_get_attribute($this->env, $this->source, ($context["jsCharges"] ?? null), "copier", array()) == true)) {
            echo " active ";
        }
        echo " \" >
                                    <input type=\"checkbox\" name=\"copier\" ";
        // line 22
        if ((twig_get_attribute($this->env, $this->source, ($context["jsCharges"] ?? null), "copier", array()) == true)) {
            echo " checked ";
        }
        echo "  autocomplete=\"off\"  value=\"on\"> <i class=\"fa fa-files-o\"></i>'
                                </label>
                                <label class=\"not_focus btn btn-primary ";
        // line 24
        if ((twig_get_attribute($this->env, $this->source, ($context["jsCharges"] ?? null), "pdf", array()) == true)) {
            echo " active ";
        }
        echo " \">
                                    <input type=\"checkbox\" name=\"pdf\" ";
        // line 25
        if ((twig_get_attribute($this->env, $this->source, ($context["jsCharges"] ?? null), "pdf", array()) == true)) {
            echo " checked ";
        }
        echo "  autocomplete=\"off\" value=\"on\"> <i class=\"fa fa-file-pdf-o\"></i>
                                </label>
                                <label class=\"not_focus btn btn-primary ";
        // line 27
        if ((twig_get_attribute($this->env, $this->source, ($context["jsCharges"] ?? null), "excel", array()) == true)) {
            echo " active ";
        }
        echo "\">
                                    <input type=\"checkbox\" name=\"excel\"  ";
        // line 28
        if ((twig_get_attribute($this->env, $this->source, ($context["jsCharges"] ?? null), "excel", array()) == true)) {
            echo " checked ";
        }
        echo " autocomplete=\"off\" value=\"on\">  <i class=\"fa fa-file-excel-o\"></i>
                                </label>
                                <label class=\"not_focus btn btn-primary ";
        // line 30
        if ((twig_get_attribute($this->env, $this->source, ($context["jsCharges"] ?? null), "print", array()) == true)) {
            echo " active ";
        }
        echo "\">
                                    <input type=\"checkbox\" name=\"impression\" ";
        // line 31
        if ((twig_get_attribute($this->env, $this->source, ($context["jsCharges"] ?? null), "print", array()) == true)) {
            echo " checked ";
        }
        echo "  autocomplete=\"off\" value=\"on\">  <i class=\"glyphicon glyphicon-print\"></i>
                                </label>
                            </div>

                        </div>   
                        <div class=\"row\">
                            <div class=\"checkbox col-sm-12\">
                                <label>
                                    <input type=\"checkbox\" name=\"control\" value=\"ok\"> controle donnee(modifier supprimer)
                                </label>
                            </div>
                        </div> 
                        <div class=\"row\">
                            <div class=\"col-sm-6\">
                                <select class=\"selectpicker show-tick\" data-style=\"btn-success\"  data-width=\"90%\" name=\"pere\">
                                    <option data-subtext=\"De père\"  ";
        // line 46
        if ((($context["modeSelectpere"] ?? null) == "MASTER")) {
            echo " selected ";
        }
        echo "   value=\"resume\">voir résumé des information</option>
                                    <option data-subtext=\"De père\" ";
        // line 47
        if ((($context["modeSelectpere"] ?? null) == "DEFAULT")) {
            echo " selected ";
        }
        echo "    value=\"defaut\">voir defaut des information</option>
                                    <option data-subtext=\"De père\" ";
        // line 48
        if ((($context["modeSelectpere"] ?? null) == "ALL")) {
            echo " selected ";
        }
        echo "    value=\"tous\">voir tous les information</option>
                                </select>
                            </div>
                            <div class=\"col-sm-6\">
                                <select class=\"selectpicker show-tick\" data-style=\"btn-info\"  data-width=\"90%\" name=\"fils\">
                                    <option data-subtext=\"Des Fils\" ";
        // line 53
        if ((($context["modeSelectenfant"] ?? null) == "EMPTY")) {
            echo " selected ";
        }
        echo " value=\"rien\">voir rien</option>
                                    <option data-subtext=\"Des Fils\" ";
        // line 54
        if ((($context["modeSelectenfant"] ?? null) == "MASTER")) {
            echo " selected ";
        }
        echo " value=\"resume\">voir résumé des information</option>
                                    <option data-subtext=\"Des Fils\" ";
        // line 55
        if ((($context["modeSelectenfant"] ?? null) == "DEFAULT")) {
            echo " selected ";
        }
        echo " value=\"defaut\">voir defaut des information</option>
                                    <option data-subtext=\"Des Fils\" ";
        // line 56
        if ((($context["modeSelectenfant"] ?? null) == "ALL")) {
            echo " selected ";
        }
        echo " value=\"tous\">voir tous les information</option>
                                </select>
                            </div>
                        </div> 
                        <button type=\"submit\"  class=\"btn-primary btn\"> <span class=\"glyphicon glyphicon-repeat\" aria-hidden=\"true\"></span></button>
                    </form>
                </div><!-- /.modal-body -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

";
    }

    public function getTemplateName()
    {
        return "@AbstractModules/plugins/showmode.twig";
    }

    public function getDebugInfo()
    {
        return array (  156 => 56,  150 => 55,  144 => 54,  138 => 53,  128 => 48,  122 => 47,  116 => 46,  96 => 31,  90 => 30,  83 => 28,  77 => 27,  70 => 25,  64 => 24,  57 => 22,  51 => 21,  30 => 2,  24 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% block showmode %}
    <button type=\"button\" class=\"pull-right glyphicon glyphicon-th-list btn btn-primary\" data-toggle=\"modal\" data-target=\"#boxSelectMode\" style=\"margin-bottom: 10px;margin-right: 10px\">

    </button>



    <div class=\"modal fade\" id=\"boxSelectMode\"  tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
        <div class=\"modal-dialog \" role=\"document\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                    <h4 class=\"modal-title\" id=\"myModalLabel\"><span class=\"glyphicon glyphicon-list\" aria-hidden=\"true\"></span> Les Paramètres d'affichage </h4>
                </div>
                <div class=\"modal-body\">
                    <form action=\"\" method=\"GET\" class=\"\">
                        <div class=\"row\">
                            
                            <div class=\"btn-group col-sm-12\" data-toggle=\"buttons\">

                                <label class=\"not_focus btn btn-primary {% if jsCharges.copier == true %} active {% endif %} \" >
                                    <input type=\"checkbox\" name=\"copier\" {% if jsCharges.copier == true %} checked {% endif %}  autocomplete=\"off\"  value=\"on\"> <i class=\"fa fa-files-o\"></i>'
                                </label>
                                <label class=\"not_focus btn btn-primary {% if jsCharges.pdf == true %} active {% endif %} \">
                                    <input type=\"checkbox\" name=\"pdf\" {% if jsCharges.pdf == true %} checked {% endif %}  autocomplete=\"off\" value=\"on\"> <i class=\"fa fa-file-pdf-o\"></i>
                                </label>
                                <label class=\"not_focus btn btn-primary {% if jsCharges.excel == true %} active {% endif %}\">
                                    <input type=\"checkbox\" name=\"excel\"  {% if jsCharges.excel == true %} checked {% endif %} autocomplete=\"off\" value=\"on\">  <i class=\"fa fa-file-excel-o\"></i>
                                </label>
                                <label class=\"not_focus btn btn-primary {% if jsCharges.print == true %} active {% endif %}\">
                                    <input type=\"checkbox\" name=\"impression\" {% if jsCharges.print == true %} checked {% endif %}  autocomplete=\"off\" value=\"on\">  <i class=\"glyphicon glyphicon-print\"></i>
                                </label>
                            </div>

                        </div>   
                        <div class=\"row\">
                            <div class=\"checkbox col-sm-12\">
                                <label>
                                    <input type=\"checkbox\" name=\"control\" value=\"ok\"> controle donnee(modifier supprimer)
                                </label>
                            </div>
                        </div> 
                        <div class=\"row\">
                            <div class=\"col-sm-6\">
                                <select class=\"selectpicker show-tick\" data-style=\"btn-success\"  data-width=\"90%\" name=\"pere\">
                                    <option data-subtext=\"De père\"  {% if modeSelectpere == \"MASTER\" %} selected {% endif %}   value=\"resume\">voir résumé des information</option>
                                    <option data-subtext=\"De père\" {% if modeSelectpere == \"DEFAULT\" %} selected {% endif %}    value=\"defaut\">voir defaut des information</option>
                                    <option data-subtext=\"De père\" {% if modeSelectpere == \"ALL\" %} selected {% endif %}    value=\"tous\">voir tous les information</option>
                                </select>
                            </div>
                            <div class=\"col-sm-6\">
                                <select class=\"selectpicker show-tick\" data-style=\"btn-info\"  data-width=\"90%\" name=\"fils\">
                                    <option data-subtext=\"Des Fils\" {% if modeSelectenfant == \"EMPTY\" %} selected {% endif %} value=\"rien\">voir rien</option>
                                    <option data-subtext=\"Des Fils\" {% if modeSelectenfant == \"MASTER\" %} selected {% endif %} value=\"resume\">voir résumé des information</option>
                                    <option data-subtext=\"Des Fils\" {% if modeSelectenfant == \"DEFAULT\" %} selected {% endif %} value=\"defaut\">voir defaut des information</option>
                                    <option data-subtext=\"Des Fils\" {% if modeSelectenfant == \"ALL\" %} selected {% endif %} value=\"tous\">voir tous les information</option>
                                </select>
                            </div>
                        </div> 
                        <button type=\"submit\"  class=\"btn-primary btn\"> <span class=\"glyphicon glyphicon-repeat\" aria-hidden=\"true\"></span></button>
                    </form>
                </div><!-- /.modal-body -->
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

{% endblock %}", "@AbstractModules/plugins/showmode.twig", "/home/wassim/php/achatvent/App/AbstractModules/views/plugins/showmode.twig");
    }
}
