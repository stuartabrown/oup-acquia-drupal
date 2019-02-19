<?php

/* core/modules/system/templates/page.html.twig */
class __TwigTemplate_491d354868c23a7cdc36790829dd9700797f10bbfee01afc733f74972d1a5ac2 extends Twig_Template
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
        $tags = ["if" => 70];
        $filters = [];
        $functions = [];

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                ['if'],
                [],
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

        // line 48
        echo "<div class=\"layout-container\">

  <header role=\"banner\">
    ";
        // line 51
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "header", []), "html", null, true));
        echo "
  </header>

  ";
        // line 54
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "primary_menu", []), "html", null, true));
        echo "
  ";
        // line 55
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "secondary_menu", []), "html", null, true));
        echo "

  ";
        // line 57
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "breadcrumb", []), "html", null, true));
        echo "

  ";
        // line 59
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "highlighted", []), "html", null, true));
        echo "

  ";
        // line 61
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "help", []), "html", null, true));
        echo "

  <main role=\"main\">
    <a id=\"main-content\" tabindex=\"-1\"></a>";
        // line 65
        echo "
    <div class=\"layout-content\">
      ";
        // line 67
        echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "content", []), "html", null, true));
        echo "
    </div>";
        // line 69
        echo "
    ";
        // line 70
        if ($this->getAttribute(($context["page"] ?? null), "sidebar_first", [])) {
            // line 71
            echo "      <aside class=\"layout-sidebar-first\" role=\"complementary\">
        ";
            // line 72
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "sidebar_first", []), "html", null, true));
            echo "
      </aside>
    ";
        }
        // line 75
        echo "
    ";
        // line 76
        if ($this->getAttribute(($context["page"] ?? null), "sidebar_second", [])) {
            // line 77
            echo "      <aside class=\"layout-sidebar-second\" role=\"complementary\">
        ";
            // line 78
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "sidebar_second", []), "html", null, true));
            echo "
      </aside>
    ";
        }
        // line 81
        echo "
  </main>

  ";
        // line 84
        if ($this->getAttribute(($context["page"] ?? null), "footer", [])) {
            // line 85
            echo "    <footer role=\"contentinfo\">
      ";
            // line 86
            echo $this->env->getExtension('Twig_Extension_Sandbox')->ensureToStringAllowed($this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->getAttribute(($context["page"] ?? null), "footer", []), "html", null, true));
            echo "
    </footer>
  ";
        }
        // line 89
        echo "
</div>";
    }

    public function getTemplateName()
    {
        return "core/modules/system/templates/page.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  131 => 89,  125 => 86,  122 => 85,  120 => 84,  115 => 81,  109 => 78,  106 => 77,  104 => 76,  101 => 75,  95 => 72,  92 => 71,  90 => 70,  87 => 69,  83 => 67,  79 => 65,  73 => 61,  68 => 59,  63 => 57,  58 => 55,  54 => 54,  48 => 51,  43 => 48,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "core/modules/system/templates/page.html.twig", "/var/www/html/web/core/modules/system/templates/page.html.twig");
    }
}
