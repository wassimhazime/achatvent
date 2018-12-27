<?php

/* @AbstractModules/show_item.twig */
class __TwigTemplate_bcd8d910489c537786e3063684fe8fde65498b2742fdaa53c6f43bde14e6d26f extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo $this->extensions['Kernel\Renderer\Twig_Extension\Form']->Form_view(($context["intent"] ?? null));
        echo "  
";
    }

    public function getTemplateName()
    {
        return "@AbstractModules/show_item.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  23 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{{Form_view(intent)}}  
", "@AbstractModules/show_item.twig", "/home/wassim/php/achatvent/App/AbstractModules/views/show_item.twig");
    }
}
