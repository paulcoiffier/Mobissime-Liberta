<?php

/* MainTpl.html */
class __TwigTemplate_e4be7d592d4551ddd22b67b4b61670997aee12f5cb0bd0c42d09a3a82701961a extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'header_block' => array($this, 'block_header_block'),
            'main_content' => array($this, 'block_main_content'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>

<head>

    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">

    <title>Mobissime Liberta</title>

    <link rel=\"icon\" href=\"../img/favicon.png\">
    <link rel=\"shortcut icon\" href=\"";
        // line 12
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/img/favicon.png\" type=\"image/x-icon\" />

    <link href=\"";
        // line 14
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/css/bootstrap.min.css\" rel=\"stylesheet\">
    <link href=\"";
        // line 15
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/font-awesome/css/font-awesome.css\" rel=\"stylesheet\">

    <!-- Toastr style -->
    <link href=\"";
        // line 18
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/css/plugins/toastr/toastr.min.css\" rel=\"stylesheet\">

    <!-- Morris -->
    <link href=\"";
        // line 21
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/css/plugins/morris/morris-0.4.3.min.css\" rel=\"stylesheet\">

    <!-- Bootstrap-Iconpicker -->
    <link rel=\"stylesheet\" href=\"";
        // line 24
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/css/bootstrap-iconpicker.min.css\"/>

    <!-- Gritter -->
    <!-- <link href=\"http://localhost/test/js/plugins/gritter/jquery.gritter.css\" rel=\"stylesheet\">-->

    <link href=\"";
        // line 29
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/css/animate.css\" rel=\"stylesheet\">
    <link href=\"";
        // line 30
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/css/style.css\" rel=\"stylesheet\">

    <!-- Mainly scripts -->
    <script src=\"";
        // line 33
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/jquery-2.1.1.js\"></script>
    <script src=\"";
        // line 34
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/bootstrap.min.js\"></script>
    <script src=\"";
        // line 35
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/plugins/metisMenu/jquery.metisMenu.js\"></script>
    <script src=\"";
        // line 36
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/plugins/slimscroll/jquery.slimscroll.min.js\"></script>

    <!-- Bootstrap-Iconpicker Iconset for Glyphicon -->
    <script type=\"text/javascript\" src=\"";
        // line 39
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/iconset/iconset-fontawesome-4.2.0.min.js\"></script>
    <!-- Bootstrap-Iconpicker -->
    <script type=\"text/javascript\" src=\"";
        // line 41
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/bootstrap-iconpicker.min.js\"></script>


    <script src=\"";
        // line 44
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/vendor/bootstrap-validator/bootstrap-validator-master/dist/validator.js\"></script>

    <!-- Data Tables -->
    <script src=\"";
        // line 47
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/plugins/dataTables/jquery.dataTables.min.js\"></script>
    <script src=\"";
        // line 48
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/plugins/dataTables/dataTables.bootstrap.js\"></script>
    <script src=\"";
        // line 49
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/plugins/dataTables/dataTables.responsive.js\"></script>
    <script src=\"";
        // line 50
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/plugins/dataTables/dataTables.tableTools.min.js\"></script>

    <link href=\"";
        // line 52
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/css/plugins/dataTables/dataTables.bootstrap.css\" rel=\"stylesheet\">
    <link href=\"";
        // line 53
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/css/plugins/dataTables/dataTables.responsive.css\" rel=\"stylesheet\">
    <link href=\"";
        // line 54
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/css/plugins/dataTables/dataTables.tableTools.min.css\" rel=\"stylesheet\">

    <!-- Steps -->
    <script src=\"";
        // line 57
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/plugins/staps/jquery.steps.min.js\"></script>
    <link href=\"";
        // line 58
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/css/plugins/steps/jquery.steps.css\" rel=\"stylesheet\">

    <!-- Jquery Validate -->
    <script src=\"";
        // line 61
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/plugins/validate/jquery.validate.min.js\"></script>


    <link href=\"";
        // line 64
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/css/uploadfile.min.css\" rel=\"stylesheet\">
    <script src=\"";
        // line 65
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/jquery.uploadfile.min.js\"></script>

    <!-- Toastr script -->
    <script src=\"";
        // line 68
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/plugins/toastr/toastr.min.js\"></script>

    <!-- Liberta Javascript Libs -->
    <script src=\"";
        // line 71
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/src/App/Js/Libs.js\"></script>

    <!-- Custom and plugin javascript -->
    <script src=\"";
        // line 74
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/inspinia.js\"></script>

</head>


<body>
<input type=\"hidden\" name=\"install_url\" id=\"install_url\" value=\"";
        // line 80
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "\">

<div id=\"wrapper\">
    <div id=\"leftMenuDiv\">
    ";
        // line 84
        $this->loadTemplate((isset($context["menuLeft"]) ? $context["menuLeft"] : null), "MainTpl.html", 84)->display($context);
        // line 85
        echo "    </div>

    <div id=\"page-wrapper\" class=\"gray-bg dashbard-1\">
        <div class=\"row border-bottom\">
            ";
        // line 89
        $this->loadTemplate((isset($context["navBar"]) ? $context["navBar"] : null), "MainTpl.html", 89)->display($context);
        // line 90
        echo "        </div>
        ";
        // line 91
        $this->displayBlock('header_block', $context, $blocks);
        // line 92
        echo "
        <div class=\"row\">
            <div class=\"col-lg-12\">
                <div class=\"wrapper wrapper-content\">
                    ";
        // line 96
        $this->displayBlock('main_content', $context, $blocks);
        // line 97
        echo "                    <?php include 'include/navigation/routes.php'; ?>
                </div>
                <div class=\"footer\">
                    <div class=\"pull-right\">
                        beta 1.0
                    </div>
                    <div>
                        <strong>Copyright</strong> Mobissime &copy; 2014-2015
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<!-- Flot -->
<!--<script src=\"http://localhost/test/js/plugins/flot/jquery.flot.js\"></script>
<script src=\"http://localhost/test/js/plugins/flot/jquery.flot.tooltip.min.js\"></script>
<script src=\"http://localhost/test/js/plugins/flot/jquery.flot.spline.js\"></script>
<script src=\"http://localhost/test/js/plugins/flot/jquery.flot.resize.js\"></script>
<script src=\"http://localhost/test/js/plugins/flot/jquery.flot.pie.js\"></script> -->

<!-- Peity -->
<!--<script src=\"http://localhost/test/js/plugins/peity/jquery.peity.min.js\"></script>
<script src=\"http://localhost/test/js/demo/peity-demo.js\"></script>-->


<script src=\"";
        // line 126
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/plugins/pace/pace.min.js\"></script>

<!-- jQuery UI -->
<script src=\"";
        // line 129
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/plugins/jquery-ui/jquery-ui.min.js\"></script>

<!-- GITTER -->
<!--<script src=\"http://localhost/test/js/plugins/gritter/jquery.gritter.min.js\"></script>-->

<!-- EayPIE -->
<!--<script src=\"http://localhost/test/js/plugins/easypiechart/jquery.easypiechart.js\"></script>-->

<!-- Sparkline -->
<!--<script src=\"http://localhost/test/js/plugins/sparkline/jquery.sparkline.min.js\"></script>-->

<!-- Sparkline demo data  -->
<!--<script src=\"http://localhost/test/js/demo/sparkline-demo.js\"></script>-->

<!-- ChartJS-->
<!--<script src=\"http://localhost/test/js/plugins/chartJs/Chart.min.js\"></script>-->

<script src=\"";
        // line 146
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/js/index.js\"></script>
</body>
</html>
";
    }

    // line 91
    public function block_header_block($context, array $blocks = array())
    {
    }

    // line 96
    public function block_main_content($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "MainTpl.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  292 => 96,  287 => 91,  279 => 146,  259 => 129,  253 => 126,  222 => 97,  220 => 96,  214 => 92,  212 => 91,  209 => 90,  207 => 89,  201 => 85,  199 => 84,  192 => 80,  183 => 74,  177 => 71,  171 => 68,  165 => 65,  161 => 64,  155 => 61,  149 => 58,  145 => 57,  139 => 54,  135 => 53,  131 => 52,  126 => 50,  122 => 49,  118 => 48,  114 => 47,  108 => 44,  102 => 41,  97 => 39,  91 => 36,  87 => 35,  83 => 34,  79 => 33,  73 => 30,  69 => 29,  61 => 24,  55 => 21,  49 => 18,  43 => 15,  39 => 14,  34 => 12,  21 => 1,);
    }
}
