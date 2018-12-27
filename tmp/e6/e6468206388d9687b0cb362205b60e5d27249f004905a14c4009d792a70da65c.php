<?php

/* theme_1/navigation/static/NAVBAR.twig */
class __TwigTemplate_1bf5b2515c05ce99bf5073a73b2ccf01ccfc3ef7eb61f6140e4c98265a723fd4 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
            'static' => array($this, 'block_static'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "


";
        // line 4
        $this->displayBlock('static', $context, $blocks);
        // line 48
        echo "














";
    }

    // line 4
    public function block_static($context, array $blocks = array())
    {
        // line 5
        echo "    ";
        $context["item"] = $this->loadTemplate("macro/item.twig", "theme_1/navigation/static/NAVBAR.twig", 5);
        // line 6
        echo "



    ";
        // line 10
        $context['_parent'] = $context;
        $context['_seq'] = twig_ensure_traversable(($context["_menu"] ?? null));
        foreach ($context['_seq'] as $context["_key"] => $context["nav_menu"]) {
            // line 11
            echo "

        <li>

            <a href=\"javascript:;\">


                <span class=\"nav-icon\">
                    <i class=\"";
            // line 19
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["nav_menu"], "nav_icon", array()), "html", null, true);
            echo "\"></i>  
                </span>


                <span class=\"nav-title\">";
            // line 23
            echo twig_escape_filter($this->env, twig_get_attribute($this->env, $this->source, $context["nav_menu"], "nav_title", array()), "html", null, true);
            echo "</span>
                <span class=\"nav-tools\">
                    <i class=\"fa fa-fw arrow\"></i>
                </span>
            </a>
            <ul class=\"nav nav-second-level\">


                ";
            // line 31
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable(twig_get_attribute($this->env, $this->source, $context["nav_menu"], "nav", array()));
            foreach ($context['_seq'] as $context["label"] => $context["url"]) {
                // line 32
                echo "
                    ";
                // line 33
                echo $context["item"]->macro_li_a($context["url"], $context["label"]);
                echo "

                ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['label'], $context['url'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 36
            echo "
            </ul>



        </li> 


    ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['nav_menu'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 44
        echo " 


";
    }

    public function getTemplateName()
    {
        return "theme_1/navigation/static/NAVBAR.twig";
    }

    public function getDebugInfo()
    {
        return array (  124 => 44,  110 => 36,  101 => 33,  98 => 32,  94 => 31,  83 => 23,  76 => 19,  66 => 11,  62 => 10,  56 => 6,  53 => 5,  50 => 4,  31 => 48,  29 => 4,  24 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("


{% block static %}
    {% import \"macro/item.twig\" as item %}




    {% for nav_menu in _menu   %}


        <li>

            <a href=\"javascript:;\">


                <span class=\"nav-icon\">
                    <i class=\"{{ nav_menu.nav_icon}}\"></i>  
                </span>


                <span class=\"nav-title\">{{ nav_menu.nav_title }}</span>
                <span class=\"nav-tools\">
                    <i class=\"fa fa-fw arrow\"></i>
                </span>
            </a>
            <ul class=\"nav nav-second-level\">


                {% for label, url in nav_menu.nav %}

                    {{ item.li_a(url,label) }}

                {% endfor %}

            </ul>



        </li> 


    {% endfor %} 


{% endblock %}















", "theme_1/navigation/static/NAVBAR.twig", "/home/wassim/php/achatvent/App/TEMPLETE/theme_1/navigation/static/NAVBAR.twig");
    }
}
