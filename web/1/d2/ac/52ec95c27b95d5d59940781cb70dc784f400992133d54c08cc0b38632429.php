<?php

/* Menu_left.html */
class __TwigTemplate_d2ac52ec95c27b95d5d59940781cb70dc784f400992133d54c08cc0b38632429 extends Twig_Template
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
        echo "<nav class=\"navbar-default navbar-static-side\" role=\"navigation\">
    <div class=\"sidebar-collapse\">
        <ul class=\"nav\" id=\"side-menu\">
            <li class=\"nav-header\">
                <div class=\"dropdown profile-element\"> <span>
                            <img alt=\"image\" class=\"img-circle\"
                                 src=\"";
        // line 7
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "/data/users_profiles/";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "id", array()), "html", null, true);
        echo "_small.png\"/>
                             </span>
                    <a data-toggle=\"dropdown\" class=\"dropdown-toggle\" href=\"#\">
                            <span class=\"clear\"> <span class=\"block m-t-xs\"> <strong
                                    class=\"font-bold\">";
        // line 11
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "usr_first_name", array()), "html", null, true);
        echo " ";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "usr_last_name", array()), "html", null, true);
        echo "</strong>
                             </span> <span class=\"text-muted text-xs block\">";
        // line 12
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "usr_function", array()), "html", null, true);
        echo " <b
                                    class=\"caret\"></b></span> </span> </a>
                    <ul class=\"dropdown-menu animated fadeInRight m-t-xs\">
                        <li><a href=\"";
        // line 15
        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
        echo "web/front.php/profile\">";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["app_words"]) ? $context["app_words"] : null), "profile", array()), "html", null, true);
        echo "</a></li>
                        <li><a href=\"contacts.html\">";
        // line 16
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["app_words"]) ? $context["app_words"] : null), "contacts", array()), "html", null, true);
        echo "</a></li>
                        <li><a href=\"mailbox.html\">";
        // line 17
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["app_words"]) ? $context["app_words"] : null), "mailbox", array()), "html", null, true);
        echo "</a></li>
                        <li class=\"divider\"></li>
                        <li><a href=\"index.php?link=logout\">";
        // line 19
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["app_words"]) ? $context["app_words"] : null), "logout", array()), "html", null, true);
        echo "</a></li>
                    </ul>
                </div>
                <div class=\"logo-element\">
                    MyCRM
                </div>
            </li>


            ";
        // line 28
        if (((isset($context["routeName"]) ? $context["routeName"] : null) == "app")) {
            // line 29
            echo "            <li class=\"active\"><a href=\"";
            echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
            echo "/web/front.php/app\"><i class=\"fa fa-home\"></i> <span
                    class=\"nav-label\">";
            // line 30
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["app_words"]) ? $context["app_words"] : null), "home", array()), "html", null, true);
            echo "</span> </a></li>
            ";
        } else {
            // line 32
            echo "            <li><a href=\"";
            echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
            echo "/web/front.php/app\"><i class=\"fa fa-home\"></i> <span
                    class=\"nav-label\">";
            // line 33
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["app_words"]) ? $context["app_words"] : null), "home", array()), "html", null, true);
            echo "</span> </a></li>
            ";
        }
        // line 35
        echo "
            <!-- Mailbox menu -->
            <!--<li>
                <a href=\"mailbox.html\"><i class=\"fa fa-envelope\"></i> <span class=\"nav-label\">Mailbox </span><span
                        class=\"label label-warning pull-right\">16/24</span></a>
                <ul class=\"nav nav-second-level\">
                    <li><a href=\"mailbox.html\">Inbox</a></li>
                    <li><a href=\"mail_detail.html\">Email view</a></li>
                    <li><a href=\"mail_compose.html\">Compose email</a></li>
                    <li><a href=\"email_template.html\">Email templates</a></li>
                </ul>
            </li> -->

            ";
        // line 48
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["menus"]) ? $context["menus"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["menu"]) {
            // line 49
            echo "            ";
            if ((twig_length_filter($this->env, $this->getAttribute($context["menu"], "menuItems", array())) > 0)) {
                // line 50
                echo "            <!-- Show a dropdown -->
            <li id=\"dropDownMenu\" name=\"dropDownMenu\">
                <a href=\"";
                // line 52
                echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
                echo "/web/front.php/";
                echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["menu"], "module", array()), "mod_route", array()), "html", null, true);
                echo "\"><i
                        class=\"fa ";
                // line 53
                echo twig_escape_filter($this->env, $this->getAttribute($context["menu"], "menu_font_awesome_icon", array()), "html", null, true);
                echo "\"></i><span
                        class=\"nav-label\">";
                // line 54
                echo twig_escape_filter($this->env, $this->getAttribute($context["menu"], "menu_name", array()), "html", null, true);
                echo " </span></a>
                <ul class=\"nav nav-second-level\">
                    ";
                // line 56
                $context['_parent'] = (array) $context;
                $context['_seq'] = twig_ensure_traversable($this->getAttribute($context["menu"], "menuItems", array()));
                foreach ($context['_seq'] as $context["_key"] => $context["menuItem"]) {
                    // line 57
                    echo "                    ";
                    if (((isset($context["routeName"]) ? $context["routeName"] : null) == $this->getAttribute($this->getAttribute($context["menuItem"], "module", array()), "mod_route", array()))) {
                        // line 58
                        echo "                    <li class=\"active\"><a href=\"";
                        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
                        echo "/web/front.php/";
                        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["menuItem"], "module", array()), "mod_route", array()), "html", null, true);
                        echo "\"><i
                            class=\"fa fa-";
                        // line 59
                        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["menuItem"], "module", array()), "mod_icon", array()), "html", null, true);
                        echo "\"></i>";
                        echo twig_escape_filter($this->env, $this->getAttribute($context["menuItem"], "menu_item_name", array()), "html", null, true);
                        echo "</a></li>

                    <script>\$('#dropDownMenu').toggleClass('active');</script>

                    ";
                    } else {
                        // line 64
                        echo "                    <li><a href=\"";
                        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
                        echo "/web/front.php/";
                        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["menuItem"], "module", array()), "mod_route", array()), "html", null, true);
                        echo "\"><i
                            class=\"fa fa-";
                        // line 65
                        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["menuItem"], "module", array()), "mod_icon", array()), "html", null, true);
                        echo "\"></i>";
                        echo twig_escape_filter($this->env, $this->getAttribute($context["menuItem"], "menu_item_name", array()), "html", null, true);
                        echo "</a></li>
                    ";
                    }
                    // line 67
                    echo "                    ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_iterated'], $context['_key'], $context['menuItem'], $context['_parent'], $context['loop']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 68
                echo "
                </ul>
            </li>
            ";
            } else {
                // line 72
                echo "
            ";
                // line 73
                if ( !(null === $this->getAttribute($context["menu"], "module", array()))) {
                    // line 74
                    echo "            ";
                    if (((isset($context["routeName"]) ? $context["routeName"] : null) == ("/" . $this->getAttribute($this->getAttribute($context["menu"], "module", array()), "mod_route", array())))) {
                        // line 75
                        echo "            <li class=\"active\"><a href=\"";
                        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
                        echo "/web/front.php/";
                        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["menu"], "module", array()), "mod_route", array()), "html", null, true);
                        echo "\"><i
                    class=\"fa fa-";
                        // line 76
                        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["menu"], "module", array()), "mod_icon", array()), "html", null, true);
                        echo "\"></i> <span
                    class=\"nav-label\">";
                        // line 77
                        echo twig_escape_filter($this->env, $this->getAttribute($context["menu"], "menu_name", array()), "html", null, true);
                        echo "</span> </a></li>
            ";
                    } else {
                        // line 79
                        echo "            <li><a href=\"";
                        echo twig_escape_filter($this->env, (isset($context["install_url"]) ? $context["install_url"] : null), "html", null, true);
                        echo "/web/front.php/";
                        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["menu"], "module", array()), "mod_route", array()), "html", null, true);
                        echo "\"><i
                    class=\"fa fa-";
                        // line 80
                        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute($context["menu"], "module", array()), "mod_icon", array()), "html", null, true);
                        echo "\"></i> <span
                    class=\"nav-label\">";
                        // line 81
                        echo twig_escape_filter($this->env, $this->getAttribute($context["menu"], "menu_name", array()), "html", null, true);
                        echo "</span> </a></li>
            ";
                    }
                    // line 83
                    echo "            ";
                }
                // line 84
                echo "            ";
            }
            // line 85
            echo "            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['menu'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 86
        echo "

        </ul>
    </div>
</nav>";
    }

    public function getTemplateName()
    {
        return "Menu_left.html";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  240 => 86,  234 => 85,  231 => 84,  228 => 83,  223 => 81,  219 => 80,  212 => 79,  207 => 77,  203 => 76,  196 => 75,  193 => 74,  191 => 73,  188 => 72,  182 => 68,  176 => 67,  169 => 65,  162 => 64,  152 => 59,  145 => 58,  142 => 57,  138 => 56,  133 => 54,  129 => 53,  123 => 52,  119 => 50,  116 => 49,  112 => 48,  97 => 35,  92 => 33,  87 => 32,  82 => 30,  77 => 29,  75 => 28,  63 => 19,  58 => 17,  54 => 16,  48 => 15,  42 => 12,  36 => 11,  27 => 7,  19 => 1,);
    }
}
