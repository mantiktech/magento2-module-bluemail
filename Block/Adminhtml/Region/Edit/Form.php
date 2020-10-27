<?php
/**
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

namespace Mantik\Bluemail\Block\Adminhtml\Region\Edit;

use Magento\Backend\Block\Widget\Form\Generic;

/**
 * Class Form
 * @package Mantik\Bluemail\Block\Adminhtml\Region\Edit
 */
class Form extends Generic
{
    /**
     * @return Generic
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareForm()
    {
        $form = $this->_formFactory->create(
            [
                'data' => [
                    'id'      => 'edit_form',
                    'action'  => $this->getUrl('*/*/save'),
                    'method'  => 'post',
                    'enctype' => 'multipart/form-data'
                ]
            ]
        );
        $form->setUseContainer(true);
        $this->setForm($form);

        return parent::_prepareForm();
    }
}
