<?php

/* themes.twig */
class __TwigTemplate_89b79452fae3aa2355ecc4b615ee295d2e32cf94037a5c953ea3e56cdf8e8ac8 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("theme_1/template.twig", "themes.twig", 1);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "theme_1/template.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "themes.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% extends \"theme_1/template.twig\" %}






", "themes.twig", "/home/wassim/php/achatvent/App/TEMPLETE/themes.twig");
    }
}
