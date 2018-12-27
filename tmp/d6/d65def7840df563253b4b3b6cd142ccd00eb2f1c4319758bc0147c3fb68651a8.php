<?php

/* @Produitmarques/show_item.twig */
class __TwigTemplate_5a08435c5520dbec23273cb55c8d996bcd7f553ee533b2b37a077dd1c7334f6c extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("@AbstractModules/show_item.twig", "@Produitmarques/show_item.twig", 1);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "@AbstractModules/show_item.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "@Produitmarques/show_item.twig";
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
        return new Twig_Source("{% extends \"@AbstractModules/show_item.twig\" %}





", "@Produitmarques/show_item.twig", "/home/wassim/php/achatvent/App/Modules/Produit/views/marques/show_item.twig");
    }
}
