<?php

/* @Produitmarques/ajouter_form.twig */
class __TwigTemplate_b3cf3d26089dcb2e51f24ce917fb875f18aaec5452ff980f62e732be5be664ab extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("@AbstractModules/ajouter_form.twig", "@Produitmarques/ajouter_form.twig", 1);
        $this->blocks = array(
        );
    }

    protected function doGetParent(array $context)
    {
        return "@AbstractModules/ajouter_form.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    public function getTemplateName()
    {
        return "@Produitmarques/ajouter_form.twig";
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
        return new Twig_Source("{% extends \"@AbstractModules/ajouter_form.twig\" %}

", "@Produitmarques/ajouter_form.twig", "/home/wassim/php/achatvent/App/Modules/Produit/views/marques/ajouter_form.twig");
    }
}
