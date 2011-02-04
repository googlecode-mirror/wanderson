<?php

/**
 * Nó de Documento Html
 * @author Wanderson Henrique Camargo Rosa
 */
class HtmlNode extends NodeAbstract
{
    public function _render($level)
    {
        $name   = $this->getName();
        $params = $this->getParams();
        $closed = $this->getClosed();

        $values = array();
        foreach ($params as $name => $value) {
            $values .= "$name=\"$value\" ";
        }
        $values = implode(' ', $values);
        $values = empty($values) ? '' : " $values";

        $output = null;
        if ($closed) {
            $output = "<$name$values/>";
        } else {
            $content = '';
            $nodes   = $this->getContentNodes();
            foreach ($nodes as $element) {
                $content .= $element->render($level);
            }
            $output = "<$name$values>$content</$name>";
        }

        return $output;
    }
}