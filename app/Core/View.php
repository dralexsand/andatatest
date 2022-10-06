<?php


namespace App\Core;

class View extends BaseView
{
    public function render(string $templateName, array $params = [])
    {
        extract($params);
        ob_start();
        include __DIR__ . $this->templatesPath . '/' . $this->getTemplate($templateName);
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }

    public function getTemplate(string $templateNameWithoutExtension)
    {
        // ToDo exist file?
        return $templateNameWithoutExtension . '.php';
    }
}