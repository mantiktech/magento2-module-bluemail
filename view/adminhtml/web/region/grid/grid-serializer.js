/*
 * Copyright ©  2020. Mantik Tech.  All rights reserved under CC BY-NC-SA 4.0 licence.
 * See LICENSE file for more details.
 * @link https://www.mantik.tech/
 */

/* global $, $H */

define([
    'mage/adminhtml/grid'
], function () {
    'use strict';

    return function (config) {
        let regionLinks = $H(config.regionLinks),
            gridJsObject = window[config.gridJsObjectName];

        $('region_links').value = Object.toJSON(regionLinks);

        /**
         * Change region link
         *
         * @param {String} event
         */
        function regionLinkChange(event) {
            let element = Event.element(event);

            if (element) {
                regionLinks.set(element.regionIdElement.innerText, element.options[element.selectedIndex].value);
                $('region_links').value = Object.toJSON(regionLinks);
            }
        }

        /**
         * Disable already selected options
         *
         * @param {Object} grid
         * @param {Number} selectedOptionIndex
         */
        function disableSelectedOption(grid, selectedOptionIndex) {
            //TODO disable option on selection
        }

        /**
         * Initialize region link row
         *
         * @param {Object} grid
         * @param {String} row
         */
        function RegionLinkRowInit(grid, row) {
            let regionId = $(row).getElementsByClassName('col-region_id')[0],
                regionLinkSelect = $(row).querySelectorAll(':scope .col-bluemail_region_id > select[name="bluemail_region_id"]')[0],
                selectedIndexValue,
                option;

            if (regionId && regionLinkSelect) {
                regionId.regionLinkSelectElement = regionLinkSelect;
                regionLinkSelect.regionIdElement = regionId;

                selectedIndexValue = regionLinks.get(regionId.innerText);
                if (selectedIndexValue) {
                    for (let i = 0; i < regionLinkSelect.options.length; i++) {
                        option = regionLinkSelect.options[i];
                        if (option.value == selectedIndexValue) {
                            regionLinkSelect.selectedIndex = i;
                            break;
                        }
                    }
                }

                Event.observe(regionLinkSelect, 'change', regionLinkChange);
            }
        }

        gridJsObject.initRowCallback = RegionLinkRowInit;

        if (gridJsObject.rows) {
            gridJsObject.rows.each(function (row) {
                RegionLinkRowInit(gridJsObject, row);
            });
        }
    };
});
