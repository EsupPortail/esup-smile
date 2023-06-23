<?php


namespace Application\Application\View\Renderer;

use Laminas\View\Helper\AbstractHelper;

class BackButtonViewHelper extends AbstractHelper
{
    protected $libelle;

    /**
     * @param mixed $value
     * @return BackButtonViewHelper
     */
    public function __invoke($libelle=null) : BackButtonViewHelper
    {
        $this->libelle = $libelle;
        return $this;
    }

    /**
     * @return string|null
     */
    public function __toString()
    {
        return $this->render();
    }

    /**
     * @return string|null
     */
    public function render()
    {
        return
            sprintf('<a class="btn btn-medium btn-back"
                data-toggle="tooltip"
                data-placement="bottom"
                data-original-title="Retour">
                <span class="icon icon-retour"></span> %s
            </a>', $this->libelle);
    }

    public function backTo($url){
        return sprintf(
            '<a class="btn btn-medium btn-back"
                data-toggle="tooltip"
                data-placement="bottom"
                data-original-title="Retour"         
                data-url="%s"   
                >
                <span class="icon icon-retour"></span> %s
            </a>', $url, $this->libelle
        );
    }
}