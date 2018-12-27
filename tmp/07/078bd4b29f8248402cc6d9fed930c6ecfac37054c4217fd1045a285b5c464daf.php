<?php

/* @AbstractModules/plugins/progress.twig */
class __TwigTemplate_3c33bcdea3c9b06de80ba9e5a9477261babdc4a1540b682801ba8033e75ee26d extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = array(
            'progress' => array($this, 'block_progress'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        $this->displayBlock('progress', $context, $blocks);
    }

    public function block_progress($context, array $blocks = array())
    {
        // line 2
        echo "<i id=\"refresh\" class=\"fa fa-refresh fa-spin center hidden\" style=\"font-size:100px\"></i>

    <!-- Modal -->
    <div class=\"modal fade\" id=\"ModalProgress\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
        <div class=\"modal-dialog\" role=\"document\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                    <h4 class=\"modal-title\" id=\"myModalLabel\"><i class=\"fa fa-refresh fa-spin center\" style=\"font-size:24px\"></i></h4>
                </div>
                <div class=\"modal-body\">
                    <div  id=\"progresshidden\" >
                        <spam id=\"messageprogressBar\"></spam>
                        <spam id=\"etat\"></spam>
                        <div class=\"progress \" >
                            <div class=\"progress-bar\" id=\"progressBar\"role=\"progressbar\"  aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 0%;\">
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

";
    }

    public function getTemplateName()
    {
        return "@AbstractModules/plugins/progress.twig";
    }

    public function getDebugInfo()
    {
        return array (  30 => 2,  24 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("{% block progress %}
<i id=\"refresh\" class=\"fa fa-refresh fa-spin center hidden\" style=\"font-size:100px\"></i>

    <!-- Modal -->
    <div class=\"modal fade\" id=\"ModalProgress\" tabindex=\"-1\" role=\"dialog\" aria-labelledby=\"myModalLabel\">
        <div class=\"modal-dialog\" role=\"document\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>
                    <h4 class=\"modal-title\" id=\"myModalLabel\"><i class=\"fa fa-refresh fa-spin center\" style=\"font-size:24px\"></i></h4>
                </div>
                <div class=\"modal-body\">
                    <div  id=\"progresshidden\" >
                        <spam id=\"messageprogressBar\"></spam>
                        <spam id=\"etat\"></spam>
                        <div class=\"progress \" >
                            <div class=\"progress-bar\" id=\"progressBar\"role=\"progressbar\"  aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: 0%;\">
                            </div>
                        </div>
                    </div>
                </div>

            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

{% endblock %}", "@AbstractModules/plugins/progress.twig", "/home/wassim/php/achatvent/App/AbstractModules/views/plugins/progress.twig");
    }
}
