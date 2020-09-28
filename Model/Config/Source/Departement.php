<?php
/**
 * Copyright ©  2020. Mantik Tech.
 * All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

declare(strict_types=1);

namespace Mantik\Bluemail\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Departement
 * @package Mantik\Bluemail\Model\Config\Source
 */
class Departement implements OptionSourceInterface
{
    /**
     * @var \Mantik\Bluemail\Model\BluemailApi\Department
     */
    protected $departement;

    /**
     * Departement constructor.
     *
     * @param \Mantik\Bluemail\Model\BluemailApi\Department $departement
     */
    public function __construct(
        \Mantik\Bluemail\Model\BluemailApi\Department $departement
    ) {
        $this->departement = $departement;
    }

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $options = [];
        $options[] = [
            'value' => '',
            'label' => 'Select a departement'
        ];

        $departements = $this->departement->getDepartements();
        if (!empty($departements) && !empty($departements['Departments'])) {
            foreach ($departements['Departments'] as $departement) {
                $options[] = [
                    'value' => $departement['id'],
                    'label' => $departement['name']
                ];
            }
        }

        return $options;
    }
}
