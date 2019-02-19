<?php

/* themes/custom/oxfordpath/block--basic-image-block.html.twig */
class __TwigTemplate_83e41078fb414c29ac8281b28246ae9fb09629bdb0149009fbd414728eb5d4bc extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $tags = ["if" => 28, "set" => 29];
        $filters = ["lower" => 29, "render" => 29, "trim" => 35, "striptags" => 35, "clean_class" => 37];
        $functions = [];

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                ['if', 'set'],
                ['lower', 'render', 'trim', 'striptags', 'clean_class'],
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
        if ($this->getAttribute($this->getAttribute(($context["content"] ?? null), "field_position", []), 0, [])) {
            // line 29
            echo "    ";
            $context["imagePositionClass"] = ("image-position-" . twig_lower_filter($this->env, $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute($this->getAttribute(($context["content"] ?? null), "field_position", []), 0, []))));
        }
        // line 31
        echo "
<div";
        // line 32
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["attributes"] ?? null), "addClass", [0 => ($context["imagePositionClass"] ?? null)], "method"), "html", null, true));
        echo ">
    ";
        // line 33
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["title_prefix"] ?? null), "html", null, true));
        echo "
    ";
        // line 34
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["title_suffix"] ?? null), "html", null, true));
        echo "
    ";
        // line 35
        $context["link_enabled"] = twig_trim_filter(strip_tags($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute(($context["content"] ?? null), "field_link_enabled", []))));
        // line 36
        echo "    ";
        if (((($context["link_enabled"] ?? null) != "") && (($context["link_enabled"] ?? null) != "0"))) {
            // line 37
            echo "        <a class=\"";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, \Drupal\Component\Utility\Html::getClass((($context["block_type"] ?? null) . "-link")), "html", null, true));
            echo "\" title=\"";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, twig_trim_filter(strip_tags($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute($this->getAttribute($this->getAttribute(($context["content"] ?? null), "field_link", []), 0, []), "#title", [], "array")))), "html", null, true));
            echo "\" href=\"";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, twig_trim_filter(strip_tags($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute($this->getAttribute($this->getAttribute(($context["content"] ?? null), "field_link", []), 0, []), "#url", [], "array")))), "html", null, true));
            echo "\" target=\"";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, twig_trim_filter(strip_tags($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute(($context["content"] ?? null), "field_link_format", [])))), "html", null, true));
            echo "\">";
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["content"] ?? null), "field_image", []), "html", null, true));
            echo "</a>
    ";
        } else {
            // line 39
            echo "        ";
            $context["popup_enabled"] = twig_trim_filter(strip_tags($this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar($this->getAttribute(($context["content"] ?? null), "field_popup", []))));
            // line 40
            echo "        ";
            if (((($context["popup_enabled"] ?? null) != "") && (($context["popup_enabled"] ?? null) != "0"))) {
                // line 41
                echo "            <a class=\"";
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, (($context["block_type"] ?? null) . "-popup"), "html", null, true));
                echo "\" data-showinpopup>";
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["content"] ?? null), "field_image", []), "html", null, true));
                echo "</a>
        ";
            } else {
                // line 43
                echo "            ";
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["content"] ?? null), "field_image", []), "html", null, true));
                echo "
        ";
            }
            // line 45
            echo "    ";
        }
        // line 46
        echo "</div>
";
    }

    public function getTemplateName()
    {
        return "themes/custom/oxfordpath/block--basic-image-block.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  106 => 46,  103 => 45,  97 => 43,  89 => 41,  86 => 40,  83 => 39,  69 => 37,  66 => 36,  64 => 35,  60 => 34,  56 => 33,  52 => 32,  49 => 31,  45 => 29,  43 => 28,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "themes/custom/oxfordpath/block--basic-image-block.html.twig", "/var/www/html/web/themes/custom/oxfordpath/block--basic-image-block.html.twig");
    }
}
