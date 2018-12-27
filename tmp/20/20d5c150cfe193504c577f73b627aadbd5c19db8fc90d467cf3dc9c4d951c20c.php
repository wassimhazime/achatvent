<?php

/* theme_1/navigation/navigation.twig */
class __TwigTemplate_af7aa729b27f762a88de977b336084ac3d6173416376fc03e23b3d4586e81cf9 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $_trait_0 = $this->loadTemplate("theme_1/navigation/header/NAVBAR.twig", "theme_1/navigation/navigation.twig", 2);
        // line 2
        if (!$_trait_0->isTraitable()) {
            throw new Twig_Error_Runtime('Template "'."theme_1/navigation/header/NAVBAR.twig".'" cannot be used as a trait.', 2, $this->source);
        }
        $_trait_0_blocks = $_trait_0->getBlocks();

        $_trait_1 = $this->loadTemplate("theme_1/navigation/static/NAVBAR.twig", "theme_1/navigation/navigation.twig", 3);
        // line 3
        if (!$_trait_1->isTraitable()) {
            throw new Twig_Error_Runtime('Template "'."theme_1/navigation/static/NAVBAR.twig".'" cannot be used as a trait.', 3, $this->source);
        }
        $_trait_1_blocks = $_trait_1->getBlocks();

        $_trait_2 = $this->loadTemplate("theme_1/navigation/top/NAVBAR.twig", "theme_1/navigation/navigation.twig", 4);
        // line 4
        if (!$_trait_2->isTraitable()) {
            throw new Twig_Error_Runtime('Template "'."theme_1/navigation/top/NAVBAR.twig".'" cannot be used as a trait.', 4, $this->source);
        }
        $_trait_2_blocks = $_trait_2->getBlocks();

        $this->traits = array_merge(
            $_trait_0_blocks,
            $_trait_1_blocks,
            $_trait_2_blocks
        );

        $this->blocks = array_merge(
            $this->traits,
            array(
                'Navigation' => array($this, 'block_Navigation'),
            )
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "
";
        // line 5
        echo "
";
        // line 6
        $this->displayBlock('Navigation', $context, $blocks);
        // line 42
        echo "



";
    }

    // line 6
    public function block_Navigation($context, array $blocks = array())
    {
        // line 7
        echo "
    <!-- Navigation -->
    <nav class=\"navbar navbar-default navbar-static-top navbar-fixed-top\" role=\"navigation\" style=\"margin-bottom: 0\">
      <!-- .navbar-header -->
      <div class=\"navbar-header\">
        ";
        // line 12
        $this->displayBlock("header", $context, $blocks);
        echo "
      </div>
      <!-- /.navbar-header -->


      <!-- .navbar-top-links -->
      <ul class=\"nav navbar-top-links navbar-right\">
        ";
        // line 19
        $this->displayBlock("top", $context, $blocks);
        echo "
      </ul>
      <!-- /.navbar-top-links -->


      <!-- .navbar-static-side -->
      <div class=\"navbar-default sidebar\" role=\"navigation\" >
        <div class=\"sidebar-nav navbar-collapse\">

          <ul class=\"nav\" id=\"side-menu\">
            ";
        // line 29
        $this->displayBlock("static", $context, $blocks);
        echo "
          </ul>

        </div>
        <!-- /.sidebar-collapse -->
      </div>
      <!-- /.navbar-static-side -->
    </nav>




";
    }

    public function getTemplateName()
    {
        return "theme_1/navigation/navigation.twig";
    }

    public function getDebugInfo()
    {
        return array (  103 => 29,  90 => 19,  80 => 12,  73 => 7,  70 => 6,  62 => 42,  60 => 6,  57 => 5,  54 => 1,  32 => 4,  25 => 3,  18 => 2,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("
{% use \"theme_1/navigation/header/NAVBAR.twig\" %}
{% use \"theme_1/navigation/static/NAVBAR.twig\" %}
{% use \"theme_1/navigation/top/NAVBAR.twig\" %}

{% block Navigation %}

    <!-- Navigation -->
    <nav class=\"navbar navbar-default navbar-static-top navbar-fixed-top\" role=\"navigation\" style=\"margin-bottom: 0\">
      <!-- .navbar-header -->
      <div class=\"navbar-header\">
        {{ block('header') }}
      </div>
      <!-- /.navbar-header -->


      <!-- .navbar-top-links -->
      <ul class=\"nav navbar-top-links navbar-right\">
        {{ block('top') }}
      </ul>
      <!-- /.navbar-top-links -->


      <!-- .navbar-static-side -->
      <div class=\"navbar-default sidebar\" role=\"navigation\" >
        <div class=\"sidebar-nav navbar-collapse\">

          <ul class=\"nav\" id=\"side-menu\">
            {{ block('static') }}
          </ul>

        </div>
        <!-- /.sidebar-collapse -->
      </div>
      <!-- /.navbar-static-side -->
    </nav>




{% endblock %}




", "theme_1/navigation/navigation.twig", "/home/wassim/php/achatvent/App/TEMPLETE/theme_1/navigation/navigation.twig");
    }
}
