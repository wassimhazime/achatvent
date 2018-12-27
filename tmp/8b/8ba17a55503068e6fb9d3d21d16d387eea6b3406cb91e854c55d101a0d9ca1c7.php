<?php

/* theme_1/template.twig */
class __TwigTemplate_7a388e2a4e744a0f5c2e8d84ee0712c46c46945425e5e35605ea437d5fae5c32 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("theme_1/stricture.twig", "theme_1/template.twig", 1);
        $_trait_0 = $this->loadTemplate("theme_1/navigation/navigation.twig", "theme_1/template.twig", 3);
        // line 3
        if (!$_trait_0->isTraitable()) {
            throw new Twig_Error_Runtime('Template "'."theme_1/navigation/navigation.twig".'" cannot be used as a trait.', 3, $this->source);
        }
        $_trait_0_blocks = $_trait_0->getBlocks();

        $this->traits = $_trait_0_blocks;

        $this->blocks = array_merge(
            $this->traits,
            array(
                'container' => array($this, 'block_container'),
            )
        );
    }

    protected function doGetParent(array $context)
    {
        // line 1
        return "theme_1/stricture.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 8
    public function block_container($context, array $blocks = array())
    {
        // line 9
        echo "
";
    }

    public function getTemplateName()
    {
        return "theme_1/template.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  48 => 9,  45 => 8,  36 => 1,  18 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"theme_1/stricture.twig\" %}

{% use \"theme_1/navigation/navigation.twig\" %}




{% block container %}

{% endblock %}




", "theme_1/template.twig", "/home/wassim/php/achatvent/App/TEMPLETE/theme_1/template.twig");
    }
}
