<?php

/* HeaderTpl.html */
class __TwigTemplate_75370503c758b38d3b13d5936520a7942f146c55040d333747e61f2ee993b93f extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'header_title' => array($this, 'block_header_title'),
            'header_link_page' => array($this, 'block_header_link_page'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<div class=\"row wrapper border-bottom white-bg page-heading\">
    <div class=\"col-sm-4\">
        <h2>";
        // line 3
        $this->displayBlock('header_title', $context, $blocks);
        echo "</h2>
        <ol class=\"breadcrumb\">
            <li>
                <a href=\"index.php\">";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["app_words"]) ? $context["app_words"] : null), "home", array()), "html", null, true);
        echo "</a>
            </li>
            <li class=\"active\">
                <a href=\"index.php?module=mycrm_modules\"><strong>";
        // line 9
        $this->displayBlock('header_link_page', $context, $blocks);
        echo "</strong></a>
            </li>
        </ol>
    </div>
</div>";
    }

    // line 3
    public function block_header_title($context, array $blocks = array())
    {
    }

    // line 9
    public function block_header_link_page($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "HeaderTpl.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  51 => 9,  46 => 3,  37 => 9,  31 => 6,  25 => 3,  21 => 1,);
    }
}
