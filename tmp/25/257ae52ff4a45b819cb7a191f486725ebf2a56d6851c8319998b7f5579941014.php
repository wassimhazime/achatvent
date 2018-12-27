<?php

/* @Produitmarques/show.twig */
class __TwigTemplate_bbf12711fcda84ecfb1fa31e6725b30b342ab3776dc59e441add930d0e3a60ad extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("@AbstractModules/show.twig", "@Produitmarques/show.twig", 1);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "@AbstractModules/show.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "@Produitmarques/show.twig";
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
        return new Twig_Source("{% extends \"@AbstractModules/show.twig\" %}


", "@Produitmarques/show.twig", "/home/wassim/php/achatvent/App/Modules/Produit/views/marques/show.twig");
    }
}
