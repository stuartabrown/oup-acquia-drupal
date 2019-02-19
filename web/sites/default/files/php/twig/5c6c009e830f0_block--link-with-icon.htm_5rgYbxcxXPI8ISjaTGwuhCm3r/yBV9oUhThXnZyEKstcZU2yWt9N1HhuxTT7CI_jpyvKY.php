<?php

/* themes/custom/oxfordpath/block--link-with-icon.html.twig */
class __TwigTemplate_5e508ccbce12deb0545af65edbc6a0975bbf95c5c21bc8bafe3f7e76c03130a5 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'content' => [$this, 'block_content'],
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $tags = ["if" => 30, "block" => 34, "set" => 35];
        $filters = ["trim" => 35, "striptags" => 35, "render" => 35, "join" => 39];
        $functions = [];

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                ['if', 'block', 'set'],
                ['trim', 'striptags', 'render', 'join'],
                []
            );
        } catch (Twig_Sandbox_SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

        // line 28
        echo "<div";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["attributes"] ?? null), "html", null, true));
        echo ">
    ";
        // line 29
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["title_prefix"] ?? null), "html", null, true));
        echo "
    ";
        // line 30
        if (($context["label"] ?? null)) {
            // line 31
            echo "        <h2";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["title_attributes"] ?? null), "html", null, true));
            echo ">";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["label"] ?? null), "html", null, true));
            echo "</h2>
    ";
        }
        // line 33
        echo "    ";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["title_suffix"] ?? null), "html", null, true));
        echo "
    ";
        // line 34
        $this->displayBlock('content', $context, $blocks);
        // line 53
        echo "</div>
";
    }

    // line 34
    public function block_content($context, array $blocks = [])
    {
        // line 35
        echo "        ";
        $context["icon_position"] = (($this->getAttribute(($context["content"] ?? null), "field_icon_position", [])) ? (twig_trim_filter(strip_tags($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute(($context["content"] ?? null), "field_icon_position", []))))) : ("left"));
        // line 36
        echo "        ";
        $context["link_class"] = twig_join_filter([0 => (        // line 37
($context["block_type"] ?? null) . "__field_link"), 1 => ((        // line 38
($context["block_type"] ?? null) . "__field_link--icon-") . ($context["icon_position"] ?? null))], " ");
        // line 40
        echo "
        ";
        // line 41
        $context["link_title"] = twig_trim_filter(strip_tags($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute($this->getAttribute($this->getAttribute(($context["content"] ?? null), "field_link", []), 0, []), "#title", [], "array"))));
        // line 42
        echo "
        <a class=\"";
        // line 43
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["link_class"] ?? null), "html", null, true));
        echo "\" title=\"";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["link_title"] ?? null), "html", null, true));
        echo "\" href=\"";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, twig_trim_filter(strip_tags($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute($this->getAttribute($this->getAttribute(($context["content"] ?? null), "field_link", []), 0, []), "#url", [], "array")))), "html", null, true));
        echo "\" target=\"";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, twig_trim_filter(strip_tags($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute(($context["content"] ?? null), "field_link_format", [])))), "html", null, true));
        echo "\">
            ";
        // line 44
        if ((($context["icon_position"] ?? null) != "right")) {
            // line 45
            echo "                ";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["content"] ?? null), "field_icon", []), "html", null, true));
            echo "
            ";
        }
        // line 47
        echo "            <span class=\"";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["block_type"] ?? null), "html", null, true));
        echo "__link-text\">";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, twig_trim_filter(strip_tags($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute($this->getAttribute($this->getAttribute(($context["content"] ?? null), "field_link", []), 0, []), "#title", [], "array")))), "html", null, true));
        echo "</span>
            ";
        // line 48
        if ((($context["icon_position"] ?? null) == "right")) {
            // line 49
            echo "                ";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["content"] ?? null), "field_icon", []), "html", null, true));
            echo "
            ";
        }
        // line 51
        echo "        </a>
    ";
    }

    public function getTemplateName()
    {
        return "themes/custom/oxfordpath/block--link-with-icon.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  127 => 51,  121 => 49,  119 => 48,  112 => 47,  106 => 45,  104 => 44,  94 => 43,  91 => 42,  89 => 41,  86 => 40,  84 => 38,  83 => 37,  81 => 36,  78 => 35,  75 => 34,  70 => 53,  68 => 34,  63 => 33,  55 => 31,  53 => 30,  49 => 29,  44 => 28,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "themes/custom/oxfordpath/block--link-with-icon.html.twig", "/var/www/html/web/themes/custom/oxfordpath/block--link-with-icon.html.twig");
    }
}
