<?php

/* themes/custom/oxfordpath/block--menu-group.html.twig */
class __TwigTemplate_bfd900098469e3c8d8c5fff6f4b30206f288d5dc1b20bea43fb608fe53147799 extends Twig_Template
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
        $tags = ["set" => 28];
        $filters = ["length" => 28];
        $functions = [];

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                ['set'],
                ['length'],
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
        $context["menu_block_cnt"] = (($this->getAttribute($this->getAttribute(($context["content"] ?? null), "field_menu_block_updated", []), "#items", [], "array")) ? (twig_length_filter($this->env, $this->getAttribute($this->getAttribute(($context["content"] ?? null), "field_menu_block_updated", []), "#items", [], "array"))) : (0));
        // line 29
        $context["width_style"] = ((($context["menu_block_cnt"] ?? null)) ? ((("width:" . (($context["menu_block_cnt"] ?? null) * 25)) . "vw;")) : (""));
        // line 30
        echo "
<div";
        // line 31
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["attributes"] ?? null), "html", null, true));
        echo " style=\"";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["width_style"] ?? null), "html", null, true));
        echo "\">
    ";
        // line 32
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["title_prefix"] ?? null), "html", null, true));
        echo "
    ";
        // line 33
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, ($context["title_suffix"] ?? null), "html", null, true));
        echo "
    <ul class=\"vertical menu accordion-menu\">
        <li>
            ";
        // line 36
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["content"] ?? null), "field_title", []), "html", null, true));
        echo "
            ";
        // line 37
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["content"] ?? null), "field_menu_block_updated", []), "html", null, true));
        echo "
        </li>
    </ul>
</div>
";
    }

    public function getTemplateName()
    {
        return "themes/custom/oxfordpath/block--menu-group.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  70 => 37,  66 => 36,  60 => 33,  56 => 32,  50 => 31,  47 => 30,  45 => 29,  43 => 28,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "themes/custom/oxfordpath/block--menu-group.html.twig", "/var/www/html/web/themes/custom/oxfordpath/block--menu-group.html.twig");
    }
}
