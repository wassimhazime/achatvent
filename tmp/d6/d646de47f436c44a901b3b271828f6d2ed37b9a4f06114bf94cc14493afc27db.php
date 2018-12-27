<?php

/* @Produitfamilles$des$articles/show.twig */
class __TwigTemplate_6d8ca96c5071da05c26791cc72ed2f6592636fa009348a7280d964a0c49b3546 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("@AbstractModules/show.twig", "@Produitfamilles\$des\$articles/show.twig", 1);
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
        return "@Produitfamilles\$des\$articles/show.twig";
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


", "@Produitfamilles\$des\$articles/show.twig", "/home/wassim/php/achatvent/App/Modules/Produit/views/familles\$des\$articles/show.twig");
    }
}
