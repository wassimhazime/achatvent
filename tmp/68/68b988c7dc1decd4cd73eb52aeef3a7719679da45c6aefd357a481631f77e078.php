<?php

/* theme_1/navigation/header/NAVBAR.twig */
class __TwigTemplate_25d289e2c5490d66da002d5331b3d9b9c61c746eb23618042a08436863ec8d0a extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
            'header' => array($this, 'block_header'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 2
        echo " ";
        $this->displayBlock('header', $context, $blocks);
        // line 15
        echo " ";
    }

    // line 2
    public function block_header($context, array $blocks = array())
    {
        // line 3
        echo "   
        <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
          <span class=\"sr-only\">Toggle navigation</span>
          <span class=\"icon-bar\"></span>
          <span class=\"icon-bar\"></span>
          <span class=\"icon-bar\"></span>
        </button>
     
        <a class=\"navbar-brand\" href=\"index.html\">hope dripe</a>
    
 
 ";
    }

    public function getTemplateName()
    {
        return "theme_1/navigation/header/NAVBAR.twig";
    }

    public function getDebugInfo()
    {
        return array (  34 => 3,  31 => 2,  27 => 15,  24 => 2,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{# empty Twig template #}
 {% block header %}
   
        <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\".navbar-collapse\">
          <span class=\"sr-only\">Toggle navigation</span>
          <span class=\"icon-bar\"></span>
          <span class=\"icon-bar\"></span>
          <span class=\"icon-bar\"></span>
        </button>
     
        <a class=\"navbar-brand\" href=\"index.html\">hope dripe</a>
    
 
 {% endblock %}
 ", "theme_1/navigation/header/NAVBAR.twig", "/home/wassim/php/achatvent/App/TEMPLETE/theme_1/navigation/header/NAVBAR.twig");
    }
}
