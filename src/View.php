<?php
namespace Base;

class View
{
    private $templatePath = "";
    private $data = [];
    private $twig;

    public function __construct()
    {
        $this->templatePath =  PROJECT_ROOT_DIR . DIRECTORY_SEPARATOR . 'app/View';
    }

    /**
     * @param string $tpl
     * @param array $data
     * @return string
     */
    public function render (string $tpl, array $data = []): string
    {
        $this->data += $data;
        ob_start();
        include $this->templatePath . DIRECTORY_SEPARATOR . $tpl;
        return ob_get_clean();
    }

    /**
     * @param string $name
     * @param $value
     */
    public function assign (string $name, $value): void
    {
        $this->data[$name] = $value;
    }

    public function __get($varName)
    {
        return $this->data[$varName] ?? null;
    }

    public function renderTwig (string $tpl, array $data = []): string
    {
        if (!$this->twig) {
            $loader = new \Twig\Loader\FilesystemLoader($this->templatePath);
            $this->twig = new \Twig\Environment($loader);
        }

        return $this->twig->render($tpl, $data);
    }
}
