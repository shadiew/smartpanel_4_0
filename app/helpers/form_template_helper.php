<?php
defined('BASEPATH') OR exit('No direct script access allowed');

 /**
 * Create Form Template base on Elements
 * @param array $elements
 */
function render_elements_form($elements)
{
    $xhtml = null;
    if (!empty($elements)) {
        foreach ($elements as $element) {
            $xhtml .= render_element_form($element);
        }
    }
    return $xhtml;
}

function render_element_form($element, $param = null)
{
    $xhtml = null;

    $type = (isset($element['type'])) ? $element['type'] : 'input';
    switch ($type) {
        
        case 'input':
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="form-group">
                        %s
                        %s
                    </div>
                </div> ',
                $element['class_main'],
                $element['label'],
                $element['element']
            );
            break;

        case 'password':
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="form-group">
                        %s
                        %s
                    </div>
                </div> ',
                $element['class_main'],
                $element['label'],
                $element['element']
            );
            break;

        case 'switch':
            $xhtml = sprintf(
                '<div class="%s">
                    <label class="custom-switch">      
                        %s
                        <span class="custom-switch-indicator"></span>
                        <span class="custom-switch-description">%s</span> 
                    </label>
                </div> ', $element['class_main'], $element['element'], $element['label']
            );
            break;

        case 'checkbox':
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="form-group">
                        <div class="custom-controls-stacked">
                            <label class="form-check">
                                %s
                                <span class="custom-control-label">&nbsp;%s</span>
                            </label>
                        </div>
                    </div>
                </div> ', $element['class_main'], $element['element'], $element['label']
            );
            break;

        case 'exchange_option':
            $item1_title = $element['item1']['name'];
            $item2_title = $element['item2']['name'];
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="form-group">
                        %s
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text">1 %s =</span>
                            </span>
                            %s
                            <span class="input-group-append">
                                <span class="input-group-text new-currency-code"> %s </span>
                            </span>
                        </div>
                    </div>
                </div>', $element['class_main'], $element['label'], $item1_title, $element['element'], $item2_title
            );
            break;

        case 'admin-change-provider-service-list':
            $xhtml = sprintf(
                '<div class="%s">
                    <div class="dimmer">
                    <div class="loader"></div>
                    <div class="dimmer-content">
                        %s
                        %s
                    </div>
                    </div>
                </div>', $element['class_main'], $element['label'], $element['element']
            );
            break;

        case 'button':
            $xhtml = sprintf(
                '<div class="ln_solid"></div>
                <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        %s
                    </div>
                </div>',
                $element['element']
            );
    }

    return $xhtml;
}