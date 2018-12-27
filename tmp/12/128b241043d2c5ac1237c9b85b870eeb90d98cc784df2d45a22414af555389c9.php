<?php

/* macro/item.twig */
class __TwigTemplate_f798ae4fa0316beb184f485a8001fcbb44c147e943179fb509ed630b4a594101 extends Twig_Template
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
        // line 2
        echo "
";
        // line 10
        echo "
";
    }

    // line 3
    public function macro_li_a($__name__ = null, $__lable__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "name" => $__name__,
            "lable" => $__lable__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 4
            echo "
    <li>
      <a href=\"";
            // line 6
            echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
            echo "\">";
            echo twig_escape_filter($this->env, ($context["lable"] ?? null), "html", null, true);
            echo "</a>
    </li>

";

            return ('' === $tmp = ob_get_contents()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        } finally {
            ob_end_clean();
        }
    }

    // line 11
    public function macro_input($__name__ = null, $__value__ = null, $__type__ = null, $__size__ = null, ...$__varargs__)
    {
        $context = $this->env->mergeGlobals(array(
            "name" => $__name__,
            "value" => $__value__,
            "type" => $__type__,
            "size" => $__size__,
            "varargs" => $__varargs__,
        ));

        $blocks = array();

        ob_start();
        try {
            // line 12
            echo "    <input type=\"";
            echo twig_escape_filter($this->env, (((isset($context["type"]) || array_key_exists("type", $context))) ? (_twig_default_filter(($context["type"] ?? null), "text")) : ("text")), "html", null, true);
            echo "\" name=\"";
            echo twig_escape_filter($this->env, ($context["name"] ?? null), "html", null, true);
            echo "\" value=\"";
            echo twig_escape_filter($this->env, ($context["value"] ?? null));
            echo "\" size=\"";
            echo twig_escape_filter($this->env, (((isset($context["size"]) || array_key_exists("size", $context))) ? (_twig_default_filter(($context["size"] ?? null), 20)) : (20)), "html", null, true);
            echo "\" />
";

            return ('' === $tmp = ob_get_contents()) ? '' : new Twig_Markup($tmp, $this->env->getCharset());
        } finally {
            ob_end_clean();
        }
    }

    public function getTemplateName()
    {
        return "macro/item.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  78 => 12,  63 => 11,  48 => 6,  44 => 4,  31 => 3,  26 => 10,  23 => 2,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{# empty Twig template #}

{% macro li_a(name,lable) %}

    <li>
      <a href=\"{{name}}\">{{lable}}</a>
    </li>

{% endmacro%}

{% macro input(name, value, type, size) %}
    <input type=\"{{ type|default('text') }}\" name=\"{{ name }}\" value=\"{{ value|e }}\" size=\"{{ size|default(20) }}\" />
{% endmacro %}", "macro/item.twig", "/home/wassim/php/achatvent/App/TEMPLETE/macro/item.twig");
    }
}
