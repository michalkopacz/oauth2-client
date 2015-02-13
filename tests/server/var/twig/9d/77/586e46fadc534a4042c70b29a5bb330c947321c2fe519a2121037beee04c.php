<?php

/* Hello {{ request.query.get('name') }}!
 */
class __TwigTemplate_9d77586e46fadc534a4042c70b29a5bb330c947321c2fe519a2121037beee04c extends Twig_Template
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
        echo "Hello ";
        echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["request"]) ? $context["request"] : null), "query", array()), "get", array(0 => "name"), "method"), "html", null, true);
        echo "!
";
    }

    public function getTemplateName()
    {
        return "Hello {{ request.query.get('name') }}!
";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  20 => 1,);
    }
}
