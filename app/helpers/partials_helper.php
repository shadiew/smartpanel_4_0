<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * From V3.6
 * @param array $data_filter
 * @param name $controller Name
 * @return HTML Render HTML for page header filter
 * @author Seji2906
 */
if (!function_exists('show_page_header_filter')) {
    function show_page_header_filter($controller_name, $data_filter = [])
    {
        $xhtml = null;
        $show_by_status_button = show_filter_status_button($controller_name, $data_filter['items_status_count'], $data_filter['params']);
        $show_search_area      = show_search_area($controller_name, $data_filter['params']);
        $xhtml = sprintf(
            '<div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Filter</h3>
                            <div class="card-options">
                                <a href="#" class="card-options-collapse" data-toggle="card-collapse"><i class="fe fe-chevron-up"></i></a>
                                <a href="#" class="card-options-remove" data-toggle="card-remove"><i class="fe fe-x"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                 %s
                                </div>
                                <div class="col-md-4 search-area">
                                 %s
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>', $show_by_status_button, $show_search_area
        );
        return $xhtml;
    }
}

/**
 * From V3.6
 * @param array $params
 * @param name $controller Name
 * @return HTML Render HTML for page header (page title, page-options)
 * @author Seji2906
 */
if (!function_exists('show_page_header')) {
    function show_page_header($controller_name, $params = [])
    {
        $xhtml = null;
        $tmpl_config   = app_config('controller')['admin'];
        $current_controller = (array_key_exists($controller_name, $tmpl_config)) ? $tmpl_config[$controller_name] : $tmpl_config['default'];
        $xhtml_page_options = null;
        $class_page_type = (isset($params['page-options-type']) && $params['page-options-type'] == 'ajax-modal') ? 'ajaxModal' : '';
        switch ($params['page-options']) {
            case 'add-new':
                $add_new_link = admin_url($controller_name . "/update");
                $xhtml_page_options = sprintf(
                    '<div class="d-flex">
                        <a href="%s" class="ml-auto btn btn-outline-primary %s">
                            <span class="fe fe-plus"></span>
                            Add new
                        </a>
                    </div>', $add_new_link, $class_page_type
                );
                break;
            case 'search':
                $show_search_area = show_search_area($controller_name, $params['search_params']);
                $xhtml_page_options = sprintf(
                    '<div class="search-area">
                        %s
                    </div>', $show_search_area
                );
                break;
        }

        $xhtml = sprintf(
            '<div class="page-title m-b-20">
                <div class="row justify-content-between">
                    <div class="col-md-2">
                        <h1 class="page-title">
                            <span class="%s"></span> %s
                        </h1>
                    </div>
                    <div class="col-md-3">
                        %s
                    </div>
                </div>
            </div>', $current_controller['icon'], $current_controller['name'], $xhtml_page_options
        );
        return $xhtml;
    }
}

