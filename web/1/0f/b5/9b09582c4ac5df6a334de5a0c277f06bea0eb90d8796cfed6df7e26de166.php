<?php

/* NavBar.html */
class __TwigTemplate_0fb59b09582c4ac5df6a334de5a0c277f06bea0eb90d8796cfed6df7e26de166 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<nav class=\"navbar navbar-static-top\" role=\"navigation\" style=\"margin-bottom: 0\">
    <div class=\"navbar-header\">
        <a class=\"navbar-minimalize minimalize-styl-2 btn btn-primary \" href=\"#\"><i class=\"fa fa-bars\"></i> </a>
        <form role=\"search\" class=\"navbar-form-custom\" method=\"post\" action=\"search_results.html\">
            <div class=\"form-group\">
                <input type=\"text\" placeholder=\"Search for something...\" class=\"form-control\" name=\"top-search\" id=\"top-search\">
            </div>
        </form>
    </div>
    <ul class=\"nav navbar-top-links navbar-right\">
        <!--<li>
            <span class=\"m-r-sm text-muted welcome-message\">Welcome to INSPINIA+ Admin Theme.</span>
        </li> -->
        <li class=\"dropdown\">
            <a class=\"dropdown-toggle count-info\" data-toggle=\"dropdown\" href=\"#\">
                <i class=\"fa fa-envelope\"></i>  <span class=\"label label-warning\">0</span>
            </a>
            <ul class=\"dropdown-menu dropdown-messages\">
                <li>
                    <div class=\"dropdown-messages-box\">
                        <a href=\"profile.html\" class=\"pull-left\">
                            <img alt=\"image\" class=\"img-circle\" src=\"";
        // line 22
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/img/a7.jpg\">
                        </a>
                        <div class=\"media-body\">
                            <small class=\"pull-right\">46h ago</small>
                            <strong>Mike Loreipsum</strong> started following <strong>Monica Smith</strong>. <br>
                            <small class=\"text-muted\">3 days ago at 7:58 pm - 10.06.2014</small>
                        </div>
                    </div>
                </li>
                <li class=\"divider\"></li>
                <li>
                    <div class=\"dropdown-messages-box\">
                        <a href=\"profile.html\" class=\"pull-left\">
                            <img alt=\"image\" class=\"img-circle\" src=\"";
        // line 35
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/img/a4.jpg\">
                        </a>
                        <div class=\"media-body \">
                            <small class=\"pull-right text-navy\">5h ago</small>
                            <strong>Chris Johnatan Overtunk</strong> started following <strong>Monica Smith</strong>. <br>
                            <small class=\"text-muted\">Yesterday 1:21 pm - 11.06.2014</small>
                        </div>
                    </div>
                </li>
                <li class=\"divider\"></li>
                <li>
                    <div class=\"dropdown-messages-box\">
                        <a href=\"profile.html\" class=\"pull-left\">
                            <img alt=\"image\" class=\"img-circle\" src=\"";
        // line 48
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/img/profile.jpg\">
                        </a>
                        <div class=\"media-body \">
                            <small class=\"pull-right\">23h ago</small>
                            <strong>Monica Smith</strong> love <strong>Kim Smith</strong>. <br>
                            <small class=\"text-muted\">2 days ago at 2:30 am - 11.06.2014</small>
                        </div>
                    </div>
                </li>
                <li class=\"divider\"></li>
                <li>
                    <div class=\"text-center link-block\">
                        <a href=\"mailbox.html\">
                            <i class=\"fa fa-envelope\"></i> <strong>Read All Messages</strong>
                        </a>
                    </div>
                </li>
            </ul>
        </li>
        <li class=\"dropdown\">
            <a class=\"dropdown-toggle count-info\" data-toggle=\"dropdown\" href=\"#\">
                <i class=\"fa fa-bell\"></i>  <span class=\"label label-primary\">0</span>
            </a>
            <ul class=\"dropdown-menu dropdown-alerts\">
                <li>
                    <a href=\"mailbox.html\">
                        <div>
                            <i class=\"fa fa-envelope fa-fw\"></i> You have 0 messages
                            <span class=\"pull-right text-muted small\">1 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class=\"divider\"></li>
                <li>
                    <a href=\"profile.html\">
                        <div>
                            <i class=\"fa fa-twitter fa-fw\"></i> 3 New Followers
                            <span class=\"pull-right text-muted small\">12 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class=\"divider\"></li>
                <li>
                    <a href=\"grid_options.html\">
                        <div>
                            <i class=\"fa fa-upload fa-fw\"></i> Server Rebooted
                            <span class=\"pull-right text-muted small\">4 minutes ago</span>
                        </div>
                    </a>
                </li>
                <li class=\"divider\"></li>
                <li>
                    <div class=\"text-center link-block\">
                        <a href=\"notifications.html\">
                            <strong>See All Alerts</strong>
                            <i class=\"fa fa-angle-right\"></i>
                        </a>
                    </div>
                </li>
            </ul>
        </li>


        <li>
            <a href=\"index.php?link=logout\">
                <i class=\"fa fa-sign-out\"></i> ";
        // line 113
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["app_words"]) ? $context["app_words"] : null), "logout", array()), "html", null, true);
        echo "
            </a>
        </li>
    </ul>

</nav>";
    }

    public function getTemplateName()
    {
        return "NavBar.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  142 => 113,  74 => 48,  58 => 35,  42 => 22,  19 => 1,);
    }
}
