<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Block\Adminhtml\System\Config\Form\Field;

use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;

/**
 * Class RegionLinkingLink
 * @package Mantik\Bluemail\Block\Adminhtml\System\Config\Form\Field
 */
class DocumentationLink extends Field
{
    /**
     * @param AbstractElement $element
     *
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * @param AbstractElement $element
     *
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return sprintf(
            '<b>Developed by <a href="https://www.mantik.tech/" target="_blank"> Mantik Tech</a>. </b>View documentation <a href ="%s" target="_blank">%s</a>',
            'https://drive.google.com/drive/folders/1jEqEccF23dKHbNpQYlsRoQtjFYR35Rz3?usp=sharing',
            __('here')
        );
    }
}
