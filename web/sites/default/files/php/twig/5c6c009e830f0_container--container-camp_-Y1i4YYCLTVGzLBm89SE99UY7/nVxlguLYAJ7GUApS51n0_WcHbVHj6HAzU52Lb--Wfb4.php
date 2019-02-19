<?php

/* themes/custom/oxfordpath/container--container-campaign-summary.html.twig */
class __TwigTemplate_0b8f8101de48d9e6ab90678892c10bace5fdfd252fe9d850034b059f19cee03f extends Twig_Template
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
        $tags = ["set" => 23, "if" => 31, "for" => 33];
        $filters = ["length" => 30];
        $functions = [];

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                ['set', 'if', 'for'],
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

        // line 23
        $context["classes"] = [0 => ((        // line 24
($context["has_parent"] ?? null)) ? ("js-form-wrapper") : ("")), 1 => ((        // line 25
($context["has_parent"] ?? null)) ? ("form-wrapper") : (""))];
        // line 28
        echo "<div";
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["attributes"] ?? null), "addClass", [0 => ($context["classes"] ?? null)], "method"), "html", null, true));
        echo ">
    <div>
    ";
        // line 30
        $context["children_cnt"] = twig_length_filter($this->env, $this->getAttribute(($context["children"] ?? null), "items", []));
        // line 31
        echo "    ";
        if ((($context["children_cnt"] ?? null) > 0)) {
            // line 32
            echo "        <ul>
            ";
            // line 33
            $context['_parent'] = $context;
            $context['_seq'] = twig_ensure_traversable($this->getAttribute(($context["children"] ?? null), "items", []));
            foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                // line 34
                echo "                <li><span class=\"key\">";
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($context["item"], "label", []), "html", null, true));
                echo "</span>";
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($context["item"], "separator", []), "html", null, true));
                echo "<span class=\"value\">";
                echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute($context["item"], "value", []), "html", null, true));
                echo "</span></li>
            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_iterated'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 36
            echo "        </ul>
    ";
        }
        // line 38
        echo "    </div>
</div>
";
    }

    public function getTemplateName()
    {
        return "themes/custom/oxfordpath/container--container-campaign-summary.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  82 => 38,  78 => 36,  65 => 34,  61 => 33,  58 => 32,  55 => 31,  53 => 30,  47 => 28,  45 => 25,  44 => 24,  43 => 23,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "themes/custom/oxfordpath/container--container-campaign-summary.html.twig", "/var/www/html/web/themes/custom/oxfordpath/container--container-campaign-summary.html.twig");
    }
}
